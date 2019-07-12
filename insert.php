<?php
//connects to the remote database and inserts data from the form to the database
$connect = mysqli_connect("arfo8ynm6olw6vpn.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306", "jnedqzu7lwxtjyqb", "dt7zlrfkbkb2elqt", "ktz2xy30pbetn2h6");
if(isset($_POST["name"], $_POST["description"], $_POST["account_number"], $_POST["bank_code"],  $_POST["amount"]))
{
$datapass= array('account_number' => $_POST["account_number"],'bank_code' =>$_POST["bank_code"]);
$calle= http_build_query($datapass);

$urle = "https://api.paystack.co/bank/resolve";
$url1 =$urle."?".$calle;
// a curl call to send the array to the Paystack api so we can create a new recepient
$ch1 = curl_init();
curl_setopt($ch1, CURLOPT_URL, $url1);
curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, 'GET');


$headers1 = [
  'Authorization: Bearer sk_test_ee6ffed0718d607063af1be81d911419bd4eb224',
  'Content-Type: application/json',

];
curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);

$request1 = curl_exec ($ch1);

curl_close ($ch1); 
  $userDetails = json_decode($request1);
  $status = $userDetails->status;
  if ($status == false){
    die ("<script type='text/javascript'>alert('Invalid details. Try again');</script>");
  }
  $name1 = $userDetails->data->account_name;
  $account_number1 = $userDetails->data->account_number;





 $name = mysqli_real_escape_string($connect, $name1);
 $description = mysqli_real_escape_string($connect, $_POST["description"]);
 $account_number = mysqli_real_escape_string($connect, $account_number1);
 $bank_code = mysqli_real_escape_string($connect, $_POST["bank_code"]);
 $amount = mysqli_real_escape_string($connect, $_POST["amount"]);
 $amount1 = $amount*100;

$query = "INSERT INTO suppliers(name, description, account_number, bank_code, amount) VALUES('$name', '$description', '$account_number', '$bank_code', '$amount1')";
$query2 = "SELECT type, name, description, account_number, bank_code, currency FROM suppliers ";


//to perform the query on the database
if(mysqli_query($connect, $query))
{
  echo 'Data Inserted';
}
else{
 echo "Cannot connect to Paystack. Check your connection";
}
// a second query to get the details entered from the database and put in an array
$result = mysqli_query($connect, $query2);
$data_array = array();
while ($row = mysqli_fetch_assoc($result)) 
{
     $data_array = $row;
}

$url = "https://api.paystack.co/transferrecipient";
// a curl call to send the array to the Paystack api so we can create a new recepient
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data_array)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$headers = [
  'Authorization: Bearer sk_test_ee6ffed0718d607063af1be81d911419bd4eb224',
  'Content-Type: application/json',

];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$request = curl_exec ($ch);

curl_close ($ch);
$extractname = json_decode($request);
$bankname = $extractname->data->details->bank_name;
$test = $bankname."8";
$query3 = "UPDATE suppliers SET bank_code ='$bankname' WHERE bank_code='$bank_code'";
if(mysqli_query($connect, $query3)){
  echo " worked";
}
//creates a temp entry to get the response from the call to obtain the recepient code from the Paystack api
$outfile = "list.json";
if($request) { 
  if(file_put_contents($outfile, $request))
  {
    echo " And Stored in the Database";
  }
  else
  {
    echo " but Error Storing Entry in Database";
  }
}


else {
  echo " but Cannot connect to Paystack. Check your connection";
}

}

?>
