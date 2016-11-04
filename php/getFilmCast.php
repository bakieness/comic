<?php
require_once("connection.php");

$query = "SELECT a.fname, a.lname, r.name, m.id as mid, am.actor_id, a.id 
          FROM actor a 
	        JOIN actor_role ar 
			    ON a.id = ar.actor_id 
			JOIN role r  
			    ON ar.role_id = r.id 
			JOIN movie_role mr 
				ON r.id = mr.role_id 
			JOIN movies m 
				ON mr.movie_id = m.id  
			JOIN actor_movie am
		 		ON m.id = am.movie_id
            WHERE am.actor_id = a.id";

$result = mysqli_query($connection, $query);

$arr = array();

if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_array($result)){
        $fname = $row['fname'];
        $lname = $row['lname'];
        $role = $row['name'];
        $mvid = $row['mid'];
        $arr[] = array('fname' => $fname,
                       'lname' => $lname, 
                       'role' => $role, 
                       'mvid' => $mvid);
    }
}

echo json_encode($arr);
?>