<?php
//deletes the data from the database using id
$connect = mysqli_connect("arfo8ynm6olw6vpn.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306", "jnedqzu7lwxtjyqb", "dt7zlrfkbkb2elqt", "ktz2xy30pbetn2h6");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM suppliers WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Recipient Deleted';
 }
}
?>
