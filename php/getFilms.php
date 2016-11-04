<?php
require_once("connection.php");

$query = "SELECT *  
          FROM `movies`";

$result = mysqli_query($connection, $query);

$arr = array();

if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_array($result)){
        $id = $row['id'];
        $name = $row['title'];
        $plot = $row['plot'];
        $release = $row['release'];
        $newDate = date("d-m-Y", strtotime($release));
        $poster = $row['poster'];
        $director = $row['director'];
        $brand = $row['brand'];
        $universe = $row['universe'];
        $runtime = $row['run_time'];
        $trailer = $row['trailer'];
        $arr[] = array('id' => $id,
                       'title' => $name,
                       'plot' => $plot, 
                       'universe' => $universe, 
                       'sortRelease' => $release,
                       'release' => $newDate, 
                       'poster' => $poster, 
                       'director' => $director, 
                       'brand' => $brand, 
                       'runTime' => $runtime, 
                       'trailer' => $trailer);
    }
}

echo json_encode($arr);
?>