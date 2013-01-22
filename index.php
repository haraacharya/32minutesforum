<?php  
//index.php  
include 'connect.php';  
include 'header.php'; 
//php time diff function
echo '<body id="home">';
function timeDiff($post_Time,$currentTime)
{
	// convert to unix timestamps
	$post_Time=strtotime($post_Time);
	$currentTime=strtotime($currentTime);

	// perform subtraction to get the difference (in seconds) between times
	//$timeDiff=round(abs($currentTime - $post_Time) / 60,2);
	$timeDiff = $currentTime - $post_Time;
	if ($timeDiff > 59)
	{
		$myMinutes = Floor($timeDiff/60);
		$mySeconds = $timeDiff-(Floor($timeDiff/60)*60);
		if ($mySeconds < 10)
		{
			$mySeconds = "0".$mySeconds;
		}
		$myTime = $myMinutes.":".$mySeconds;
	}	
	elseif($timeDiff < 10)
	{
		$mySeconds = "0".$timeDiff;
		$myTime = "0:".$mySeconds;
	}
	else
	{
		$myTime = "0:".$timeDiff;
	}

	// return the difference
	return $myTime;	
}

//function end
 
//echo '<h3>Home</h3>';  
//first, check if the user is already signed in. If that is the case, there is no need to display this page  

$sql = "SELECT posts.post_id, posts.post_category, posts.post_title, posts.post_content, posts.post_place, posts.post_area_code, posts.post_by,     posts.post_date, posts.post_life, users.user_id, users.user_name, users.user_sex, NOW() as currentdate FROM posts LEFT JOIN users ON posts.post_by = users.user_id ORDER BY posts.post_date DESC";// WHERE posts.post_id = '" . mysql_real_escape_string($_GET['id'])."'";
      
$result = mysql_query($sql);  
if(!$result)  
{  
	echo '<div class="holder_content">';
	echo '<section class="group_text">';
	echo 'The posts could not be displayed, please try again later.';  
	echo '</section></div>';
}  
else  
{  
	if(mysql_num_rows($result) == 0)  
	{  
		echo '<div class="holder_content">';
		echo '<section class="group_text">';
		echo 'There are no posts posted yet.';  
		echo '</section></div>';
	}  
	else  
	{ 
		
		//Display all topics
		$active_posts = 0;
		while($row = mysql_fetch_array($result))
		{
			if (timeDiff($row['post_life'],$row['currentdate'])<30)
			{
				$active_posts = $active_posts + 1;		
				echo '<div class="holder_content">';
				echo '<section class="group1">'. $row['user_name'].'<br>Gender: '.$row['user_sex'].'
				<p>Date Created: '. $row['post_date'] .'<br>Place: '. $row['post_place'] .'<br>Area code: '. $row['post_area_code']. '</p>	
				</section>';
				echo '<section class="group2">
					<section class="post_title">'. $row['post_title'].'</section><p>'.substr($row['post_content'],0,150) .'</p>
					<span class="read_more"><a href="post_clicked.php?id='.$row['post_id'].'">Read more...</a></span>
				</section>';
				echo '<section class="group3">'.timeDiff($row['post_life'],$row['currentdate']) .' Min:Sec';
				echo '</section></div>';
			}
		}
		if($active_posts == 0)
		{
			echo '<div class="holder_content">';
			echo '<section class="group_text">';
			echo "There are no Active posts as of now";
			echo '</section></div>';
		}
		else
		{
			echo '<div class="holder_content">';
			echo '<section class="group_statistics">';
			echo 'Active Posts: '.$active_posts;
			echo '</section></div>';
			
		}
	}
}
include 'footer.php';  
?>  

