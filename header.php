<!DOCTYPE html>  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">  
<?php session_start();?>
<head>  
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">  
	<meta name="description" content="Want to meet somebody in 32 minutes, search for a post or create a post in 32minutesforum.com">
	<title>32 Minutes Forum</title>  
	<link rel="stylesheet" href="css/style.css" type="text/css" media="Screen">
	<link rel="stylesheet" href="css/mobile.css" type="text/css" media="handheld" />    
	<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon"/>
</head>  
<body><!--Need to check as body has been added in every pae for acti page implementation-->
<div id="container"><!--start container-->  

		<!--start logo-->
		<a href="index.php" id="logo"><img src="images/logo.png" width="221" height="100" alt="32 MINUTEs FORUM"/></a>
		<!--end logo-->
		<!--start menu-->
		<nav>
		    <ul>
			<li id="home"><a href="index.php">Home</a></li>
			<li id="createapost"><a href="createapost.php">Create A Post</a></li>
			<li id="aboutus"><a href="aboutus.php">About us</a></li>
			<li id="howitworks"><a href="howitworks.php">How It Works</a></li>
		   
		<?php  
			if(isset($_SESSION['signed_in']))  
			{  
				echo 'Hello ' . $_SESSION['user_name'] . '. <br/>Not you? <a href="signout.php">Sign out</a> <a href="myaccount.php" style="font-weight: bold;">My Account</a>';  
			}  
			else  
			{  
				echo '<a href="signin.php">Sign in</a> <br/>or <a href="signup.php">create an account</a>';  
			}  
		?>
		   </ul>
		   <!--end menu-->
		</nav>
	<!--start intro-->
	<div id="intro">
		<div class="group_bannner_right">
			<img src="images/intro1.png" width="600" height="120"  alt="32 Minutes Away">
		</div>
		<div class="search">
			<form method="get" action="search_result.php?search_text=".$_REQUEST['search_text']."?search_category=".$_REQUEST['search_type'].">
				<div class="box">
					<label1><Span>Search post by:</span>
						<select name="search_type" class="select_text">
							<option value="general">General</option>	 
							<option value="area">Area</option>	
							<option value="area_code">Pin_Code</option>	
						 </select>
					</label1>
					<label1><span></span>
						<input type="text" placeholder="Search here..." class="seach_text" name="search_text" required/></label1>
					<label1><span></span>
						<input type="submit" class="button" value="search" />
					</label1>  
				</div>
			</form>	 
		</div>
	</div>
	<!--end intro-->
