<?php

$file_result = "";

if($_FILES["fileToUpload"]["error"] > 0)
{
$file_result .= "No File Uploaded";
} else {
$file_result .= "Upload: " . $_FILES["fileToUpload"]["name"];

$path = "C:/Users/James/Desktop/New folder/" . $_FILES["fileToUpload"]["name"];

///home/bakieness123/public_html/images/

move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$path);
}

header("location:javascript://history.go(-1)");

?>