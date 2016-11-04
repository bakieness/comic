<?php
require_once("connection.php");

$query = "SELECT *  
          FROM `tv_shows`";

$result = mysqli_query($connection, $query);

$arr = array();

if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_array($result)){
        $id = $row['id'];
        $title = $row['title'];
        $seasons = $row['seasons'];
        $poster = $row['poster'];
        $brand = $row['Brand'];
        $release = $row['original_release'];
        $plot = $row['plot'];
        $universe = $row['universe'];
        $arr[] = array('id' => $id,
                       'title' => $title,
                       'seasons' => $seasons,
                       'poster' => $poster,
                       'brand' => $brand,
                       'release' => $release,
                       'plot' => $plot,
                       'universe' => $universe);
    }
}

echo json_encode($arr);
?>