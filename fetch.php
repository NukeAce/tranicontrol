<?php
//connect to the database and get all columns

$connect = mysqli_connect("arfo8ynm6olw6vpn.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306", "jnedqzu7lwxtjyqb", "dt7zlrfkbkb2elqt", "ktz2xy30pbetn2h6");
$columns = array('id', 'type', 'name','description','account_number','bank_code','amount','currency');

$query = "SELECT * FROM suppliers ";
// for searching results in the rows by appending it to the og query
if(isset($_POST["search"]["value"]))
{
 $query .= '
 WHERE name LIKE "%'.$_POST["search"]["value"].'%" 
 OR description LIKE "%'.$_POST["search"]["value"].'%" 
 OR account_number LIKE "%'.$_POST["search"]["value"].'%" 
 OR bank_code LIKE "%'.$_POST["search"]["value"].'%" 
 OR amount LIKE "%'.$_POST["search"]["value"].'%" 
 ';
}
// sets the order in which the entries appear by appending queries to the og query from old to new and stacks them on each other
if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY id DESC ';
}

$query1 = '';
//what did this fix again i forget for the datatables
if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();
//this takes the result query and converts it into an associative array then stores it in row
while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="name">' . $row["name"] . '</div>';
 $sub_array[] = '<div contenteditable class="update" data-id="'.$row["id"].'" data-column="description">' . $row["description"] . '</div>';
 $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="account_number">' . $row["account_number"] . '</div>';
 $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="bank_code">' . $row["bank_code"] . '</div>';
 $sub_array[] = '<div class="update" data-id="'.$row["id"].'" data-column="amount">' . ($row["amount"]*0.01) . '</div>';
 $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Delete</button>';
 $sub_array[] = '<button type="button" name="pay" class="btn btn-info btn-xs pay" id="'.$row["id"].'">Pay Once</button>';

 $data[] = $sub_array;
}
// does what it says
function get_all_data($connect)
{
 $query = "SELECT * FROM suppliers";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}
//data for the datatable function
$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>
