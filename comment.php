<?php

require_once('db.php');

$id = $_GET['commentID'];

$db = db::getInstance();

$sql = "SELECT 
			content, 
			date,
			time 
		FROM Comment c 
		WHERE c.commentID = '{$id}'";
                                
$stmt = $db->prepare($sql);
// $stmt->bindParam(":id", $id, PDO::PARAM_STR);
$stmt->execute();
$comment = $stmt->fetch(PDO::FETCH_OBJ);

header('Content-Length: '.strlen($comment->content));
header("Content-type: text/$comment->time");

echo $comment->content;
?>