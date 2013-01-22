<?php  
//post_clicked.php  
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
 
//first, check if the user is already signed in. If that is the case, there is no need to display this page  

if($_SERVER['REQUEST_METHOD'] != 'POST')  
{

	if (isset($_GET['id']))
	{

		$query  = "BEGIN WORK;";  
        	$result = mysql_query($query);  
		if(!$result)  
		{  
		    	//Damn! the query failed, quit  
		    	echo '<div class="holder_content">';
				echo 'An error occured while displaying the post in detail. Please try again later.';  
		    	$sql = "ROLLBACK;"; 
                $result = mysql_query($sql);
                echo '</div>';
		}  
		else  
		{  
			$sql = "SELECT post_id, post_category, post_title, post_content, post_place, post_area_code, post_by, post_date, post_life, users.user_id,  users.user_name, users.user_email, users.user_sex, categories.category_id, categories.category_name, NOW() as currentdate FROM posts LEFT JOIN users ON posts.post_by = users.user_id LEFT JOIN categories ON posts.post_category = categories.category_id WHERE post_id = " . mysql_real_escape_string($_GET['id']);
			$result = mysql_query($sql);
			if(!$result)
			{
				echo '<div class="holder_content">';
				echo '<section class="group_text">';
				echo 'The Selected post could not be displayed, please try again later.';  
				$sql = "ROLLBACK;"; 
	            $result = mysql_query($sql);
	            echo '</section></div>';
			}
			else
			{
				$num_rows = mysql_num_rows($result);
				if($num_rows <= 0)  
				{  
					echo '<div class="holder_content">';
					echo '<section class="group_text">';
					//echo "num rows:".$num_rows;
					echo 'The Selected post could not be displayed, please try again later.';  
					$sql = "ROLLBACK;"; 
			        $result = mysql_query($sql);
			        echo '</section></div>';
				}  
				else  
				{  
					$row = mysql_fetch_array($result);
					//Display the post in detail.
					if (timeDiff($row['post_life'],$row['currentdate'])<30)
					{
						$_SESSION['post_title'] = $row['post_title'];
						$_SESSION['post_email'] = $row['user_email'];
						echo '<div class="holder_content">';
						echo '<section class="group1">'. $row['user_name'] .'<br>Gender: '.$row['user_sex'].'</br>
						<p>Date Created:'. $row['post_date'] .'<br>Place:'. $row['post_place'] .'<br>Area code:'. $row['post_area_code']. '</p>	
						</section>';
						echo '<section class="group2"><section class="post_title">'. $row['post_title'].'</section>(Category:'.$row['category_name'].')<p>'. $row['post_content'] .'</p>
						</section>';
						echo '<section class="group3">';
						echo '<span id="TimePosted">'.timeDiff($row['post_life'],$row['currentdate']) .'</span><br>';
						echo '<span id="theTime"></span>';
						echo '</section>';
						echo '</div>';
						$reply_sql = "SELECT reply_id, reply_to, reply_by, reply_email, reply_user_sex, reply_content, reply_date, reply_private FROM replies WHERE reply_to = ". mysql_real_escape_string($_GET['id'])." ORDER BY reply_date DESC";

						$reply_result = mysql_query($reply_sql);
						if(!$reply_result)  
						{  
							echo '<div class="holder_content">';
							echo 'Not able retrieve the replies for this post. Try again after sometime';  
							$sql = "ROLLBACK;"; 
							$result = mysql_query($sql);
							echo '</div>';
						}  
						else  
						{  
							$reply_count = mysql_num_rows($reply_result);
							if($reply_count <= 0)
							{
								echo '<div class="holder_content">';
								echo '<h3>Be the first to reply!</h3>'; 
								echo '</div>';
							}
							else
							{
								//All replies related to the post!.
								echo '<div class="holder_content"><h3>Replies:</h3></div>';
								while($reply_row = mysql_fetch_array($reply_result))
								{
									echo '<div class="holder_content">';
									echo '<section class="group1">'.$reply_row['reply_by'].'<p>Gender: '. $reply_row['reply_user_sex'] .
									'<br>Email: '. $reply_row['reply_email'] .'</p>
									</section>';
									echo '<section class="group2"><p>'. $reply_row['reply_content'] .'</p></section>';
									echo '<section class="group3">Time Replied : '.$reply_row['reply_date'].'</section>';
									echo '<div style="clear: both"></div>';
									echo '</div>';
								}
							}	
					
							//Reply Form...
							echo '<div class="holder_content">';
							echo '<section class="group_form">';
							//echo 'Post a reply:<br/>';
							echo '<form method="post" action="">';
							echo '<div class="box">';
							if(isset($_SESSION['user_name']))  
							{
								echo '<label>
								<span>Name:</span>
								<input readonly="readonly" type="text" class="input_text" name="rep_name" value="'.$_SESSION['user_name'].'"></label>'; 
								echo '<label>
								<span>Email:</span> 
								<input readonly="readonly" type="email" class="input_text" name="rep_email" value="'.$_SESSION['user_email'].'"></label>'; 
								echo '<label>
								<span>I am:</span> 
								<select name="sex" class="input_text">
								  	   <option value="'.$_SESSION['user_sex'].'">'.$_SESSION['user_sex'].'</option>
								</select></label>';
								echo '<label>
								<span>Content:</span>
								<textarea name="post_description" class="message" autofocus></textarea></label>';        
							}
							else
							{
								echo '<label>
								<span>Name:</span>
								<input type="text" class="input_text" name="rep_name" value="" autofocus> </label>';
								echo '<label>
								<span>Email:</span>
								<input required="required" type="email" class="input_text" name="rep_email" value=""> </label> ';
								echo '<label>
								<span>I am:</span>
								<select name="sex" class="input_text">
									  <option value="SelectSex">Select Sex:</option>
									  <option value="Male">Male</option>
									  <option value="Female">Female</option>
									  <option value="Eunuch">Eunuch(Third Sex)</option>
									  <option value="Others">Others</option>
								 </select></label>';
								echo '<label>
								<span>Content:</span>
								<textarea name="post_description" class="message"></textarea></label>';  
							}
							echo '<label><span></span><input type="radio" class="input_radio" name="reply_private" value="public" CHECKED>Public</label>
							      <label><span></span><input type="radio" class="input_radio" name="reply_private" value="private">Private</label>
							      <label><span></span><input type="submit" class="button" value="Post"/></label>';
							echo '</div>';
							echo '</form>';
							      	
							echo '</section>';
							echo '</div>';
							$sql = "COMMIT;"; 
		            				$result = mysql_query($sql);
		            				//Send a mail to the post creator and also to the person who replied to the post
		            				
		            				 			
		            			}
		            			
					}
					else
					{
						echo '<div class="holder_content">';
						echo '<section class="group_text">';
						echo 'The life of this post is over...Sorry!';
						echo '</section></div>';
					}	
		            				
				}
			}	
		}
	}
	else
	{
		echo '<div class="holder_content">';
		echo '<section class="group_text">';	
		echo 'There is no ID attached to this post. Can not display this post!';
		echo '</section></div>';
	}
}		
/////////another transaction
else
{
	$errors = array(); /* declare the array for later use */ 
	if(!isset($_POST['rep_name']))  
	{  
		$errors[] = 'The Username field cannot be empty.';  
    	}
	if(!isset($_POST['rep_email']))  
	{  
		$errors[] = 'The Email field cannot be empty.';  
    	}
    	if(!isset($_POST['sex']) or ($_POST['sex'] == 'SelectSex'))
	{  
		$errors[] = 'Please select sex.';  
	}
	if(!isset($_POST['post_description']))  
	{  
		$errors[] = 'Put the description.';  
    	}
	if(!empty($errors)) //check for an empty array 
	{  
		echo '<div class="holder_content">';
		echo 'One or More fields are not filled in correctly..'; 
		echo '<ul>'; 
		foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */ 
		{ 
		    echo '<li>' . $value . '</li>'; /* this generates a nice error list */ 
		} 
		echo '</ul>'; 
		echo '</div>';
	} 
	else 
	{ 
		//the form has been posted without errors, so save it
		//reply_id, reply_to, reply_by, reply_email, reply_user_sex, reply_content, reply_date, reply_private 
		if($_POST['reply_private']!= 'Private')
		{
			$query  = "BEGIN WORK;";  
        		$result = mysql_query($query); 
        		if(!$result)  
			{  
				echo 'The reply could not be posted, please try again later.';  
				$sql = "ROLLBACK;"; 
	            $result = mysql_query($sql);
			}  
			else  
			{
				$reply_sql = "INSERT INTO replies(reply_to, reply_by, reply_email, reply_user_sex, reply_content, reply_date, reply_private) VALUES('".mysql_real_escape_string($_GET['id'])."', '" . mysql_real_escape_string($_POST['rep_name']) . "', '" . mysql_real_escape_string($_POST['rep_email']) . "', '" . mysql_real_escape_string($_POST['sex']) . "', '" . mysql_real_escape_string($_POST['post_description']) . "', NOW(), 0)";
				$reply_result = mysql_query($reply_sql);  
				if(!$reply_result)  
				{  
					//something went wrong, display the error  
					echo 'Something went wrong while replying to the post. Please try again later.'; 
					$sql = "ROLLBACK;"; 
					$result = mysql_query($sql);
				} 
				else 
				{ 
					$update_post_life = "UPDATE posts SET post_life = NOW() WHERE post_id=".mysql_real_escape_string($_GET['id']);
					$update_post_life_result = mysql_query($update_post_life);
					if(!$update_post_life_result)
					{
						echo 'Something went wrong while replying to the post. Please try again later.'; 
						$sql = "ROLLBACK;"; 
						$result = mysql_query($sql);
					}
					else
					{	
			//echo 'Posted Successfully! :-) Check <a href="post_clicked.php?id='. mysql_real_escape_string($_GET['id']).'">HERE</a>';
						$_SESSION['reply_post_id'] = 'post_clicked.php?id='.mysql_real_escape_string($_GET['id']);
						$_SESSION['reply_email'] = $_POST['rep_email'];
						$sql = "COMMIT;"; 
                    				$result = mysql_query($sql);
                    				header("Location: thank_you.php?sent=actionSendMail32minutes");
						exit();
						
					}	
				}

			}
			
		}
		else
		{
			echo '<div class="holder_content">';
			echo 'Content will not be displayed in here. It will be sent to the owner to his mailbox.';
			echo 'Mail function Start:';
			echo 'Ony post life has been updated accordingly';
			echo '</div>';
		}	
	}
}
/////////End Another transacion

include 'footer.php';  
?>  

<script type="text/javascript">
	var TheDiv = document.getElementById("TimePosted").innerHTML;
	//alert(TheDiv)
    mySplitResult = TheDiv.toString().split(":");
	var min = 29 - mySplitResult[0];
	var sec = 59 - mySplitResult[1];
	//alert("minutes " + min + ", seconds " + sec);
	var spanID = "theTime";
	function countDown(varID)
	{
		//alert(varID)
		sec--;
		if (sec == -01) 
		{
			sec = 59;
			min = min - 1; 
		}
		else 
		{
			min = min; 
		}
		if (sec<=9) 
		{ 
			sec = "0" + sec; 
		}
		time = (min<=9 ? "0" + min : min) + " : " + sec ;
		document.getElementById(varID).innerHTML = "<h3>" + time + "</h3>"; 
		SD=window.setTimeout("countDown('theTime');", 1000);
		if (min == '00' && sec == '00') 
		{ 
			sec = "00"; 
			window.clearTimeout(SD); 
		}
	}
	window.onload = countDown(spanID);
</script>
