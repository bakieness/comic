<?php
require_once("connection.php");

$query = "SELECT a.fname, a.lname, r.name, tv.id as tid 
		  FROM actor a 
			  JOIN actor_role ar 
				  ON a.id = ar.actor_id 
			  JOIN role r  
				  ON ar.role_id = r.id 
			  JOIN tv_role tr 
				  ON r.id = tr.role_id 
			  JOIN tv_shows tv 
				  ON tr.tv_id = tv.id";

$result = mysqli_query($connection, $query);

$arr = array();

if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_array($result)){
        $fname = $row['fname'];
        $lname = $row['lname'];
        $role = $row['name'];
        $tid = $row['tid'];
        $arr[] = array('fname' => $fname,
                       'lname' => $lname,
                       'role' => $role,
                       'tid' => $tid);
    }
}

echo json_encode($arr);
?>