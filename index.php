
<?php 
if(isset($_POST['sign_in'])){
	$username = mysqli_real_escape_string($connection, $_POST['username']);
	$password = mysqli_real_escape_string($connection, $_POST['password']);
	
	//Fetch user from data base
	$sql = "SELECT * FROM user_login WHERE username = '$username' AND password = '$password' LIMIT 1";
	$query = mysqli_query($connection,$sql) or die(mysqli_error());
	$data = mysqli_fetch_array($query);
	
	if(mysqli_num_rows($query)== true){
		
		if($data['user_type']==1){
		$_SESSION['username'] = $username;
		header("location:admin_home.php");
		}else
		if($data['user_type']==2){
		$_SESSION['username']=$username;
		header("location:pv_home.php");
		}else
		if($data['user_type']==3){
		$_SESSION['username']=$username;
		header("location:ca_home.php");
		}else
		if($data['user_type']==4){
		$_SESSION['username']=$username;
		header("location:av_home.php");
		}else
		if($data['user_type']==5){
		$_SESSION['username']=$username;
		header("location:wht_vat_home.php");
		}else
		{
		$_SESSION['username']='';
	$_SESSION['password']='';
	
	$error = "Invalid Username and Password";
		}
		
	}else
	$_SESSION['username']='';
	$_SESSION['password']='';
	
	$error = "Invalid Username and Password";
	
}
?>
<!DOCTYPE html >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mortgage Calculator</title>
<style>
body { 
  background: url(images/27.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
    }
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 50%;
    background-color: #46427A;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    align-content: center;
}

input[type=submit]:hover {
    background-color: #46427A;
    color:#eee;
}

}
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
<div style="margin:auto; font-weight:; max-width:500px; border:thin #ccc solid; min-height:500px; border-radius:15px; background-color:#fefefe; color: #46427A; padding:10px;">
    <h2>Mortgage Calculator</h2>
<form  action="" method="post">
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
    <input type="text" name="down-payment" placeholder="0"  class="" />
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
    <select name="loan_duration">
    <option>Select</option>    
    <option>Monthly</option>        
    </select>
     </div>
    </div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
    <span>Down Payment:</span> <?php if(isset($msg5)){echo $msg5;}?>
   <input type="text" name="down-payment" placeholder="0 amount" />
     </div>
    </div>
    <div class="col-lg-6 col-sm-6" > 
    <div class="form-group"> 
        <table>
   <tr><td colspan="2"> <span>Additional Payment:</span> <?php if(isset($msg5)){echo $msg5;}?></td></tr>
   <td><input type="text" name="year" placeholder="Year" /> </td><td><input type="text" name="month" placeholder="Month" /></td>
    </table>
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