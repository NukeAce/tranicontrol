<?php
//deletes the data from the database using id
$connect = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
if(isset($_POST["id"]))
{
 $query = "DELETE FROM suppliers WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Supplier Deleted';
 }
}
?>
