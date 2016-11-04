<?php
require_once("connection.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
@$fname = $request->fname;
@$lname = $request->lname;
@$film = $request->film;
@$role = $request->role;

$subquery = "SELECT * 
             FROM actor 
             WHERE fname = '{$fname}' 
             AND lname = '{$lname}'";

$subresult = mysqli_query($connection, $subquery);

if(mysqli_num_rows($subresult) == 0)
{
    $query = "INSERT INTO actor ( fname, lname ) 
              VALUES ( '{$fname}', '{$lname}' )";
    $result = mysqli_query($connection, $query);
}

$subquery2 = "SELECT * 
             FROM role 
             WHERE name = '{$role}'";

$subresult2 = mysqli_query($connection, $subquery2);

if(mysqli_num_rows($subresult2) == 0)
{
    $query2 = "INSERT INTO role ( name ) 
               VALUES ( '{$role}' )";
    $result2 = mysqli_query($connection, $query2);
}

$query3 = "SELECT id 
           FROM actor 
           WHERE fname = '{$fname}' 
           AND lname = '{$lname}'";

$result3 = mysqli_query($connection, $query3);

if(mysqli_num_rows($result3) > 0)
{
    while($row = mysqli_fetch_array($result3)){
        $aid = $row['id'];
    }
}

$query4 = "SELECT id 
           FROM role 
           WHERE name = '{$role}'";

$result4 = mysqli_query($connection, $query4);

if(mysqli_num_rows($result4) > 0)
{
    while($row2 = mysqli_fetch_array($result4)){
        $rid = $row2['id'];
    }
}

$query5 = "SELECT id 
           FROM movies  
           WHERE title = '{$film}'";

$result5 = mysqli_query($connection, $query5);

if(mysqli_num_rows($result5) > 0)
{
    while($row3 = mysqli_fetch_array($result5)){
        $mid = $row3['id'];
    }
}


$subquery3 = "SELECT * 
             FROM actor_role 
             WHERE actor_id = '{$aid}' 
             AND role_id = '{$rid}'";

$subresult3 = mysqli_query($connection, $subquery3);

if(mysqli_num_rows($subresult3) == 0)
{
    $query6 = "INSERT INTO actor_role ( actor_id, role_id ) 
               VALUES ( '{$aid}', '{$rid}' )";
    $result6 = mysqli_query($connection, $query6);
}

$subquery4 = "SELECT * 
             FROM movie_role 
             WHERE movie_id = '{$mid}' 
             AND role_id = '{$rid}'";

$subresult4 = mysqli_query($connection, $subquery4);

if(mysqli_num_rows($subresult4) == 0)
{
    $query7 = "INSERT INTO movie_role ( movie_id, role_id ) 
               VALUES ( '{$mid}', '{$rid}' )";
    $result7 = mysqli_query($connection, $query7);
}

$subquery5 = "SELECT * 
             FROM actor_movie 
             WHERE actor_id = '{$aid}' 
             AND movie_id = '{$mid}'";

$subresult5 = mysqli_query($connection, $subquery5);

if(mysqli_num_rows($subresult5) == 0)
{
    $query8 = "INSERT INTO actor_movie ( actor_id, movie_id ) 
               VALUES ( '{$aid}', '{$mid}' )";
    $result8 = mysqli_query($connection, $query8);
}
?>