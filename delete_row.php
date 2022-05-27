<html>
	<head>
		<meta charset = "utf-8">
		<link rel="stylesheet" type="text/css" href="delete_row.css">
	</head>
	<body>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="add_row.php">Add data</a></li>
			<li><a class ="active" href="delete_row.php">Delete data</a></li>
			<li><a href="update_row.php">Edit & Update </a></li>
		</ul>
	</body>
		
</html>

<?php // connect.php allows connection to the database

  require 'connect.php'; //using require will include the connect.php file each time it is called.
  
  
  /* Presence checks*/
    if (isset($_POST['id']) )
  {
    $id     = assign_data($conn, 'id');
	
    $validated = validate();
    
	if($validated && $found){
		$query    = "DELETE FROM category WHERE id = ".$_POST['id'];
		$result   = $conn->query($query);
		if (!$result) echo "<br><br>DELETE failed: $query<br>" .$conn->error . "<br><br>";
	}
  }
//end of delete command

echo<<<_HTML

  <form action="" method="post">
	
	<label for="id"> Book id(3 digits) for deletion: </label><br>
    <input type="text" name="id"> <br>
    
    <input type="submit" value="DELETE RECORD">
	
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
	global $found;
	$found = false;
	$error = "Book successfully deleted.";
	
	/*Presence checks*/
	if(empty($_POST['id'])){
		$error = "Please enter the Book id for deletion...";
		return false;
	}
	/*Check if ID exists*/
	$query  = "SELECT * FROM category";
	$result = $conn->query($query);
	if (!$result) die ("Database access failed: " . $conn->error);
	$rows = $result->num_rows;
	for($i = 0; $i< $rows; ++$i){
		$result->data_seek($i);
		$row = $result->fetch_array(MYSQLI_NUM);
		if($row[0] == $_POST['id']){
			$found = true;
		}
	}
	if($found == false){
		$error = "Book ID not found. Please check again";
		}
	return true;
}
//end of validate function 


function assign_data($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
  
  
?>

