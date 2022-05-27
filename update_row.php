<html>
	<head>
		<meta charset = "utf-8">
		<link rel="stylesheet" type="text/css" href="update_row.css">
	</head>
	<body>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="add_row.php">Add data</a></li>
			<li><a href="delete_row.php">Delete data</a></li>
			<li><a class = "active" href="update_row.php">Edit & Update </a></li>
		</ul>
	</body>
		
</html>

<?php // connect.php allows connection to the database

  require 'connect.php'; //using require will include the connect.php file each time it is called.

  /* Presence checks*/
    if (isset($_POST['title'])){
		$title  = assign_data($conn, 'title');
	}
	else{
		$title = validate_title();
	}
    if (isset($_POST['author'])){
		$author = assign_data($conn, 'author');
	}
	else{
		$author = validate_author();
	}
    if (isset($_POST['pages'])){
		$pages = assign_data($conn, 'pages');
	}
	else{
		$pages = validate_pages();
	}
    if (isset($_POST['year'])){
		$year = assign_data($conn, 'year');
	}
	else{
		$year = validate_year();
	}
	
    $validated = validate();
    
	if($validated && $found){
		$query    = "UPDATE category SET title = '".$title."' WHERE id = ".$_POST['id'];
		$result   = $conn->query($query);
		if (!$result) echo "<br><br>UPDATE failed: $query<br>" .$conn->error . "<br><br>";
			
		$query    = "UPDATE category SET author = '".$author."' WHERE id = ".$_POST['id'];
		$result   = $conn->query($query);
		if (!$result) echo "<br><br>UPDATE failed: $query<br>" .$conn->error . "<br><br>";
			
		$query    = "UPDATE category SET pages = ".$pages." WHERE id = ".$_POST['id'];
		$result   = $conn->query($query);
		if (!$result) echo "<br><br>UPDATE failed: $query<br>" .$conn->error . "<br><br>";
			
		$query    = "UPDATE category SET year = ".$year." WHERE id = ".$_POST['id'];
		$result   = $conn->query($query);
		if (!$result) echo "<br><br>UPDATE failed: $query<br>" .$conn->error . "<br><br>";
	}
//end of add command

echo<<<_HTML

  <form action="" method="post">

	<label for = "id"> Enter current Book ID(3 digits) for changes:</label>
    <input type="text" name="id"></br>
	
	<p class = 'bold_purple'>Fill in the changes accordingly. Leave the field blank if the data is unchanged.</p>
	
    <label for="title"> Book title(up to 100 characters): </label><br>
    <input type="text" name="title"><br>
    
    <label for="author"> Author name(up to 50 characters): </label><br>
    <input type="text" name="author"><br>
    
    <label for="pages"> Page numbers: </label><br>
    <input type="text" name="pages"><br>
    
    <label for="year"> Published year(4 digits): </label><br>
    <input type="text" name="year"><br>
    
    <input type="submit" name= "submit_button" value="Submit row">
	
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
			else {
				echo "0 results";
			}
			
$conn->close();

function validate(){
	global $error;
	global $conn;
	global $found;
	$found = false;
	$error = "Book successfully changed";
	
	/*ID check*/
	if(empty($_POST['id'])){
		$error = "Please enter the current Book id...";
		return false;
	}
	else{
		$query  = "SELECT * FROM category";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		for($i = 0; $i< $rows; ++$i){
			$result->data_seek($i);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if($row['id'] == $_POST['id']){
				$found = true;
				return true;
			}
		}
	}
	$error = "ID not found...";
	return false;
}
//end of validate function 
function validate_title(){
	global $conn;
	if(empty($_POST['title'])){
		$query  = "SELECT * FROM category";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		for($i = 0; $i< $rows; ++$i){
			$result->data_seek($i);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if($row['id'] == $_POST['id']){
				return $row['title'];
			}
		}
	}
}
function validate_author(){
	global $conn;
		if(empty($_POST['author'])){
		$query  = "SELECT * FROM category";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		for($i = 0; $i< $rows; ++$i){
			$result->data_seek($i);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if($row['id'] == $_POST['id']){
				return $row['author'];
			}
		}
	}
}
function validate_pages(){
	global $conn;
		if(empty($_POST['pages'])){
		$query  = "SELECT * FROM category";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		for($i = 0; $i< $rows; ++$i){
			$result->data_seek($i);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if($row['id'] == $_POST['id']){
				return $row['pages'];
			}
		}
	}
}
function validate_year(){
	global $conn;
		if(empty($_POST['year'])){
		$query  = "SELECT * FROM category";
		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;
		for($i = 0; $i< $rows; ++$i){
			$result->data_seek($i);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if($row['id'] == $_POST['id']){
				return $row['year'];
			}
		}
	}
}
function assign_data($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
