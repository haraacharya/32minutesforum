<?php  
//index.php  
include 'connect.php';  
include 'header.php'; 
//php time diff function
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

//Area, Pin-Code, Category
/*$search_type = $_POST['search_type'];*/
switch (mysql_real_escape_string($_GET['search_type']))
{
	case 'area' :
	$search_category = "post_place";
	break;
	case 'area_code' :
	$search_category = "post_area_code";
	break;
	case 'general' :
	$search_category = "title_content";
	break;
	default:
	$search_category = "title_content";
	break;
}

$search_text = mysql_real_escape_string($_GET['search_text']);
if ($search_category == "title_content")
{
	$sql = "SELECT posts.post_id, posts.post_category, posts.post_title, posts.post_content, posts.post_place, posts.post_area_code, posts.post_by, posts.post_date, posts.post_life, users.user_id, users.user_name, users.user_sex, NOW() as currentdate FROM posts LEFT JOIN users ON posts.post_by = users.user_id WHERE posts.post_title LIKE '%" . $search_text ."%' OR posts.post_content LIKE '%" . $search_text ."%' OR users.user_name LIKE '%" . $search_text ."%' ORDER BY posts.post_date DESC";		
}
else
{
	$sql = "SELECT posts.post_id, posts.post_category, posts.post_title, posts.post_content, posts.post_place, posts.post_area_code, posts.post_by, posts.post_date, posts.post_life, users.user_id, users.user_name, users.user_sex, NOW() as currentdate FROM posts LEFT JOIN users ON posts.post_by = users.user_id WHERE posts.".$search_category." LIKE '%" . $search_text ."%' ORDER BY posts.post_date DESC";
}

$result = mysql_query($sql);  

if(!$result)  
{  
	echo '<div class="holder_content">';
	echo '<section class="group_text">';
	echo '<h2>Search Result:</h2>';
	echo 'No related posts found, try again.';  
	echo $sql;
	echo '</section></div>';
}  
else  
{  
	if(mysql_num_rows($result) == 0)  
	{  
		echo '<div class="holder_content">';
		echo '<section class="group_text">';
		echo '<h2>Search Result:</h2>';
		echo 'Could not find any post related to: '.$search_text;  
		echo '</section></div>';
	}  
	else  
	{ 
	
		//Display all topics
		echo '<div class="holder_content">';
		echo '<section class="group_text">';
		echo '<h2>Search Result:</h2>';
		echo '</section></div>';
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
			echo "There are no Active posts related to (Search Text): ".$search_text;
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

