<?php
require_once("connection.php");

$query = "SELECT *    
          FROM episode";

mysqli_set_charset($connection, 'utf8');

$result = mysqli_query($connection, $query);

$arr = array();

if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_array($result)){
        $title = $row['title'];
        $episode_no = $row['episode_no'];
        $director = $row['director'];
        $release = $row['releaseDate'];
        $newDate = date("d-m-Y", strtotime($release));
        $tid = $row['tv_id'];
        $season = $row['season'];
        $plot = $row['plot'];
        $arr[] = array('title' => $title,
                       'episode' => $episode_no,
                       'director' => $director,
                       'release' => $newDate,  
                       'tvid' => $tid,
                       'season' => $season,
                       'plot' => $plot);
    }
}

echo json_encode($arr);
?>