<?php  
//aboutus.php  
include 'connect.php';  
include 'header.php'; 
echo '<div class="holder_content">'; 
echo '<h3>My Account</h3>';  
echo '<section class="group_text">';  
echo "APPs...<br/>";

echo '<a href="post_it.html">CLICK HERE TO USE THE POST IT APP</a></br></br>';

$sql = "SELECT * FROM users WHERE user_email = '".$_SESSION['user_email']."' AND user_level = 1";
$result = mysql_query($sql);
$num_rows = mysql_num_rows($result);
if ($num_rows <= 0) 
{
	//echo "You do not have permission to create a category.";
} 
else
{
	echo "By the way you can <a href='create_category.php'>Create a category</a> for this forum if you have permission.";
}
echo '</section>';
echo '</div>';
include 'footer.php';  
?>  
