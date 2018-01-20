
<?php
session_start();

if(isset($_SESSION['fname']))
 $firstname = $_SESSION['fname'];
if(isset($_SESSION['lname']))
$lastname = $_SESSION['lname'];
if(isset($_SESSION['amount']))
$amount = $_SESSION['amount'];
if(isset($_SESSION['interest']))
$interest_rate = $_SESSION['interest'];
if(isset($_SESSION['loan_duration']))
$loan_duration = $_SESSION['loan_duration'];
if(isset($_SESSION['payment_period']))
$payment_period = $_SESSION['payment_period'];
if(isset($_SESSION['year']))
$additional_payment_year = $_SESSION['year'];
if(isset($_SESSION['month']))
$additional_payment_month = $_SESSION['month'];


/* Variable Declarations
** Note: The following assumes a typical conventional loan where the interest  is compounded monthly
** P = Principal, the initial amount of loan
** I = The anual interest rate (from 1 to 100 percent)
** L = Length, the length (in years) of the loan, or atleast the length over which the loan is amortized
** J = Monthly interest in decimal form - I/(12*100)
** N = Number of Months over which loan is amortized - L x 12
** Monthly payment (M) = p x (J/(1-(1+J)**(-N)))

** Calculate Amortization
** Step 1: Calculate H = PxJ -- current monthly interest
** Step 2: Calculate C = M - H -- This is the monthly payment - monthly interest so it is the amount of principal you pay for that month
** Step 3: Calculate Q = P - C -- Balance of your principal of your loan
** Step 4: Set P = Q and  and go back to Step 1. you thus, loop around until the value Q (and hence P) goes to zero
*/

$P = $_POST['amount'];
$I = $_POST['interest'];
$J = $I/(12*100);
$L = $_POST['loan_duration'];
$N = $L * 12;
$loan_amount = $P;


?>
<!DOCTYPE html >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Amortization Home</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="styles/css/main.css" type="text/css"  />
</head>

<body>
    <?php include("include/menu.php"); ?>
<div class="container" style="margin:auto; max-width:1000px;  margin-top:100px;" >
<div class="col-sm-6" style="margin-bottom:10px;"> 
<div id="formbd">

    <h2>Mortgage Calculator</h2>
    <br>
<form  action="" method="post">
   <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>First Name:</span><?php if(isset($msg1)){echo $msg1;}?> 
    <input type="text" name="fname" <?Php echo 'value="'.$_POST["fname"].'"' ; ?> />
     </div>
	</div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Last Name:</span><?php if(isset($msg1)){echo $msg1;}?> 
    <input type="text" name="lname" <?Php echo 'value="'.$_POST["lname"].'"' ; ?>/>
     </div>
	</div>
    
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Mortgage Amount:</span><?php if(isset($msg3)){echo $msg3;}?> 
    <input type="text" name="amount" <?Php echo 'value="'.$_POST["amount"].'"' ; ?>/>
     </div>
    </div>
      
      <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Interest Rate (% Per Year):</span> <?php if(isset($msg4)){echo $msg4;}?>
    <input type="text" name="interest"   <?Php echo 'value="'.$_POST["interest"].'"' ; ?> />
     </div>
	</div>
    
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Loan Duration:</span> <?php if(isset($msg5)){echo $msg5;}?>
    <select name="loan_duration" >
    <option><?Php echo $_POST["loan_duration"] ; ?></option>    
    
    </select>
     </div>
    </div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Payment Period:</span> <?php if(isset($msg5)){echo $msg5;}?>
    <select name="payment_period" <?Php echo 'value="'.$_POST["payment_period"].'"' ; ?>>
    <option><?Php echo $_POST["payment_period"] ; ?></option>            
    </select>
     </div>
    </div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Down Payment:</span> <?php if(isset($msg5)){echo $msg5;}?>
   <input type="text" name="down-payment"  <?Php echo 'value="'.$_POST["down_payment"].'"' ; ?> />
     </div>
    </div>
     <div class="col-lg-6 col-sm-6" > 
    <div class="form-group">    
    <span>Additional Payment Per:</span>
   <input type="text" name="year" <?Php echo 'value="'.$_POST["year"].'"' ; ?> style="Width:45%;" /> <input type="text" name="month" <?Php echo 'value="'.$_POST["month"].'"' ; ?>  style="Width:45%;"/>
     </div>
    </div>
    
    <div class="col-sm-12 col-lg-12 text-center">
    <input type="submit" name="login" value="Submit" class="btn btn-primary"   />
    </div>
    </form>
</div>
</div>
    <div class="col-sm-6">
<div style="margin:auto; max-width:500px; border:thin #46427A solid; max-height:550px; min-height:550; border-radius:10px; background-color:#fefefe; color:; padding:10px; overflow-y:scroll;">
    <h2>Amortization</h2>
    
    <p><b>Your Name:&nbsp;&nbsp;</b> <?Php echo $_POST["fname"].'  '.$_POST["lname"] ; ?></p>
    <table style="width:100%" id="mytable">
    <thead>
    <tr>
    <th>Month</th>
    <th>Payment</th>
    <th>Interest</th>
    <th>Principal</th>
    <th>Remaining</th>
    </tr>    
    </thead>
    <tbody>
        
    <?php
    $M = $P * ($J/(1-(1 + $J)**(-$N))); // fixed monthly payment
        $month = 1;
        $total_interest = 0;
    while($P > 0){
     $H = $P * $J; //curent monthly interest
     $C = $M - $H; //Monthly payment minus Monthly interest
     $Q = $P - $C; //Balance of your principal of your loan
     echo '<tr><td>'.$month.'</td><td>$'.number_format((float)$M, 2, '.', '').'</td><td>$'.number_format((float)$H, 2, '.', '').'</td><td>$'.number_format((float)$C, 2, '.', '').'</td><td>$'.number_format((float)$Q, 2, '.', '').'</td>';
        $month = $month + 1;
    if($Q < $M){
       $M = $Q;
        $C = $Q - $H;
        $Q = 0;
         echo '<tr><td>'.$month.'</td><td>$'.number_format((float)$M, 2, '.', '').'</td><td>$'.number_format((float)$H, 2, '.', '').'</td><td>$'.number_format((float)$C, 2, '.', '').'</td><td>$'.number_format((float)$Q, 2, '.', '').'</td>';
      }
      $total_interest = $total_interest + $H;  
   $P = $Q; // set P equals to your principal balance
        
            
        
    }    
    ?>
    
    </tbody>
    </table>
    

</div>
</div>
</div>
    
    <div class="container" style="margin:auto; max-width:950px;  margin-top:5px; background-color:#eee; padding:15px;" >
    <div class="col-lg-4 col-sm-4" style="margin-bottom:10px;"> 
    <span style="font-weight:bold;">Interest Saving: &nbsp;&nbsp;&#36;<?Php echo number_format((float)($loan_amount + $total_interest), 2, '.', ''); ?> </span>
     </div>
    <div class="col-lg-4 col-sm-4" style="margin-bottom:10px;"> 
    <span style="font-weight:bold;">Payoff Early by: &nbsp;&nbsp;&#36;<?Php echo number_format((float)($loan_amount + $total_interest), 2, '.', ''); ?> </span>
     </div>
    <div class="col-lg-4 col-sm-4" style="margin-bottom:10px;"> 
    <span style="font-weight:bold;">Loan + Interest: &nbsp;&nbsp;&#36;<?Php echo number_format((float)($loan_amount + $total_interest), 2, '.', ''); ?> </span>
     </div>
    </div>
   
<?php include("include/footer.php"); ?>

</body>
</html>