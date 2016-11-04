<?php
require_once("connection.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
@$show = $request->show;
@$season = $request->season;
@$ep_no = $request->ep_no;
@$title = $request->title;
@$director = $request->director;
@$release = $request->release;
@$plot = $request->plot;

$realPlot = mysqli_real_escape_string($connection, $plot);

$insertdate = date('Y-m-d', strtotime($release));

$subquery = "SELECT * 
             FROM tv_shows 
             WHERE title = '{$show}'";

$subresult = mysqli_query($connection, $subquery);

if(mysqli_num_rows($subresult) > 0)
{
    while($row = mysqli_fetch_array($subresult)){
        $sid = $row['id'];
    }
}

$subquery2 = "SELECT * 
             FROM episode 
             WHERE tv_id = '{$sid}' 
             AND season = '{$season}' 
             AND episode_no = '{$ep_no}'";

$subresult2 = mysqli_query($connection, $subquery2);


//$rel = STR_TO_DATE($release, '%Y/%m/%d');

if(mysqli_num_rows($subresult2) == 0)
{
    $query = "INSERT INTO episode ( title, episode_no, director, releaseDate, plot, tv_id, season ) 
              VALUES ( '{$title}', '{$ep_no}', '{$director}', '{$release}' , '{$realPlot}', '{$sid}', '{$season}')";
    $result = mysqli_query($connection, $query);
}

?>