<html>
<head>
	<meta charset = "utf-8">
	<link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

<ul>
  <li><a class="active" href="index.php">Home</a></li>
  <li><a href="add_row.php">Add data</a></li>
  <li><a href="delete_row.php">Delete data</a></li>
  <li><a href="update_row.php">Edit & Update </a></li>
  
</ul>

 <?php // connect.php allows connection to the database

  require 'connect.php'; //using require will include the connect.php file each time it is called.

 // SELECT DATA FROM BOOK TABLE IN DATBASE  
  
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

print<<<_HTML
 </table>
	<br>
	<a href="index.php" target="_self"> <p>Home</p></a> 
_HTML;
	
	$result->close();
	$conn->close(); 
?> 

</body>	
</html>
