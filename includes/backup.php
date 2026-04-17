<?php
if(isset($_POST['backup'])) {
    $backupFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $command = "mysqldump --user=root --password= --host=localhost malawi_marketplace > " . $backupFile;
    system($command);
    // Provide download link
}
?>