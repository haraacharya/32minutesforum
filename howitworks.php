<?php  
//aboutus.php  
include 'connect.php';  
include 'header.php'; 
echo '<body id="howitworks">';

echo '<div class="holder_content">';
echo '<h3>How it Works</h3>';
echo '<section class="group_text">';  
echo "<P>Many a times people think of something and they need an activity partner instantly within 30 minutes or say an hour. So they can come to this site and either search for somebody who is in th same boat or can ask for one by creating a post.<br/>
Registration is a must to post something. But don't worry <a href='signup.php'>it's</a> fast, easy and free. And we don't send news-letters or any subscriptions to your email ID. We don't believe in SPAMS but in usability.<br/>
Once registered you can <a href='createapost.php'>create a post</a>. It will have a life of 30 minutes. If somebody replies to that within 30 minutes, your post's life will again increase by 30 more minutes from the time you got a reply. For every reply, the life of post will increase by 30 more minutes. And after 30 minutes of post time without any activity in it, it will be vanished.<br/>
Note:(You don't need to register for replying to any post...cool rt?)</p><br/>

<p>Example:<br/>
I am looking for a tennis partner now.<br/> 
I will post it in 32 minutes forum and start getting ready and keep watching my 32 minutes forum. If somebody replies, I got a partner. I will reply again and exchange all the details over the forum or personal mail, which ever way is convenient for you and get going accordingly.<br/>
OR<br/>
I will keep moving as per my plan that I thought of. <a href='index.php'>32 minutes forum</a> is not making me wait...I tried and then went ahead.</p>

<br/><p>Why 32 Minutes: 30 Minutes is the life of the post and 2 minutes is for you guys to see <a href='howitworks.php'>how it works</a>, read<a href='aboutus.php'> about us</a> and if convinced then  <a href='signup.php'>sign up</a> (if you want to)...</p>";

echo '</section>';
echo '</div>';
include 'footer.php';  
?>  
