<?php
include "Image.php";

//This page is called to echo an page based on the data of the image
$imageID = $_GET["imageID"];

$image = new Image();
$image->Load($imageID);
?>
<img src=<?php echo '"uploads/' . $image->FileId . '"';?> alt="some_text">
<br/>

<?php
echo "<h1>" . $image->Name . "</h1> <h2>" . $image->Owner . "</h2> " . " <h3>" . $image->Score . "</h3>";
?>

<form action="postComment.php" method="post">
Comment: <input type="text" name="comment"/>
<input type="hidden" name="imageId" value=<?php echo '"' . $image->FileId . '"';?>/>
<input type="submit" value="Submit">
</form>

<?php
for($i = 0; $i < count($image->Comments); $i++)
{
	$comment = $image->Comments[$i];
	echo $comment->Commentor . ": " . $comment->Value . "<br/>";
}

?>