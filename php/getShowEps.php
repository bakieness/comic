<?php
require_once("connection.php");

$query = "SELECT season, episode_no as eps, tv_id  
		   FROM episode";

$result = mysqli_query($connection, $query);

$arr = array();

if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_array($result)){
        $seasons = $row['season'];
        $episodes = $row['eps'];
        $tid = $row['tv_id'];
        $arr[] = array('episodes' => $episodes,
                       'seasons' => $seasons,
                       'tvid' => $tid);
    }
}

echo json_encode($arr);
?>