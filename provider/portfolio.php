<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';
requireRole('provider');
$user = getCurrentUser();
$db = getDb();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions

// Ensure portfolio exists
$stmt = $db->prepare("SELECT * FROM portfolios WHERE user_id = ?");
$stmt->execute([$user['id']]);
$portfolio = $stmt->fetch();
if (!$portfolio) {
    $stmt = $db->prepare("INSERT INTO portfolios (user_id, location) VALUES (?, ?)");
    $stmt->execute([$user['id'], $user['location']]);
    $portfolioId = $db->lastInsertId();
    $stmt = $db->prepare("SELECT * FROM portfolios WHERE id = ?");
    $stmt->execute([$portfolioId]);
    $portfolio = $stmt->fetch();
}
$portfolioId = $portfolio['id'];

// Handle POST submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['save_basic'])) {
        $bio = $_POST['bio'] ?? '';
        $exp = (int)($_POST['experience_years'] ?? 0);
        $rate = (float)($_POST['hourly_rate'] ?? 0);
        $loc = $_POST['location'] ?? $user['location'];
        $cat = (int)($_POST['category_id'] ?? 0);
        $stmt = $db->prepare("UPDATE portfolios SET bio=?, experience_years=?, hourly_rate=?, location=?, category_id=? WHERE id=?");
        $stmt->execute([$bio, $exp, $rate, $loc, $cat, $portfolioId]);
    }
    if (isset($_POST['save_skills'])) {
        $db->prepare("DELETE FROM skills WHERE portfolio_id=?")->execute([$portfolioId]);
        foreach ($_POST['skills'] as $skill) {
            if (trim($skill)) {
                $stmt = $db->prepare("INSERT INTO skills (portfolio_id, skill_name) VALUES (?, ?)");
                $stmt->execute([$portfolioId, trim($skill)]);
            }
        }
    }
    if (isset($_POST['save_qualifications'])) {
        $db->prepare("DELETE FROM qualifications WHERE portfolio_id=?")->execute([$portfolioId]);
        $degrees = $_POST['qualifications']['degree'] ?? [];
        $institutions = $_POST['qualifications']['institution'] ?? [];
        $years = $_POST['qualifications']['year'] ?? [];
        for ($i = 0; $i < count($degrees); $i++) {
            if (!empty($degrees[$i])) {
                $stmt = $db->prepare("INSERT INTO qualifications (portfolio_id, degree, institution, year) VALUES (?, ?, ?, ?)");
                $stmt->execute([$portfolioId, $degrees[$i], $institutions[$i] ?? '', $years[$i] ?? null]);
            }
        }
    }
    if (isset($_POST['add_project'])) {
        $title = $_POST['project_title'];
        $desc = $_POST['project_desc'];
        $images = [];
        $videos = [];
        if (!empty($_FILES['project_images']['name'][0])) {
            foreach ($_FILES['project_images']['tmp_name'] as $k => $tmp) {
                $imgPath = uploadFile(['name' => $_FILES['project_images']['name'][$k], 'tmp_name' => $tmp], 'projects/');
                if ($imgPath) $images[] = $imgPath;
            }
        }
        if (!empty($_FILES['project_videos']['name'][0])) {
            foreach ($_FILES['project_videos']['tmp_name'] as $k => $tmp) {
                $vidPath = uploadFile(['name' => $_FILES['project_videos']['name'][$k], 'tmp_name' => $tmp], 'videos/');
                if ($vidPath) $videos[] = $vidPath;
            }
        }
        $stmt = $db->prepare("INSERT INTO projects (portfolio_id, title, description, images, videos) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$portfolioId, $title, $desc, implode(',', $images), implode(',', $videos)]);
    }

    // Check completion – SAFE version (no direct fetchColumn on bool)
    $skillCount = 0;
    $stmt = $db->prepare("SELECT COUNT(*) as cnt FROM skills WHERE portfolio_id = ?");
    if ($stmt->execute([$portfolioId])) {
        $skillCount = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
    }
    $qualCount = 0;
    $stmt = $db->prepare("SELECT COUNT(*) as cnt FROM qualifications WHERE portfolio_id = ?");
    if ($stmt->execute([$portfolioId])) {
        $qualCount = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
    }
    $projCount = 0;
    $stmt = $db->prepare("SELECT COUNT(*) as cnt FROM projects WHERE portfolio_id = ?");
    if ($stmt->execute([$portfolioId])) {
        $projCount = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
    }
    $hasLocation = !empty($portfolio['location']);
    $hasCategory = !empty($portfolio['category_id']);
    $complete = ($skillCount > 0) && ($qualCount > 0) && ($projCount > 0) && $hasLocation && $hasCategory;
    if ($complete) {
        $db->prepare("UPDATE users SET is_profile_complete = 1 WHERE id = ?")->execute([$user['id']]);
        header('Location: dashboard.php?msg=profile_complete');
        exit;
    }
}

// Fetch existing data
$skills = $db->prepare("SELECT * FROM skills WHERE portfolio_id = ?");
$skills->execute([$portfolioId]);
$qualifications = $db->prepare("SELECT * FROM qualifications WHERE portfolio_id = ?");
$qualifications->execute([$portfolioId]);
$projects = $db->prepare("SELECT * FROM projects WHERE portfolio_id = ? ORDER BY completion_date DESC");
$projects->execute([$portfolioId]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complete Your Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <div class="alert alert-warning">Please complete your profile before you can receive bookings.</div>
    <form method="POST" enctype="multipart/form-data">
        <!-- Basic Info -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">Basic Information</div>
            <div class="card-body">
                <textarea name="bio" class="form-control mb-2" placeholder="Short bio"><?= htmlspecialchars($portfolio['bio'] ?? '') ?></textarea>
                <input type="number" name="experience_years" class="form-control mb-2" placeholder="Years of experience" value="<?= $portfolio['experience_years'] ?? 0 ?>">
                <input type="number" name="hourly_rate" class="form-control mb-2" placeholder="Hourly rate (MWK)" value="<?= $portfolio['hourly_rate'] ?? 0 ?>">
                <select name="location" class="form-select mb-2">
                    <option value="">Select location</option>
                    <?php foreach(['Lilongwe','Blantyre','Mzuzu','Zomba','Balaka','Chikwawa','Chiradzulu','Chitipa','Dedza','Dowa','Karonga','Kasungu','Machinga','Mangochi','Mchinji','Mulanje','Mwanza','Mzimba','Neno',
                    'Nkhatabay','Nkhotakota','Nsanje','Ntcheu','Ntchisi','Phalombe','Rumphi','Salima','Thyolo'] as $loc): ?>
                        <option value="<?= $loc ?>" <?= ($portfolio['location'] ?? '') == $loc ? 'selected' : '' ?>><?= $loc ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="category_id" class="form-select mb-2">
                    <option value="">Select service category</option>
                    <?php $cats = $db->query("SELECT id, name FROM service_categories WHERE is_active=1"); while($c = $cats->fetch()): ?>
                        <option value="<?= $c['id'] ?>" <?= ($portfolio['category_id'] ?? 0) == $c['id'] ? 'selected' : '' ?>><?= $c['name'] ?></option>
                    <?php endwhile; ?>
                </select>
                <button type="submit" name="save_basic" class="btn btn-primary">Save Basic Info</button>
            </div>
        </div>

        <!-- Skills -->
        <div class="card mb-3">
            <div class="card-header bg-success text-white">Skills</div>
            <div class="card-body" id="skillsContainer">
                <?php $skillList = $skills->fetchAll(); if(empty($skillList)) $skillList = [['skill_name'=>'']]; ?>
                <?php foreach($skillList as $sk): ?>
                <div class="input-group mb-2">
                    <input type="text" name="skills[]" class="form-control" value="<?= htmlspecialchars($sk['skill_name']) ?>">
                    <button type="button" class="btn btn-danger remove-skill">-</button>
                </div>
                <?php endforeach; ?>
                <button type="button" id="addSkill" class="btn btn-sm btn-secondary">+ Add Skill</button>
                <button type="submit" name="save_skills" class="btn btn-success mt-2">Save Skills</button>
            </div>
        </div>

        <!-- Qualifications -->
        <div class="card mb-3">
            <div class="card-header bg-info text-white">Qualifications</div>
            <div class="card-body" id="qualsContainer">
                <?php $qualList = $qualifications->fetchAll(); if(empty($qualList)) $qualList = [['degree'=>'','institution'=>'','year'=>'']]; ?>
                <?php foreach($qualList as $q): ?>
                <div class="row mb-2 qual-row">
                    <div class="col-md-5"><input type="text" name="qualifications[degree][]" class="form-control" placeholder="Degree" value="<?= htmlspecialchars($q['degree']) ?>"></div>
                    <div class="col-md-5"><input type="text" name="qualifications[institution][]" class="form-control" placeholder="Institution" value="<?= htmlspecialchars($q['institution']) ?>"></div>
                    <div class="col-md-2"><input type="text" name="qualifications[year][]" class="form-control" placeholder="Year" value="<?= htmlspecialchars($q['year']) ?>"></div>
                </div>
                <?php endforeach; ?>
                <button type="button" id="addQual" class="btn btn-sm btn-secondary">+ Add Qualification</button>
                <button type="submit" name="save_qualifications" class="btn btn-success mt-2">Save Qualifications</button>
            </div>
        </div>

        <!-- Projects -->
        <div class="card mb-3">
            <div class="card-header bg-dark text-white">Projects (images/videos)</div>
            <div class="card-body">
                <div class="mb-2">
                    <input type="text" name="project_title" class="form-control mb-2" placeholder="Project Title">
                    <textarea name="project_desc" class="form-control mb-2" placeholder="Description"></textarea>
                    <label>Images (multiple):</label>
                    <input type="file" name="project_images[]" class="form-control mb-2" multiple accept="image/*">
                    <label>Videos (multiple):</label>
                    <input type="file" name="project_videos[]" class="form-control mb-2" multiple accept="video/*">
                    <button type="submit" name="add_project" class="btn btn-primary">Add Project</button>
                </div>
                <hr><h6>Existing Projects</h6><div class="row">
                <?php while($proj = $projects->fetch()): ?>
                <div class="col-md-4 mb-2">
                    <div class="card">
                        <img src="<?= explode(',', $proj['images'])[0] ?: 'assets/default-project.png' ?>" class="card-img-top" style="height:120px;object-fit:cover">
                        <div class="card-body"><strong><?= htmlspecialchars($proj['title']) ?></strong></div>
                    </div>
                </div>
                <?php endwhile; ?>
                </div>
            </div>
        </div>
        <button type="submit" name="check_complete" class="btn btn-success btn-lg">Mark Profile as Complete</button>
    </form>
</div>
<script>
document.getElementById('addSkill')?.addEventListener('click', () => {
    let div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = '<input type="text" name="skills[]" class="form-control"><button type="button" class="btn btn-danger remove-skill">-</button>';
    document.getElementById('skillsContainer').appendChild(div);
});
document.addEventListener('click', e => { if(e.target.classList.contains('remove-skill')) e.target.parentElement.remove(); });

document.getElementById('addQual')?.addEventListener('click', () => {
    let div = document.createElement('div');
    div.className = 'row mb-2 qual-row';
    div.innerHTML = '<div class="col-md-5"><input type="text" name="qualifications[degree][]" class="form-control" placeholder="Degree"></div><div class="col-md-5"><input type="text" name="qualifications[institution][]" class="form-control" placeholder="Institution"></div><div class="col-md-2"><input type="text" name="qualifications[year][]" class="form-control" placeholder="Year"></div>';
    document.getElementById('qualsContainer').insertBefore(div, document.getElementById('addQual').parentNode);
});
</script>
<?php include '../includes/footer.php'; ?>
</body>
</html>