<!--The html form -->
<html>
<head>
  <title>Trani</title>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  <style>
  body
  {
   margin:0;
   padding:0;
   background-color:#f1f1f1;
 }
  h1{
    background-color: #0d2a45;
    background-position: center;
    padding: 30px;
    font-family: "Graphik", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    font-size: 50px;
    font-weight: 900;
    color: white;

 }
 .box
 {
   width:1270px;
   padding:20px;
   background-color:#fff;
   border:1px solid #ccc;
   border-radius:5px;
   margin-top:25px;
   box-sizing:border-box;
 }
  footer
 {
   width:1270px;
   padding:20px;
   background-color:#fff;
   border:1px solid #ccc;
   border-radius:5px;
   margin-top:25px;
   margin-left:133px;
   box-sizing:border-box;
   

</style>
</head>
<body>
  <div class="container box">
   <h1 align="center">trani</h1>
   <br />
   <div class="table-responsive">
     <br />
     <div align="right">
       <button type="button" name="add" id="add" class="btn btn-info">Add</button>
     </div>
     <br />
     <div id="alert_message"></div>
     <table id="user_data" class="table table-bordered table-striped">
       <thead>
        <tr>
         <th>Name</th>
         <th>Description</th>
         <th>Account Number</th>
         <th>Bank</th>
         <th>Amount</th>
         <th></th>
         <th></th>
       </tr>
     </thead>
   </table>
 </div>
</div>
</body>
</html>
<!--Javascript and JQuery part -->
<script type="text/javascript" language="javascript" >
  $(document).ready(function(){

    fetch_data();
    //function that uses ajax to get the table data from fetch file
    function fetch_data()
    {
      var dataTable = $('#user_data').DataTable({
        "processing" : true,
        "serverSide" : true,
        "order" : [],
        "ajax" : {
          url:"fetch.php",
          type:"POST"
        }
      });
    }
    //For when you want to add a new recipient it creates the form cells and gives them an id and prepends the row to the table body
    $('#add').click(function(){
     var html = '<tr>';
     html += '<td contenteditable id="data1"></td>';
     html += '<td contenteditable id="data2"></td>';
     html += '<td><input id="data3" type= "number"/></td>';
     html += '<td align="center"> <select class="form-control" id="data4"> <option value= "058">Guarantee Trust Bank</option> <option value="044">Access Bank</option></select></td>';
     html += '<td><input id="data5" type= "number"></td>';
     html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Save</button></td>';
     html += '<td><button type="button" name="pay" id="pay" class="btn btn-info btn-xs">Pay Once</button></td>';
     html += '</tr>';
     $('#user_data').prepend(html);
   });
    //When you click insert this checks if all fields are valid and posts the data to the insert file
    $(document).on('click', '#insert', function(){
      var name = $('#data1').text();
      var description = $('#data2').text();
      var account_number = $('#data3').val();
      var bank_code = $('#data4').val();
      var amount = $('#data5').val();
      if(name != '' && description != '' && account_number != '' && bank_code != '' && amount != '')
      {
        $.ajax({
          url:"insert.php",
          method:"POST",
          data:{name:name, description:description, account_number:account_number, bank_code:bank_code, amount:amount},
          success:function(data)
          {
            $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
            $('#user_data').DataTable().destroy();
            fetch_data();
          }
        });
        setInterval(function(){
          $('#alert_message').html('');
        }, 5000);
      }
      else
      {
        alert("Please enter missing fields ");
      }
    }); 
    //delete the existing row of data
    $(document).on('click', '.delete', function(){
      var id = $(this).attr("id");
      if(confirm("Are you sure you want to remove this?"))
      {
        $.ajax({
          url:"delete.php",
          method:"POST",
          data:{id:id},
          success:function(data)
          {
            $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
            $('#user_data').DataTable().destroy();
            fetch_data();
          }
        })
      }  
    });

    //when you click pay it asks for confirmation then posts the id to the pay file
    $(document).on('click', '.pay', function(){
      var id = $(this).attr("id");
      if(confirm("Kindly check all values to ensure no error before clicking ok"))
      {
        $.ajax({
          url:"pay.php",
          method:"POST",
          data:{id:id},
          success:function(data)

          {
            $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
            $('#user_data').DataTable().destroy();
            $(this).remove();
            $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');

          }
        })
      }  
    });


    



  });
</script>
<footer align = "center">powered by <a href="https://paystack.com/" target="_blank" >paystack</a>

