
<?php

    $DBhost="host";
    $DBuser="your_dbuser";
    $DBpass="your_dbpass";
    $DBname="your_db_name";
    $conn=mysqli_connect($DBhost,$DBuser,$DBpass,$DBname);
    mysqli_set_charset($conn, "utf8");

    if(isset($_POST['deletBtn'])){
      $id = $_GET['id'];
      $deletSQL="DELETE FROM `all_payment` WHERE `id`='$id'";
      $queryResponse = mysqli_query($conn,$deletSQL);
      if($queryResponse==true){
        echo "Delete Successful";
      }else{
        echo "Delete Failed!";
      }
    }

?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>All Paytment</title>
    <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

</head>
<body>

    <div class="d-flex" id="wrapper">

    <?php include 'nav.php';?>

      <div class="container-fluid">
        <h3 style="text-align: center; margin-bottom:25px;margin-top:25px">Payment List</h3>
        <form method="POST" style="margin-bottom:10px">
          <div class="row">
            <div class="col-md-4">
              <select name="monthSelect" class="form-control">
                      <option>Show All</option>
                      <option>January</option>
                      <option>February</option>
                      <option>March</option>
                      <option>April</option>
                      <option>May</option>
                      <option>June</option>
                      <option>July</option>
                      <option>August</option>
                      <option>September</option>
                      <option>October</option>
                      <option>November</option>
                      <option>December</option>
              </select>
            </div>
              <div class="col-md-4">
              <select name="yearSelect" class="form-control">
                      <option>Show All</option>
                      <option>2020</option>
                      <option>2018</option>
                      <option>2019</option>
                      <option>2020</option>
                      <option>2021</option>
              </select>
            </div>
            <div class="col-md-2">
              <input type="submit" name="searchSubmit" value="Show" class="form-control btn btn-success">
            </div>
            <div class="col-md-6">
              
            </div>
          </div>
        </form>
        <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">IP</th>
      <th scope="col">Number</th>
      <th scope="col">Amount</th>
      <th scope="col">Paid</th>
      <th scope="col">Due</th>
      <th scope="col">Update</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
 
    if(isset($_POST['searchSubmit'])){
       $month = $_POST['monthSelect'];
       $year = $_POST['yearSelect'];
       if($month=='Show All'&&$year=='Show All'){
           $select_sql = "SELECT * FROM `all_payment` WHERE 1";
       }else if($month=='Show All'&&$year!='Show All'){
           $select_sql = "SELECT * FROM `all_payment` WHERE `payment_year`='$year'";
       }else if($month!='Show All'&&$year=='Show All'){
           $select_sql = "SELECT * FROM `all_payment` WHERE `payment_month`='$month'";
       }
       else{
           $select_sql = "SELECT * FROM `all_payment` WHERE `payment_month`='$month' AND `payment_year`='$year'";
       }

       $data = mysqli_query($conn,$select_sql);
       if(mysqli_num_rows($data)>0){
           while($row=mysqli_fetch_assoc($data)){ 
               $ip = $row['payment_ip'];
               $selectInfo="SELECT * FROM `all_user` WHERE `ip`='$ip'";
               $nameInfo = mysqli_fetch_assoc(mysqli_query($conn,$selectInfo));
               ?>
               <tr>
                   <td><?php echo $nameInfo['name'];?></td>
                   <td><?php echo $row['payment_ip'];?></td>
                   <td><?php echo $nameInfo['mobile_no'];?></td>
                   <td><?php echo $row['payment_amount'];?></td>
                   <td><?php echo $row['payment_paid'];?></td>
                   <td><?php echo $row['payment_due'];?></td>
            <td>
              <a class="btn btn-success" href="#">UPDATE</a>
            </td>
            <td>
              <form method="POST" action="#">
                    <button class="btn btn-danger" name="deletBtn" onclick="return confirm('DO You Want To Delete?')">DELETE</button>
              </form>
            </td>
               </tr>
               <?php
               
           }
       }else{
           echo "No Data Found";
       }
    }else{
        $totalAmount = 0;
        $totalPaid = 0;
        $totalDue = 0;
        $select_sql = "SELECT * FROM `all_payment` WHERE 1";
       $data = mysqli_query($conn,$select_sql);
       if(mysqli_num_rows($data)>0){
           while($row=mysqli_fetch_assoc($data)){ 
               
                $totalAmount = $totalAmount+$row['payment_amount'];
                $totalPaid = $totalPaid+$row['payment_paid'];
                $totalDue = $totalDue+$row['payment_due'];
                
               $ip = $row['payment_ip'];
               $selectInfo="SELECT * FROM `all_user` WHERE `ip`='$ip'";
               $nameInfo = mysqli_fetch_assoc(mysqli_query($conn,$selectInfo));
               ?>
               <tr>
                   <td><?php echo $nameInfo['name'];?></td>
                   <td><?php echo $row['payment_ip'];?></td>
                   <td><?php echo $nameInfo['mobile_no'];?></td>
                   <td><?php echo $row['payment_amount'];?></td>
                   <td><?php echo $row['payment_paid'];?></td>
                   <td><?php echo $row['payment_due'];?></td>
            <td>
              <a class="btn btn-success" href="#">UPDATE</a>
            </td>
            <td>
              <form method="POST" action="#">
                    <button class="btn btn-danger" name="deletBtn" onclick="return confirm('DO You Want To Delete?')">DELETE</button>
              </form>
            </td>
               </tr> 
               <?php
               
           }
           ?>
           <tr>
               <td></td>
               <td style="text-align:center;" colspan="2"><b>Total</b></td>
               <td><b><?php echo $totalAmount ; ?></b></td>
               <td><b><?php echo $totalPaid ; ?></b></td>
               <td><b><?php echo $totalDue ; ?></b></td>
               <td></td>
               <td></td>
           </tr>
           <?php
       }else{
           echo "No Data Found";
       }
    }
    ?>

  </tbody>
</table>
<!-- Button trigger modal -->
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

</body>
</html>
