<?php  // This code is for getting the picture to display depending on the picID provided

require_once('db.php');

$id = $_GET['picID'];

$db = db::getInstance();

$sql = "SELECT 
			data, 
			ext 
		FROM Picture p 
		WHERE p.picID = '{$id}'";
                                
$stmt = $db->prepare($sql);
// $stmt->bindParam(":id", $id, PDO::PARAM_STR);
$stmt->execute();
$photo = $stmt->fetch(PDO::FETCH_OBJ);

header('Content-Length: '.strlen($photo->data));
header("Content-type: image/$photo->ext");

echo $photo->data;
?>