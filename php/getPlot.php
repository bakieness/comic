<?php
require_once("connection.php");

$query = "SELECT tv_id, season, plot    
          FROM episode";

mysqli_set_charset($connection, 'utf8');

$result = mysqli_query($connection, $query);

$arr = array();

if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_array($result)){
        $tid = $row['tv_id'];
        $season = $row['season'];
        $plot = $row['plot'];
        $arr[] = array('tvid' => $tid,  
                       'season' => $season, 
                       'plot' => $plot);
    }
}

echo json_encode($arr);
?>