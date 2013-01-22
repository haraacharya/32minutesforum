<?php  
//createapost.php  
include 'connect.php';
include 'header.php'; 
echo '<body id="createapost">';  
//first, check if the user is already signed in. If that is the case, there is no need to display this page  
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)  
{  
	echo '<div class="holder_content">';
	echo '<h3>Create a Post</h3>';
	echo '<section class="group_form">';
	if($_SERVER['REQUEST_METHOD'] != 'POST')  
	{  
		$sql = "SELECT category_id, category_name, category_description FROM categories";  
		$result = mysql_query($sql);  
		/*the form hasn't been posted yet, display it 
		note that the action="" will cause the form to post to the same page it is on */  
		echo '<form method="post" action="">
		<div class="box">  
		<label>
			<span>Category:</span> 
			<select name="post_category" class="input_text" autofocus>';
				  if(!$result)  
				  {  
					echo '<option value="others">others</option>';
				  }  
				  else
				  {
					while($row = mysql_fetch_assoc($result)) 
					{
						echo '<option value="'.$row['category_id'].'">'.$row['category_name'].'</option>';
					}
				  }
			echo '</select>';
			echo '<sec_desc style="padding-left:20px">(If you do not find a suitable category, please post it in Others.)</sec_desc>'; 
		echo '</label>

		<label>
			<span>Subject:</span>
			<input type="text" class="input_text" name="subject">
		</label>

		<label>
			<span>Content:</span>
			<textarea name="post_description" class="message" ></textarea>  
		</label>
		<label>	
			<span>Place:</span>
			<input type="text" class="input_text" name="place">
		</label>
		<label>
			<span>Area-Code:</span> 
			<input type="text" class="input_text" name="area_code" pattern="\d*">
		</label>
		<label>
			<span></span>	
			<input type="submit" class="button" value="Post" />  
		<label>	
		</form>'; 
	} 
	else 
	{ 
		/* so, the form has been posted, we'll process the data in three steps:  
		1.  Check the data  
		2.  Let the user refill the wrong fields (if necessary)  
		3.  Save the data  
		*/ 
		$errors = array(); /* declare the array for later use */  
		if(!$_POST['subject'])  
		{  
			$errors[] = 'The subject field must not be empty.';  
		}
		if(!$_POST['place'])  
		{  
			$errors[] = 'The place field must not be empty.';  
		}
		if(!$_POST['area_code'])  
		{  
			$errors[] = 'The area-code field must not be empty.';  
		}
		if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/  
	    	{  
			echo 'Uh-oh.. a couple of fields are not filled in correctly..'; 
			echo '<ul>'; 
			foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */ 
			{ 
				echo '<li>' . $value . '</li>'; /* this generates a nice error list */ 
			} 
			echo '</ul>';
			echo '<a href="createapost.php">BACK TO THE FORM.</a>'; 
	    	} 
	    	else 
	    	{ 
			//the form has been posted without any errors, so save it 
			//used of mysql_real_escape_string to keep everything safe! 
				$sql = "INSERT INTO 
				    posts(post_category, post_title, post_content, post_place, post_area_code , post_by, post_date, post_life) 
				VALUES('" . mysql_real_escape_string($_POST['post_category']) . "', '" . mysql_real_escape_string($_POST['subject']) . "', '" . mysql_real_escape_string($_POST['post_description']) . "', '" . mysql_real_escape_string($_POST['place']) . "', '" . mysql_real_escape_string($_POST['area_code']) . "', '". $_SESSION['user_id'] ."', NOW(), NOW())";  
			$result = mysql_query($sql);
			if(!$result)
			{
				//something went wrong, display the error  
			    	echo 'Something went wrong while registering. Please try again later.'; 
			    	echo mysql_error(); //debugging purposes, uncomment when needed
			}
			else
			{
				header("Location: index.php");	
			}
		
		}
	}
	echo '</section>';
	echo '</div>';
}	  
else  
{  
	$_SESSION['create_a_post'] = true;	
    	header("Location: signin.php");
} 
include 'footer.php';  
?>  
