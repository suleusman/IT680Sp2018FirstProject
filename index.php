
<?php 
session_start();

if(isset($_POST['login'])){
    $firstname = $_POST['fname'];
	$lastname = $_POST['lname'];
    $amount =$_POST['amount'];
	$interest_rate = $_POST['interest'];
	$loan_duration = $_POST['loan_duration'];
	$payment_period = $_POST['payment_period'];
	$down_payment = $_POST['down_payment'];
	$additional_payment_year = $_POST['year'];
	$additional_payment_month = $_POST['month'];
}


?>
<!DOCTYPE html >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mortgage Calculator</title>

</style>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="styles/css/main.css" type="text/css"  />
</head>

<body>
    <?php include("include/menu.php"); ?>
<div class="container" style="margin:auto; max-width:1000px; background-color:transparent; margin-top:100px;" >
<div class="col-sm-12">
<div id="formbd">
    <h2>Mortgage Calculator</h2>
    <br>
<form  action="amortization.php" method="post">
   <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>First Name:</span><?php if(isset($msg1)){echo $msg1;}?> 
    <input type="text" name="fname" />
     </div>
	</div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Last Name:</span><?php if(isset($msg1)){echo $msg1;}?> 
    <input type="text" name="lname"  />
     </div>
	</div>
    
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Mortgage Amount:</span><?php if(isset($msg3)){echo $msg3;}?> 
    <input type="text" name="amount"/>
     </div>
    </div>
      
      <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Interest Rate (% Per Year):</span> <?php if(isset($msg4)){echo $msg4;}?>
    <input type="text" name="interest" placeholder="0"  class="" />
     </div>
	</div>
    
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Loan Duration:</span> <?php if(isset($msg5)){echo $msg5;}?>
    <select name="loan_duration">
    <option>Select Years</option>    
    <option>10</option>    
    <option>15</option>    
    <option>20</option>    
    <option>25</option>    
    <option>30</option>    
    </select>
     </div>
    </div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Payment Period:</span> <?php if(isset($msg5)){echo $msg5;}?>
    <select name="payment_period">
    <option>Select</option>    
    <option>Monthly</option>        
    </select>
     </div>
    </div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Down Payment:</span> <?php if(isset($msg5)){echo $msg5;}?>
   <input type="text" name="down_payment" placeholder="0 amount" />
     </div>
    </div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
        
    <span>Additional Payment Per:</span>
   <input type="text" name="year" placeholder="Year" style="Width:45%;" /> <input type="text" name="month" placeholder="Month"  style="Width:45%;"/>
    
     </div>
    </div>
    
    <div class="col-sm-12 col-lg-12 text-center">
    <input type="submit" name="login" value="Submit" class="btn btn-primary"   />
    </div>
    </form>
</div>
</div>
</div>
<?php include("include/footer.php"); ?>

</body>
</html>