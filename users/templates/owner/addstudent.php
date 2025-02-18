<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:login.php');
}
else{
if(isset($_POST['add']))
{
$Sid=$_POST['empcode'];
$fname=$_POST['firstName'];
$lname=$_POST['lastName'];   
$email=$_POST['email']; 
$password=md5($_POST['password']); 
$gender=$_POST['gender']; 
$dob=$_POST['dob']; 
$department=$_POST['department']; 
$pclass=$_POST['pclass']; 
$address=$_POST['address']; 
$city=$_POST['city']; 
$country=$_POST['country']; 
$mobileno=$_POST['mobileno']; 
$status=1;

$sql="INSERT INTO tstudent(Sid,FirstName,LastName,EmailId,Password,Gender,Dob,Department,pClass,Address,City,Country,Phonenumber,Status) VALUES(:Sid,:fname,:lname,:email,:password,:gender,:dob,:department,:pclass,:address,:city,:country,:mobileno,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':Sid',$Sid,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':lname',$lname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':department',$department,PDO::PARAM_STR);
$query->bindParam(':pclass',$pclass,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':country',$country,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Student record added Successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

}

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/logo_mini.png">
  <link rel="icon" type="image/png" href="../assets/img/logo_mini.png">
  <title>
    Register Student | College e-Certification
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.0.5" rel="stylesheet" />
  

  <style>
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
        </style>
        <script type="text/javascript">
function valid()
{
if(document.addemp.password.value!= document.addemp.confirmpassword.value)
{
alert("New Password and Confirm Password Field do not match  !!");
document.addemp.confirmpassword.focus();
return false;
}
return true;
}
</script>

<script>
function checkAvailabilitySid() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'empcode='+$("#empcode").val(),
type: "POST",
success:function(data){
$("#Sid-availability").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

<script>
function checkAvailabilityEmailid() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#email").val(),
type: "POST",
success:function(data){
$("#emailid-availability").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
</head>

<body class="">
  <div class="container  z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
          <div class="container-fluid ps-2 pe-0">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="../admin/dashboard">
              College e-Certification
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="../admin/dashboard">
                    <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                    Dashboard
                  </a>
                </li>
                
              </ul>
              <ul class="navbar-nav d-lg-flex d-none">
                <li class="nav-item d-flex align-items-center">
                  <a class="btn btn-outline-primary btn-sm mb-0 me-2" target="_blank" href="mstudent">Manage Student</a>
                </li>
                
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>

  
  <main class="main-content  mt-6">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('https://biot.su/wp-content/uploads/2019/10/0efcc0ca1d62e67a5dbb6af52041bcad-2048x1361.png'); background-size: cover;">
              </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
              <div class="card card-plain">
              
                <div class="card-header">
                  <h4 class="font-weight-bolder">Add Student</h4>
                  <p class="mb-0">Enter valid details of students...</p>
                </div>
                <div class="card-body">
                <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
                else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                  <form role="form" method="post" name="addemp">
                  <span id="Sid-availability" style="font-size:12px;"></span> 
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label" for="empcode">Student Code</label>
                      <input class="form-control"  name="empcode" id="empcode" onBlur="checkAvailabilitySid()" type="text" autocomplete="off" oninvalid="this.setCustomValidity('Enter valid student code')" required>
                    </div>
                    
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">First Name</label>
                      <input class="form-control" id="firstName" name="firstName" type="text" required>
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Last Name</label>
                      <input  class="form-control" id="lastName" name="lastName" type="text" autocomplete="off" required>
                    </div>

                    <div class="input-group input-group-outline mb-3">
                      
                      <select class="form-control"  name="gender" autocomplete="off">
<option value="">Gender...</option>                                          
<option value="Male">Male</option>
<option value="Female">Female</option>
<option value="Other">Other</option>
</select>
                    </div>

                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Birthdate</label>
                      <input  class="form-control datepicker" id="birthdate" name="dob" type="date"  autocomplete="off">
                    </div>

                    <div class="input-group input-group-outline mb-3">
                    <select class="form-control"  name="department" autocomplete="off">
<option value="">Department...</option>
<?php $sql = "SELECT DepartmentName from tbldepartments";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>                                            
<option value="<?php echo htmlentities($result->DepartmentName);?>"><?php echo htmlentities($result->DepartmentName);?></option>
<?php }} ?>
</select>
                    </div>

                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Class</label>
                      <input  class="form-control" id="pclass" name="pclass" type="text" autocomplete="off" required>
                    </div>

                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Address</label>
                      <input class="form-control"  id="address" name="address" type="text" autocomplete="off" required>
                    </div>

                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">City</label>
                      <input class="form-control"  id="city" name="city" type="text" autocomplete="off" required>
                    </div>

                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Country</label>
                      <input class="form-control"  id="country" name="country" type="text" autocomplete="off" required>
                    </div>

                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Mobile No.</label>
                      <input class="form-control"  id="phone" name="mobileno" type="tel" maxlength="10" autocomplete="off" required>
                    </div>
                    <span id="emailid-availability" style="font-size:12px;"></span> 
                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Email id</label>
                      <input class="form-control"  name="email" type="email" id="email" onBlur="checkAvailabilityEmailid()" autocomplete="off" required>
                      
                    </div>

                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Password</label>
                      <input class="form-control"  id="password" name="password" type="password" autocomplete="off" required>
                    </div>

                    <div class="input-group input-group-outline mb-3">
                      <label class="form-label">Confirm Password</label>
                      <input class="form-control"  id="confirm" name="confirmpassword" type="password" autocomplete="off" required>
                    </div>
                    <!--<div class="form-check form-check-info text-start ps-0">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                      <label class="form-check-label" for="flexCheckDefault">
                        I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                      </label>
                    </div>-->
                    <div class="text-center">
                      <button type="submit" name="add" onclick="return valid();" id="add" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Add</button>
                    </div>
                  </form>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php include('../uiplugin.php'); ?>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.0.5"></script>
  <!-- Javascripts -->
  <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
  
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
</body>

</html>
<?php } ?> 