<?php  
//signin.php  
include 'connect.php';  
include 'header.php'; 
 
//first, check if the user is already signed in. If that is the case, there is no need to display this page  
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)  
{  
    //echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';  
    header("Location: index.php");
}
  
else  
{  
    echo '<div class="holder_content">';
    echo '<h3>Sign in:</h3>';	
    echo '<section class="group_form">';
    echo 'Please sign in OR <a href="signup.php">create an account</a> to create a post.<br/><br/>';	
    if($_SERVER['REQUEST_METHOD'] != 'POST')  
    {  
        /*the form hasn't been posted yet, display it 
          note that the action="" will cause the form to post to the same page it is on */  
	echo '<form method="post" action="">
		      <div class="box">
			      <label>  
			    	<span>Email:</span>
			    	<input type="email" class="input_text" name="email" autofocus/>
			      </label>
			      <label>
			      	<span>Password:</span>
			      	<input type="password"  class="input_text" name="password"/>
			      </label> 
			      <label>
			      	<span></span> 
			      	<input type="submit" class="button" value="Sign in" /> 
			      </label>	
			      <label>
				<span></span>
				or <a href="signup.php">Create an Account</a>	
			      </label>
		      </div>	
              </form>';      
    } 
    else 
    { 
        /* so, the form has been posted, we'll process the data in three steps:  
            1.  Check the data  
            2.  Let the user refill the wrong fields (if necessary)  
            3.  Varify if the data is correct and return the correct response  
        */  
        $errors = array(); /* declare the array for later use */  
        if(!isset($_POST['email']))  
        {  
            $errors[] = 'The Email field must not be empty.';  
        }  
        if(!isset($_POST['password']))  
        {  
            $errors[] = 'The password field must not be empty.';  
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
        } 
        else 
        { 
            //the form has been posted without errors, so save it 
            //notice the use of mysql_real_escape_string, keep everything safe! 
            //also notice the sha1 function which hashes the password 
            $sql = "SELECT 
                        user_id, user_name, 
                        user_email, user_sex, user_birthyear, user_date
                        user_level 
                    FROM 
                        users 
                    WHERE 
                        user_email = '" . mysql_real_escape_string($_POST['email']) . "' 
                    AND 
                        user_password = '" . sha1($_POST['password']) . "'";  
            $result = mysql_query($sql);  
            if(!$result)  
            {  
                //something went wrong, display the error  
                echo 'Something went wrong while signing in. Please try again later.'; 
                //echo mysql_error(); //debugging purposes, uncomment when needed 
            } 
            else 
            { 
                //the query was successfully executed, there are 2 possibilities 
                //1. the query returned data, the user can be signed in 
                //2. the query returned an empty result set, the credentials were wrong 
                if(mysql_num_rows($result) == 0) 
                { 
                    echo 'You have supplied a wrong Email/password combination. Please<a href="signin.php"> try again.</a>'; 
                } 
                else 
                { 
                    //set the $_SESSION['signed_in'] variable to TRUE 
                    $_SESSION['signed_in'] = true; 
                    //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages 
                    while($row = mysql_fetch_array($result)) 
                    { 
                        $_SESSION['user_id']    = $row['user_id']; 
                        $_SESSION['user_name']  = $row['user_name']; 
                        $_SESSION['user_email']  = $row['user_email'];
                        $_SESSION['user_sex']  = $row['user_sex'];
                        $_SESSION['user_birthyear']  = $row['user_birthyear'];
                        $_SESSION['user_date']  = $row['user_date'];
                        $_SESSION['user_level'] = $row['user_level']; 
                    } 
                    //echo 'Welcome, ' . $_SESSION['user_name'] . '. <a href="index.php">Proceed to the forum overview</a>.'; 
		    if(isset($_SESSION['create_a_post']))
		    {
			header("Location: createapost.php");
		    }
		    else
		    {	
                    	header("Location: index.php");
                    }	
                } 
            } 
        } 
    }
    echo '</section>';	
    echo '</div>'; 
} 
include 'footer.php';  
?>  
