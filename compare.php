
<?php
session_start();

if(isset($_POST['login'])){
$P1 = $_POST['amount1'];
$I1 = $_POST['interest1'];
$J1 = $I1/(12*100);
$L1 = $_POST['loan_duration1'];
$Ex_pay_month1 = $_POST['month1'];
$Ex_pay_year1 = $_POST['year1'];
$N1 = $L1 * 12; //Actual Number of months the loan will be paid
$down_payment1 = $_POST['down_payment1'];
$P1 -= $down_payment1; //Total loan amount minus down payment
$loan_amount1 = $P1;

$P2 = $_POST['amount2'];
$I2 = $_POST['interest2'];
$J2 = $I2/(12*100);
$L2 = $_POST['loan_duration2'];
$Ex_pay_month2 = $_POST['month2'];
$Ex_pay_year2 = $_POST['year2'];
$N2 = $L2 * 12; //Actual Number of months the loan will be paid
$down_payment2 = $_POST['down_payment2'];
$P2 -= $down_payment2; //Total loan amount minus down payment
$loan_amount2 = $P2;
?>
<?php

function actual_calculation($P,$J,$N, $Ex_pay_year, $Ex_pay_month)
{
$M = $P * ($J/(1-(1 + $J)**(-$N))); // fixed monthly payment
    
$total_payment = $M * $N; // Supposed total pay of the mortgage
$actual_interest = $total_payment - $P; // The supposed interest to be paid  
$month = 1;// Counting the number of month payment was made
$total_interest = 0; //Total interest that will be paid at the end of the mortgage
    
while($P > 0){
$H = $P * $J; //curent monthly interest
$C = $M - $H; //Monthly payment minus Monthly interest = Monthly principal
//Check if month is 1 or 13 or 25 or 37 or 49 e.t.c
if($month % 12 == 1){
$C = $C + $Ex_pay_year;
$M += $Ex_pay_year; //Add yearly Extra payment to the monthly payment
}//end of yearly check condition
$C = $C + $Ex_pay_month; //Monthly payment minus Monthly interest plus Extra payment
$M += $Ex_pay_month; //Add monthly extra payment to the monthly payment
$Q = $P - $C; //Balance of your principal of your loan
        
if($month % 12 == 1){
$M -= $Ex_pay_year;
}
$M -= $Ex_pay_month;
$month = $month + 1; //Increment the month counter
if($Q < $M){
$M = $Q;
$C = $Q - $H;
        $Q = 0;
      }//End of inner if statement 
   $P = $Q; // set P equals to your principal balance
    $total_interest = $total_interest + $H;              
        
    }//End of while loop
    
    return array($total_interest,$month,$actual_interest);
}
 
    $result1 = actual_calculation($P1,$J1,$N1,$Ex_pay_year1,$Ex_pay_month1);  
    $payoff1 = $N1 - $result1[1];
    $total_interest1 = $result1[0];
    $actual_interest1 = $result1[2];
   
    
    $result2 = actual_calculation($P2,$J2,$N2,$Ex_pay_year2,$Ex_pay_month2);  
    $payoff2 = $N2 - $result2[1];
    $total_interest2 = $result2[0];
    $actual_interest2 = $result2[2];
       
    //Function to convert month to year
   function month_to_year($number_of_month){
        if($number_of_month < 0){
        echo "Invalid payoff number ";
        }elseif ($number_of_month == 0){
            echo "0 month";
        }elseif(0 < $number_of_month && $number_of_month < 12)
        {
            echo $number_of_month."  Month(s) ";
        }else
        {
         $Y = (int)($number_of_month / 12);
         $Z = $number_of_month % 12;
            If($Z == 0){ echo $Y."  Year(s)  ";
                       }else{
                        echo $Y."  Year(s)  ";
                        echo $Z." Month(s) ";
                    }//End of inner if condition
        }//End of outer else condition
    }//End of function month_to_year()
        
  
}


?>
<!DOCTYPE html >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Compare two Mortgage Calculator</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="styles/css/main.css" type="text/css"  />
</head>

<body>
    <?php include("include/menu.php"); ?>
    
<div class="container" style="margin:auto; max-width:1100px; background-color:transparent; margin-top:100px;  padding:10px;" >
    <form  action="compare.php" method="post">
        
<div class="col-lg-6 col-sm-6" style=" padding:25px; border:thin solid #55186d; border-radius:15px;">
    <h2>Mortgage Calculator 1</h2>
    <br>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Mortgage Amount:</span><?php if(isset($msg3)){echo $msg3;}?> 
    <input type="text" name="amount1" <?Php if(isset($_POST["amount1"])){echo 'value="'.$_POST["amount1"].'"' ; }?> />
     </div>
    </div>
      
      <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Interest Rate (% Per Year):</span> <?php if(isset($msg4)){echo $msg4;}?>
    <input type="text" name="interest1" <?Php if(isset($_POST["interest1"])){echo 'value="'.$_POST["interest1"].'"' ; }?> placeholder="0"  />
     </div>
	</div>
    
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Loan Duration:</span> <?php if(isset($msg5)){echo $msg5;}?>
    <select name="loan_duration1">
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
    <span>Payment Period:</span> <?php if(isset($msg6)){echo $msg5;}?>
    <select name="payment_period1">
    <option>Select</option>    
    <option>Monthly</option>        
    </select>
     </div>
    </div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Down Payment:</span>
   <input type="text" name="down_payment1" <?Php if(isset($_POST["down_payment1"])){echo 'value="'.$_POST["down_payment1"].'"' ; }?> placeholder="0 amount" />
     </div>
    </div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group">   
    <span>Additional Payment Per:</span>
   <input type="text" name="year1" <?Php if(isset($_POST["year1"])){echo 'value="'.$_POST["year1"].'"' ; }?> placeholder="Year" style="Width:45%;" /> <input type="text" name="month1" <?Php if(isset($_POST["month1"])){echo 'value="'.$_POST["month1"].'"' ; }?> placeholder="Month"  style="Width:45%;"/>
    
     </div>
    </div>
    <div class="col-lg-12 col-sm-12" style="margin-bottom:10px;"> 
    <span style="font-weight:bold;">Interest Saving: &nbsp;&nbsp;&#36;<?Php if(isset($actual_interest1)) echo number_format((float)($actual_interest1 - $total_interest1), 2, '.', ''); ?> </span>
     </div>
    <div class="col-lg-12 col-sm-12" style="margin-bottom:10px;"> 
    <span style="font-weight:bold;">Payoff Early by: &nbsp;&nbsp;<?Php if(isset($payoff1)) month_to_year($payoff1); ?> </span>
     </div>
    <div class="col-lg-12 col-sm-12" style="margin-bottom:10px;"> 
    <span style="font-weight:bold;">Loan + Interest: &nbsp;&nbsp;&#36;<?Php  if(isset($total_interest1)) echo number_format((float)($loan_amount1 + $total_interest1), 2, '.', ''); ?> </span>
     </div>
</div>

    
<div class="col-lg-6 col-sm-6" style="padding:25px; border:thin solid #55186d; border-radius:15px;">
    <h2>Mortgage Calculator 2</h2>
    <br>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Mortgage Amount:</span><?php if(isset($msg3)){echo $msg3;}?> 
    <input type="text" name="amount2" <?Php if(isset($_POST["amount2"])){echo 'value="'.$_POST["amount2"].'"' ; }?>/>
     </div>
    </div> 
      <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Interest Rate (% Per Year):</span> <?php if(isset($msg4)){echo $msg4;}?>
    <input type="text" name="interest2" <?Php if(isset($_POST["interest2"])){echo 'value="'.$_POST["interest2"].'"' ; }?> placeholder="0"  class="" />
     </div>
	</div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Loan Duration:</span> <?php if(isset($msg5)){echo $msg5;}?>
    <select name="loan_duration2">
    <option>Select Years</option>    
    <option <?Php if(isset($_POST["loan_duration2"])){echo 'value="'.$_POST["loan_duration2"].'"' ; }?>>10</option>    
    <option <?Php if(isset($_POST["loan_duration2"])){echo 'value="'.$_POST["loan_duration2"].'"' ; }?>>15</option>    
    <option<?Php if(isset($_POST["loan_duration2"])){echo 'value="'.$_POST["loan_duration2"].'"' ; }?>>20</option>    
    <option<?Php if(isset($_POST["loan_duration2"])){echo 'value="'.$_POST["loan_duration2"].'"' ; }?>>25</option>    
    <option<?Php if(isset($_POST["loan_duration2"])){echo 'value="'.$_POST["loan_duration2"].'"' ; }?>>30</option>    
    </select>
     </div>
    </div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Payment Period:</span> <?php if(isset($msg6)){echo $msg5;}?>
    <select name="payment_period2">
    <option>Select</option>    
    <option>Monthly</option>        
    </select>
     </div>
    </div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Down Payment:</span>
   <input type="text" name="down_payment2" <?Php if(isset($_POST["down_payment2"])){echo 'value="'.$_POST["down_payment2"].'"' ; }?> placeholder="0 amount" />
     </div>
    </div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group">    
    <span>Additional Payment Per:</span>
   <input type="text" name="year2" <?Php if(isset($_POST["year2"])){echo 'value="'.$_POST["year2"].'"' ; }?> placeholder="Year" style="Width:45%;" /> <input type="text" name="month2" <?Php if(isset($_POST["month2"])){echo 'value="'.$_POST["month2"].'"' ; }?> placeholder="Month"  style="Width:45%;"/>
     </div>
    </div>
    <div class="col-lg-12 col-sm-12" style="margin-bottom:10px;"> 
    <span style="font-weight:bold;">Interest Saving: &nbsp;&nbsp;&#36;<?Php if(isset($actual_interest2)) echo number_format((float)($actual_interest2 - $total_interest2), 2, '.', ''); ?> </span>
     </div>
    <div class="col-lg-12 col-sm-12" style="margin-bottom:10px;"> 
    <span style="font-weight:bold;">Payoff Early by: &nbsp;&nbsp;<?Php if(isset($payoff2)) month_to_year($payoff2); ?> </span>
     </div>
    <div class="col-lg-12 col-sm-12" style="margin-bottom:10px;"> 
    <span style="font-weight:bold;">Loan + Interest: &nbsp;&nbsp;&#36;<?Php if(isset($total_interest2)) echo number_format((float)($loan_amount2 + $total_interest2), 2, '.', ''); ?> </span>
     </div>
       </div>  
   <div class="col-sm-12 col-lg-12 text-center">
    <input type="submit" name="login" value="Submit" class="btn btn-primary"  style="width:100px;" />
    </div>
           
    </form>
</div>

<?php include("include/footer.php"); ?>

</body>
</html>