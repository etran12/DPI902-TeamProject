<?php
/**
 * Displays site name.
 */
function siteName()
{
    echo config('name');
}
/**
 * Displays site version.
 */
function siteVersion()
{
    echo config('version');
}

/**
 * Displays page title. It takes the data from 
 * URL, it replaces the hyphens with spaces and 
 * it capitalizes the words.
 */
function pageTitle()
{
    $page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'Home';
    echo ucwords(str_replace('-', ' ', $page));
}
/**
 * Displays page content. It takes the data from 
 * the static pages inside the pages/ directory.
 * When not found, display the 404 error page.
 */
function pageContent()
{
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    $path = getcwd().'/'.config('content_path').'/'.$page.'.php';
    if (file_exists(filter_var($path, FILTER_SANITIZE_URL))) {
        include $path;
    } else {
        include config('content_path').'/404.php';
    }
}
/**
 * Starts everything and displays the template.
 */
function run(){
    include config('template_path').'/template.php';
}

function sqlConnection()
{
	//DB Variables
	$serverName = "localhost";
	//$username = "user";
	$username = "root";
	$password = "";
	//$password = "password";
	$dbName = "dpi902";
	
	// Create connection
	$conn = new mysqli($serverName, $username, $password, $dbName);
	// Check connection

	if ($conn->connect_error) 
	{
		echo $_GET['ID'];

		die("Connection failed: " . $conn->connect_error);
	}
	
	return $conn;
}

function display_comments($article_id, $conn, $offset, $page_result){
	$sqlquery = "SELECT * FROM ARTICLE_COMMENT WHERE ARTICLE_ID = ".$article_id." ORDER BY ID DESC LIMIT ".$offset.", ".$page_result;
	$comments = $conn->query($sqlquery) or die(mysql_error());	
	$margin = 0;
	$counter = 0;
	
	foreach($comments as $comment) {
		include 'content/comment.php';
		
		display_comments_replies($article_id, $comment['ID'], $comment["USERNAME"], $conn);
		$counter++;
	}
}

function display_comments_replies ($article_id, $parent_id, $to, $conn, $level=1) {
  $sqlquery = "SELECT * FROM ARTICLE_COMMENT_REPLY WHERE ARTICLE_ID = ".$article_id." AND COMMENT_ID = ".$parent_id;
  
  $comments = $conn->query($sqlquery) or die(mysql_error());	
  $margin = 10 * $level;
  
  foreach($comments as $comment) {
        $comment_id = $comment['ID'];  
		
		//$sqlquery = "SELECT USERNAME FROM ARTICLE_COMMENT_REPLY WHERE COMMENT_ID = ".$parent_id;
		//$res = $conn->query($sqlquery) or die(mysql_error());
		//$temp = $res->fetch_assoc();
		//$to = $temp["USERNAME"];
		
		require 'content/comment.php';
		$to = $comment['USERNAME'];
        display_comments_replies ($article_id, $comment_id, $to, $conn, $level+1);
    }
}    
?>