<?php
include "functions.php";
include "comment.php";


class Image
{
	public $Name;
	public $Owner;
	public $FileId;
	public $Comments;
	public $Score;
	
	public function Load($id)
	{
		$this->FileId = $id;
		
		$connection = mysql_connect(Globals::$SERVER_HOST, Globals::$SERVER_USERNAME, Globals::$SERVER_PASSWORD);
		mysql_select_db(Globals::$DATABASE_NAME, $connection);
		
		$imagesTable = Globals::$IMAGES_TABLE;
		$result = mysql_query("SELECT * FROM $imagesTable WHERE fileID = '$id'");
		
		//there should only be 1 row since an imageID identifies a single image
		if($row = mysql_fetch_array($result))
		{
			$this->Score = $row["score"];
			$this->Name = $row["name"];
			$this->Owner = $row["ownerid"];
			
			
			//load comments
			$commentsTable = Globals::$COMMENTS_TABLE;
			$this->Comments = array();
			$result = mysql_query("SELECT * FROM $commentsTable WHERE imageID = '$id'");
			
			while($row = mysql_fetch_array($result))
			{
				$commentAdd = new Comment();
				$commentAdd->Commentor = $row["userID"];
				$commentAdd->Value = $row["comment"];
				$commentAdd->ImageParent = $this;
				$commentAdd->Score = $row["score"];
				$this->Comments[] = $commentAdd;
			}
		}
	}
}

?>