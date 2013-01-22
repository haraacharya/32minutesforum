<?php  
//session_start();
//createapost.php  
include 'connect.php';  
include 'header.php'; 
 
echo '<h3>Create a Post</h3>';  
//first, check if the user is already signed in. If that is the case, there is no need to display this page  
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)  
{  
	if($_SERVER['REQUEST_METHOD'] != 'POST')  
	{  
		$sql = "SELECT category_id, category_name, category_description FROM categories";  
		$result = mysql_query($sql);  
		
		  if(!$result)  
		  {  
			echo 'query failed';
		  }  
		  else
		  {
			while($row = mysql_fetch_assoc($result)) 
			{
				echo $row['category_name'];
			}
		  }

 
	} 
	else 
	{ 
		/* so, the form has been posted, we'll process the data in three steps:  
		1.  Check the data  
		2.  Let the user refill the wrong fields (if necessary)  
		3.  Save the data  
		*/ 
		echo "Something failed";
	}
}	  
else  
{  
	$_SESSION['create_a_post'] = true;	
    	header("Location: signin.php");
} 
include 'footer.php';  
?>  
