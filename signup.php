<?php  
//signup.php  
//session_start();
include 'connect.php';  
include 'header.php';  
echo '<div class="holder_content">';
echo '<h3>Sign up:</h3>'; 
echo '<section class="group_form">';
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)  
{  
    echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';  
}  
else  
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')  
	{  
	    /*the form hasn't been posted yet, display it 
	      note that the action="" will cause the form to post to the same page it is on */  
	    echo '<form method="post" action="">
	    	<div class="box">    
			<label>
				<span>Name:</span>
				<input type="text" class="input_text" name="name" autofocus/>
			</label>
			<label> 
				<span>Email:</span> 
				<input type="email" class="input_text" name="email"/>
			</label>
			<label>
				<span>Password:</span>
				<input type="password" class="input_text" name="password"/>  
			</label>
			<label>
				<span>I am:</span>
				 <select name="sex" class="input_text">
					  <option value="SelectSex">Select Sex:</option>
					  <option value="Male">Male</option>
					  <option value="Female">Female</option>
					  <option value="Eunuch">Eunuch(Third Sex)</option>
					  <option value="Others">Others</option>
				 </select>
			</label>
			<label>     
				<span>Birth Year:</span>
				<input type="text" name="birth_year" class="input_text" pattern="^[0-9]{4}$"/> 
			</label>
			<label>
				<span></span>
				<input type="submit" class="button" value="Sign Up" />  
			<label>
		</div>	
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
	    if(isset($_POST['name']))  
	    {  
		//the user name exists  
		if(!ctype_alnum($_POST['name']))  
		{  
		    $errors[] = 'The name can only contain letters and digits.';  
		}    
	    }  
	    else  
	    {  
		$errors[] = 'The name field must not be empty.';  
	    }

	    if(!isset($_POST['email']))  
	    {  
		$errors[] = 'The email field must not be empty.';  
	    }
	    else
	    {
		$sql = "SELECT * FROM users WHERE user_email = '".$_POST['email']."'";
		$result = mysql_query($sql);
		$num_rows = mysql_num_rows($result);
		if ($num_rows > 0) 
		{
			$errors[] = "This email is already taken";
		} 
		else
		{

		}

		//////////////////////////////////////////////////////////////////////////////////
	    }
	      
	    if(!isset($_POST['password']))  
	    {  
		$errors[] = 'The password field cannot be empty.';  
	    }
	    if(!isset($_POST['sex']) or ($_POST['sex'] == 'SelectSex'))
	    {  
		$errors[] = 'Please select sex.';  
	    }

	    //Birthyear Information is not mandatory
	    //if(!isset($_POST['birth_year']))  
	    //{  
		//$errors[] = 'The Birth Year field cannot be empty.';  
	    //}	
	      
	    if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/  
	    {  
		echo 'Uh-oh.. a couple of fields are not filled in correctly..'; 
		echo '<ul>'; 
		foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */ 
		{ 
		    echo '<li>' . $value . '</li>'; /* this generates a nice error list */ 
		}
		echo "<a href='signup.php'>Try again</a>"; 
		echo '</ul>'; 
		//echo 'aaa'.$_POST['sex'].'aaa';
	    } 
	    else 
	    { 
		//the form has been posted without, so save it 
		//notice the use of mysql_real_escape_string, keep everything safe! 
		//also notice the sha1 function which hashes the password 
		$sql = "INSERT INTO 
		            users(user_name, user_email, user_password, user_sex, user_birthyear ,user_date, user_level) 
		        VALUES('" . mysql_real_escape_string($_POST['name']) . "', '" . mysql_real_escape_string($_POST['email']) . "', 
		               '" . sha1($_POST['password']) . "', 
		               '" . mysql_real_escape_string($_POST['sex']) . "', '" . mysql_real_escape_string($_POST['birth_year']) . "', 
		                NOW(), 
		                0)";  
		$result = mysql_query($sql);  
		if(!$result)  
		{  
		    //something went wrong, display the error  
		    echo 'Something went wrong while registering. Please try again later.'; 
		    //echo mysql_error(); //debugging purposes, uncomment when needed 
		} 
		else 
		{ 
		    echo 'Successfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)'; 
		    //set session variables here
		    /*$_SESSION['signed_in'] = true;
		    $_SESSION['user_name']  = $_POST['name']; 
		    if(isset($_SESSION['create_a_post']))
		    {
			header("Location: createapost.php");
		    }
		    else
		    {	
                    	header("Location: index.php");
                    }*/	
		} 
	    }
	}
	     
} 
echo '</section>';
echo '</div>';
include 'footer.php';  
?>  
