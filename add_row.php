<html>
	<head>
		<meta charset = "utf-8">
		<link rel="stylesheet" type="text/css" href="add_row.css">
	</head>
	<body>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a class = "active" href="add_row.php">Add data</a></li>
			<li><a href="delete_row.php">Delete data</a></li>
			<li><a href="update_row.php">Edit & Update </a></li>
		</ul>
	</body>
		
</html>

<?php // connect.php allows connection to the database

  require 'connect.php'; //using require will include the connect.php file each time it is called.
  
  
  /* Presence checks*/
    if (isset($_POST['id'])   &&
        isset($_POST['title']) &&
        isset($_POST['author']) &&
        isset($_POST['pages']) &&
        isset($_POST['year']) 
		)
  {
    $id     = assign_data($conn, 'id');
    $title  = assign_data($conn, 'title');
    $author = assign_data($conn, 'author');
    $pages = assign_data($conn, 'pages');
    $year = assign_data($conn, 'year');
	
    $validated = validate();
    
	if($validated){
	$query    = "INSERT INTO category VALUES ('$id', '$title', '$author', '$pages', '$year')";
    $result   = $conn->query($query);
		if (!$result) echo "<br><br>INSERT failed: $query<br>" .$conn->error . "<br><br>";
	}
  }
//end of add command

echo<<<_HTML

  <form action="" method="post">
	
	<label for="id"> Book id(3 digits): </label><br>
    <input type="text" name="id"> <br>
    
    <label for="title"> Book title(up to 100 characters): </label><br>
    <input type="text" name="title"> <br>
    
    <label for="author"> Author name(up to 50 characters): </label><br>
    <input type="text" name="author"> <br>
    
    <label for="pages"> Page numbers: </label><br>
    <input type="text" name="pages"> <br>
    
    <label for="year"> Published year(4 digits): </label><br>
    <input type="text" name="year"> <br><br>
    
    <input type="submit" value="ADD RECORD">
	
   </form>
_HTML;

  echo "<p>";
  if(isset($error)){echo "<p class= 'bold_red'><em>$error</em></p>";}
  echo "</p>";
  
/*Printing the updated table*/
  $query  = "SELECT * FROM category";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);
  $rows = $result->num_rows;
print<<<_HTML
  
  <p class="bold"> Here is your Books list </p>
	
	<table id = "book_table">
		  <tr>
			<th>Book id</th>
			<th>Title</th>
			<th>Author</th>
			<th>Page numbers</th>
			<th>Published year</th>
		  </tr>
_HTML;
 
 if ($result->num_rows >0)
			{
			while($row = $result->fetch_assoc()) 
				{
						echo "<tr>";
						echo "<td>".$row["id"]."</td>";
						echo "<td>".$row["title"]."</td>";
           				echo "<td>".$row["author"]."</td>";
           				echo "<td>".$row["pages"]."</td>";
           				echo "<td>".$row["year"]."</td>";
			            
					    		
						echo "</tr>";
				}
			} 
			else 
			{
				echo "0 results";
			}
			
$conn->close();

function validate(){
	global $error;
	global $conn;
	$error = "Book successfully addded.";
	
	/*Presence checks*/
	if(empty($_POST['id'])){
		$error = "Please enter the Book id...";
		return false;
	}
	else if(empty($_POST['title'])){
		$error = "Please enter the Book title...";
		return false;
	}
	else if(empty($_POST['author'])){
		$error = "Please enter the Author name...";
		return false;
	}
	else if(empty($_POST['pages'])){
		$error = "Please enter the Page numbers...";
		return false;
	}
	else if(empty($_POST['year'])){
		$error = "Please enter the Published year...";
		return false;
	}
	else if(is_numeric($_POST['id'])==false){
		$error = "Please enter a <em>number</em> for Book id...";
		return false;
	}
	else if(strlen($_POST['title'])>100){
		$error = "Book title too long! Please re-enter the Book title...";
		return false;
	}
	else if(strlen($_POST['author'])>50){
		$error = "Author name too long! Please re-enter the Author name...";
		return false;
	}
	/*Unique id check*/
	$query  = "SELECT * FROM category";
	$result = $conn->query($query);
	if (!$result) die ("Database access failed: " . $conn->error);
	$rows = $result->num_rows;
	for($i = 0; $i< $rows; ++$i){
		$result->data_seek($i);
		$row = $result->fetch_array(MYSQLI_NUM);
		if($row[0] == $_POST['id']){
			$error = "This Book ID has already existed! Please enter a different one...";
			return false;
			}
		}
	
	/*Type checks*/
	return true;
	}
//end of validate function 


function assign_data($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
  
  
?>
