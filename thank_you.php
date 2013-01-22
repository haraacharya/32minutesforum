<?php  
include 'connect.php';  
include 'header.php'; 

echo '<div class="holder_content">'; 
echo '<section class="group_text">'; 

if($_GET['sent'] == "actionSendMail32minutes")
{
	echo 'Posted successfully. Check your post <a href="'.$_SESSION['reply_post_id'].'">HERE</a>';

	$post_url = $_SESSION['reply_post_id'];
	$to= filter_var($_SESSION['post_email'], FILTER_SANITIZE_EMAIL);
	$subject="You just got a reply for your post in 32minutesforum.com";
	$message='
	<html>
		<head>
			<title>32 Minutes Forum</title>
		</head>
		<body>
			<p>You got a reply for your post title: '. $_SESSION['post_title'].'.</p>
			<p>Check your post in:<br/>www.32minutesforum.com/'.$post_url.'.</p>

			<p>Thanks for using 32minutesforum.com.<br/>
			   Thank you,<br/>
			   32minutesforum.com Team.</p>
		</body>
	</html>';
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//$headers .= "Content-Transfer-Encoding: quoted-printable". "\n";
	$headers .= 'Reply-To: contact@32minutesforum.com' . "\r\n";
	$headers .= 'From: 32 Minutes Forum<contact@32minutesforum.com>' . "\r\n";
		
	if(mail($to, $subject, $message, $headers))
	{
		$to = filter_var($_SESSION['reply_email'], FILTER_SANITIZE_EMAIL);
		$message='
	<html>
		<head>
		  <title>32 Minutes Forum</title>
		</head>
			<body>
				<p>You replied to the post title: '. $_SESSION['post_title'].'.</p>
				<p>Please check for updates and further replies in: www.32minutesforum.com/'.$post_url.'.</p><br/>

				<p>Thanks for using 32minutesforum.com.<br/>
				Thank you,<br/>
				32minutesforum.com Team.</p>
			</body>
	</html>';
		
		$subject="You just replied for a post in 32minutesforum.com";

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//$headers .= "Content-Transfer-Encoding: quoted-printable". "\n";
		$headers .= 'Reply-To: contact@32minutesforum.com' . "\r\n";
		$headers .= 'From: 32 Minutes Forum<contact@32minutesforum.com>' . "\r\n";

		if(mail($to, $subject, $message, $headers))
		{
			header("Location:thank_you.php?sent=true");
			
		}
		else
		{
			header("Location:thank_you.php?sent=false");
		}
	}
}	
if($_GET['sent'] == "true")
{
	echo 'Posted successfully. Check your post <a href="'.$_SESSION['reply_post_id'].'">HERE</a>';
	echo "<br/>A mail has been sent to you and the post creator.";
}
else
{
	echo 'Posted successfully. Check your post <a href="'.$_SESSION['reply_post_id'].'">HERE</a>';
	echo "<br/>Could not send an intimation to the post owner but both owner and you can always check <a href=".$_SESSION['reply_post_id'].">here </a>for details, replies and updates...";
}

echo '</section></div>';
include 'footer.php';  
?>  

