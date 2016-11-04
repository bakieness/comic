<?php

// 1. Create a database connection
$connection = mysqli_connect("localhost","root","shancy123");
if (!$connection) {
	die("Database connection failed: " . mysql_error($connection));
}

// 2. Select a database to use 
$db_select = mysqli_select_db($connection, "angular_test");
if (!$db_select) {
	die("Database selection failed: " . mysqli_error($connection));
}


$query = "SELECT * 
          FROM tbl_projects";

$result = mysqli_query($connection, $query);

$arr = array();

if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_array($result)){
        $name = $row['title'];
        $description = $row['type'];
        $proj_type = $row['proj_type'];
        $arr[] = array('title' => $name, 'type' => $description, 'proj_type' => $proj_type);
    }
}

echo json_encode($arr);
?>