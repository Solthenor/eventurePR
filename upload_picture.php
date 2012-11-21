<?php
require_once('mobileRedirect.php');
require_once('logoutHandler.php');
require_once('db.php');
require_once('checkAuth.php');


$picID = 0;

$db = db::getInstance();

if ($_FILES["photo"]["error"] == 0) {

$type = str_replace('image/', '', $_FILES['photo']['type']);

$fileName = $_FILES['photo']['name'];
$tmpName  = $_FILES['photo']['tmp_name'];
$fileSize = $_FILES['photo']['size'];
$fileType = $_FILES['photo']['type'];

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

$sql = "INSERT INTO Picture
SET
picID = '0',
userID = '0',
ext = '{$type}',
data = '{$content}'";

$stmt = $db->prepare($sql);
$stmt->execute();
}
?>