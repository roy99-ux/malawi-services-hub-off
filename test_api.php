<?php
echo "Testing API access<br>";
if (file_exists('api/register.php')) {
    echo "api/register.php exists";
} else {
    echo "api/register.php NOT found";
}