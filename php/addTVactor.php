<?php
require_once("connection.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
@$fname = $request->fname;
@$lname = $request->lname;
@$show = $request->show;
@$role = $request->role;

$query = "INSERT INTO actor ( fname, lname ) 
          VALUES ( '{$fname}', '{$lname}' )";
$result = mysqli_query($connection, $query);

$query2 = "INSERT INTO role ( name ) 
           VALUES ( '{$role}' )";
$result2 = mysqli_query($connection, $query2);

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
           FROM tv_shows 
           WHERE title = '{$show}'";

$result5 = mysqli_query($connection, $query5);

if(mysqli_num_rows($result5) > 0)
{
    while($row3 = mysqli_fetch_array($result5)){
        $tid = $row3['id'];
    }
}

$query6 = "INSERT INTO actor_role ( actor_id, role_id ) 
          VALUES ( '{$aid}', '{$rid}' )";
$result6 = mysqli_query($connection, $query6);

$query7 = "INSERT INTO tv_role ( tv_id, role_id ) 
          VALUES ( '{$tid}', '{$rid}' )";
$result7 = mysqli_query($connection, $query7);

echo json_encode($query);
?>