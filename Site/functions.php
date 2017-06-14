<?php

class Pagination {
	private $offset = 0;
	private $page_result = 0;
	private $rowCount = 0;
	
	public function __construct($page_result, $rowCount){
		 $this->page_result = $page_result;
		 $this->rowCount = $rowCount;

		 if($_GET['pageno']){
			$page_value = $_GET['pageno'];
			if($page_value > 1){	
				$this->offset = ($page_value - 1) * $this->page_result;
			}
		}
	}
	
	public function getOffset(){
		return $this->offset;
	}
	
	public function getResultLimit(){
		return $this->page_result;
	}
	
	public function display(){
		if($this->rowCount > $this->page_result){
			$num = $this->rowCount / $this->page_result;
			
			$current_url = explode("?", $_SERVER['REQUEST_URI']);
			$current_arguments = explode("&", $current_url[1]);

			$temp = "?";
			for($i = 0; $i < count($current_arguments)-1; $i++){
				if($i==0){
					$temp .= $current_arguments[$i];
				}else{
					$temp .= "&".$current_arguments[$i];
				}
			}
			
			if($_GET['pageno'] > 1){
				echo "<li><a href = '".$temp."&pageno=".($_GET['pageno'] - 1)."'> Prev </a></li>";
			}
				
			for($i = 1 ; $i < $num + 1 ; $i++){
				echo "<li";
				if($_GET['pageno'] == $i){
					echo " class = 'active'";
				}
				echo ">";
					
				echo "<a href = '".$temp."&pageno=".$i."'>".$i."</a></li>";
			}
				
			if($_GET['pageno'] < $num){
				echo "<li><a href = '".$temp."&pageno=".($_GET['pageno'] + 1)."'> Next </a></li>";
			}	
		}
		
	}
}

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


function display_comments($article_id, $conn, $offset, $page_result, $parent_id=0, $name=NULL, $level=0){
	  $temp = "";
	  if($parent_id > 0){
		  $temp = "COMMENT_ID = ".$parent_id;
	  }else{
		  $temp = "COMMENT_ID IS NULL";
	  }
	  
	  $sqlquery = "SELECT * FROM ARTICLE_COMMENT WHERE ARTICLE_ID = ".$article_id." AND ".$temp." ORDER BY ID DESC LIMIT ".$offset.", ".$page_result;
	  	
	  $comments = $conn->query($sqlquery) or die(mysql_error());	
	  $margin = 10 * $level;
	  $to = $name;
	  
      $counter = 0;	
	  if($parent_id!=0) $counter = NULL;
		  
	  foreach($comments as $comment) {
		   $comment_id = $comment['ID'];  
		   $username = $comment['USERNAME'];
		   
		   include 'content/comment.php';
		   display_comments ($article_id, $conn, $offset, $page_result, $comment_id, $username, $level+1);
		   if($parent_id==0) $counter++;
	  }	
}  
?>