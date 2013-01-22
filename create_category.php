<?php  
//create_category.php  
include 'header.php';  
include 'connect.php';  
echo '<div class="holder_content">';
echo '<h3>Create Catgory</h3>';  
echo '<section class="group_form">';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)  
{  
	$sql = "SELECT * FROM users WHERE user_email = '".$_SESSION['user_email']."' AND user_level = 1";
	$result = mysql_query($sql);
	$num_rows = mysql_num_rows($result);
	if ($num_rows <= 0) 
	{
		echo "You do not have permission to create a category.";
	} 
	else
	{
		if($_SERVER['REQUEST_METHOD'] != 'POST')  
		{  
			//the form hasn't been posted yet, display it  
			echo '<form method="post" action="">
				<div class="box">
				<label>
					<span>Category name: </span>
					<input type="text" name="category_name" class="input_text"/>
				</label>
				<label>
					<span>Category description:</span> 
					<textarea name="category_description" class="message"/></textarea>
				</label>
				<label>
					<span></span>	
					<input type="submit" class="button" value="Add category" />
				</div>
			</form>'; 
		} 
		else 
		{ 
			//the form has been posted, so save it 
			$sql = "INSERT INTO categories(category_name, category_description) 
			VALUES('" . mysql_real_escape_string($_POST['category_name']) . "',  
			     '" . mysql_real_escape_string($_POST['category_description']) . "')";  
			$result = mysql_query($sql);  
			if(!$result)  
			{  
				//something went wrong, display the error  
				echo 'Error' . mysql_error();  
			}  
			else  
			{  
				echo 'New category successfully added. <a href="create_category.php">Create One More</a>';  
			}  
		}
	} 	  
}  
else
{
	header("Location: signin.php");
}
echo '</section></div>';
include 'footer.php'; 
?>  
