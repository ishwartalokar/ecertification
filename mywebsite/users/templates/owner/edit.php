<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:login.php');
}
else{
$eid=intval($_GET['Sid']);
if(isset($_POST['update']))
{

$fname=$_POST['firstName'];
$lname=$_POST['lastName'];   
$gender=$_POST['gender']; 
$dob=$_POST['dob']; 
$department=$_POST['department']; 
$address=$_POST['address']; 
$city=$_POST['city']; 
$country=$_POST['country']; 
$mobileno=$_POST['mobileno'];
$nssMember=$_POST['nssMember'];
$lastexam=$_POST['lastexam'];
$appearedExamName=$_POST['appearedExamName'];
$appearedExamMonth=$_POST['appearedExamMonth'];
$sql="update tstudent set FirstName=:fname,LastName=:lname,Gender=:gender,Dob=:dob,Department=:department,Address=:address,City=:city,Country=:country,Phonenumber=:mobileno,NSS=:nssMember,lastexam=:lastexam,appearedExamName=:appearedExamName,appearedExamMonth=:appearedExamMonth where id=:eid";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':lname',$lname,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':department',$department,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':country',$country,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':nssMember',$nssMember,PDO::PARAM_STR);
$query->bindParam(':lastexam',$lastexam,PDO::PARAM_STR);
$query->bindParam(':appearedExamName',$appearedExamName,PDO::PARAM_STR);
$query->bindParam(':appearedExamMonth',$appearedExamMonth,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$msg="Student record updated Successfully";
}

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/logo_mini.png">
  <link rel="icon" type="image/png" href="assets/img/logo_mini.png">
  <title>
    Update Profile | College e-Certification
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
  
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
</head>

<body class="g-sidenav-show bg-gray-200">
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://iT_Creation.in " target="_blank">
        <img src="../assets/img/logo_mini.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">College e-Certification</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary" href="../admin/dashboard">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="../admin/dashboard">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Departmet</span>
          </a>
          <div class="menu-collapse">
                            <ul style="list-style-type: none">
                                <li class="nav-link-text ms-1"><a class="nav-link text-white " href="../admin/department">Add Department</a></li>
                                <li class="nav-link-text ms-1"><a class="nav-link text-white " href="../admin/mdepartment">Manage Department</a></li>
                            </ul>
                        </div>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="../admin/dashboard">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">receipt_long</i>
            </div>
            <span class="nav-link-text ms-1">Certificate Types</span>
          </a>
          <div class="menu-collapse">
                            <ul style="list-style-type: none">
                                <li class="nav-link-text ms-1"><a class="nav-link text-white " href="../admin/addctype">Add Certificate Type</a></li>
                                <li class="nav-link-text ms-1"><a class="nav-link text-white " href="../admin/mcertificatetype">Manage Certificate Type</a></li>
                            </ul>
                        </div>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white " href="../admin/dashboard">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Students</span>
          </a>
          <div class="menu-collapse">
                            <ul style="list-style-type: none">
                                <li class="nav-link-text ms-1"><a class="nav-link text-white " href="../admin/addstudent">Add Student</a></li>
                                <li class="nav-link-text ms-1"><a class="nav-link text-white " href="../admin/mstudent">Manage Student</a></li>
                            </ul>
                        </div>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="../admin/dashboard">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">computer</i>
            </div>
            <span class="nav-link-text ms-1">Certificate Management</span>
          </a>
          <div class="menu-collapse">
                            <ul style="list-style-type: none">
                                <li class="nav-link-text ms-1"><a class="nav-link text-white " href="../admin/certificates">All Certificates</a></li>
                                <li class="nav-link-text ms-1"><a class="nav-link text-white " href="../admin/pchistory">Pending Certificates</a></li>
                            </ul>
                        </div>
        </li>

        
        
        
        <li class="nav-item">
          <a class="nav-link text-white " href="../admin/notifications.html">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">notifications</i>
            </div>
            <span class="nav-link-text ms-1">Notifications</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-white " href="capass">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">assignment</i>
            </div>
            <span class="nav-link-text ms-1">Change Password</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="../admin/logout">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">logout</i>
            </div>
            <span class="nav-link-text ms-1">Sign Out</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn bg-gradient-primary mt-4 w-100" href="admin/addstudent" type="button">Add Students</a>
      </div>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Admin</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">
            
            <li class="nav-item d-flex align-items-center">
              <a href="../admin/login" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Sign Out</span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span> from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                
                
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid px-2 px-md-4">
      <div class="page-header min-height-100 border-radius-xl mt-4" style="background-image: linear-gradient(to right, #434343 0%, black 100%);">
       <!-- <span class="mask  bg-gradient-primary  opacity-6"></span>-->
      </div>
      <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row gx-4 mb-2">

<!--***Upload Image***-->


		
            

<?php
        if (isset($_POST['submit'])) {
      
          $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
          $image_name = addslashes($_FILES['image']['name']);
          $image_size = getimagesize($_FILES['image']['tmp_name']);
      
          move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $_FILES["image"]["name"]);
          $location = "images/" . $_FILES["image"]["name"];
          $dbh->query("update tstudent set image = '$location' where Sid  = '$eid' ");
        ?>
        
        <?php
        }
        ?>

    <?php
$eid=$_SESSION['eid'];
$sql = "SELECT FirstName,LastName,Sid, phonenumber,Address,City,Country,EmailId,Dob,Department,pClass,image from  tstudent where id=:eid";
$query = $dbh -> prepare($sql);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$image = $user_row['image'];
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>
                              
                               
                         <?php }} ?>
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="<?php echo $result->image; ?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <a  class="text-info text-gradient" data-toggle="modal" data-target="#exampleModal">Click here to change your profile picture...</a>
          

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Profile Image ...</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="col-auto">
            <form name="updatemp"  class="form-horizontal" method="POST" enctype="multipart/form-data">
              <div class="control-group">
                
                <div class="controls">
                  <input type="file" name="image" class="font"  required>
                  <label class="control-label" for="input01">Click the above browse button to select and image...</label>
                </div>
              </div>
              <div class="control-group">
                <div class="controls modal-footer">
                  <button type="submit" name="submit" class="btn btn-success">Upload Image</button>
                </div>
              </div>
            </form>
                    
      </div>
    </div>
      </div>
      
    </div>
  </div>
</div>
          <div class="row">
          <div class="col-auto my-auto">
            
            <div class="h-100">
              
              <h5 class="mb-1">
              <?php echo htmlentities($result->FirstName." ".$result->LastName);?>
              </h5>
              <p class="mb-0 font-weight-normal text-sm">
              <?php echo htmlentities($result->Sid)?><br>
              <?php echo htmlentities("Student of ".$result->Department." of class ".$result->pClass."...")?>
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <div class="nav-wrapper position-relative end-0">
              
            </div>
          </div>
        </div>
        <div class="row">
          <div class="row">
            
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
                else if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                  <div class="row">
                    <div class="col-md-8 d-flex align-items-center">
                      
                      <h6 class="mb-0">Profile Information</h6>
                    </div>
                    <div class="col-md-4 text-end">
                    <form id="example-form" method="post" name="updatemp">
                      <button class="btn bg-success" type="submit" name="update"  id="update">
                        <i class="fas fa-save text-white text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Save Information"></i>
</button>
                    </div>
                  </div>
                </div>
                <div class="card-body p-3">
                <form id="example-form" method="post" name="updatemp">
                
                  <ul class="list-group">
                  

                  <?php 
$eid=intval($_GET['Sid']);
$sql = "SELECT * from  tstudent where id=:eid";
$query = $dbh -> prepare($sql);
$query -> bindParam(':eid',$eid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?> 

                  <table>
  
  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Student Code</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input class="disable-input enter-input"  name="empcode" id="empcode" value="<?php echo htmlentities($result->Sid);?>" type="text" autocomplete="off" readonly required></td>
  </tr>
  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">First Name</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input class="enter-input" id="firstName" name="firstName" value="<?php echo htmlentities($result->FirstName);?>"  type="text" required></td>
  </tr>
  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Last Name</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input class="enter-input"  id="lastName" name="lastName" value="<?php echo htmlentities($result->LastName);?>" type="text" autocomplete="off" required></td>
  </tr>
  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email id</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input class="disable-input enter-input"  name="email" type="email" id="email" value="<?php echo htmlentities($result->EmailId);?>" readonly autocomplete="off" required></td>
  </tr>
  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Mobile No.</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input class="disable-input enter-input" id="phone" name="mobileno" type="tel" value="<?php echo htmlentities($result->Phonenumber);?>" maxlength="10" readonly autocomplete="off" required></td>
  </tr>
  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Gender</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><select class="enter-input"  name="gender" autocomplete="off">
<option value="<?php echo htmlentities($result->Gender);?>"><?php echo htmlentities($result->Gender);?></option>                                          
<option value="Male">Male</option>
<option value="Female">Female</option>
<option value="Other">Other</option>
</select></td>
  </tr>

  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Date Of Birth</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input class="enter-input" id="birthdate" name="dob"  class="datepicker" value="<?php echo htmlentities($result->Dob);?>" ></td>
  </tr>

  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Department</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><select class="enter-input"  name="department" autocomplete="off">
<option value="<?php echo htmlentities($result->Department);?>"><?php echo htmlentities($result->Department);?></option>
<?php $sql = "SELECT DepartmentName from tbldepartments";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $resultt)
{   ?>                                            
<option value="<?php echo htmlentities($resultt->DepartmentName);?>"><?php echo htmlentities($resultt->DepartmentName);?></option>
<?php }} ?>
</select></td>
  </tr>

  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Current Class</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input class="enter-input" id="pclass" name="pclass" type="text"  value="<?php echo htmlentities($result->pClass);?>" autocomplete="off" required></td>
  </tr>

  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Address</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input  class="enter-input"id="address" name="address" type="text"  value="<?php echo htmlentities($result->Address);?>" autocomplete="off" required></td>
  </tr>

  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">City</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input class="enter-input" id="city" name="city" type="text"  value="<?php echo htmlentities($result->City);?>" autocomplete="off" required></td>
  </tr>

  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Country</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input class="enter-input"  id="country" name="country" type="text"  value="<?php echo htmlentities($result->Country);?>" autocomplete="off" required></td>
  </tr>
</table>
 

<!--<button type="submit" name="update"  id="update" class="btn btn-success">UPDATE</button>-->


<p class="mb-0 font-weight-normal text-sm">
Click above save icon to update your profile...
</p>
                    
                    
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <h6 class="mb-0">Additional Imformation</h6>
                </div>
                <div class="card-body p-3">
                <table>
  
  
                <tr>
                  <?php 
                  if($result->NSS==1)
                  {
                    $optNss="Yes";
                  }
                  else{
                    $optNss="No";
                  }
                  ?>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">N.S.S</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><select class="enter-input"  name="nssMember" autocomplete="off">
<option value="<?php echo htmlentities($result->NSS);?>"><?php echo $optNss;?></option>                                          
<option value="1">Yes</option>
<option value="0">No</option>
</select></td>
  </tr>
  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Last Exam</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input class="enter-input" id="lastexam" name="lastexam" value="<?php echo htmlentities($result->lastexam);?>"  type="text" required></td>
  </tr>
  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Appeared Exam</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input class="enter-input" id="appearedExamName" name="appearedExamName" value="<?php echo htmlentities($result->appearedExamName);?>"  type="text" required></td>
  </tr>
  <tr>
    <td class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Appeared Exam Schedule</strong></td>
    <td class="text-dark">:&nbsp;</td>
    <td><input class="enter-input" id="appearedExamMonth" name="appearedExamMonth" value="<?php echo htmlentities($result->appearedExamMonth);?>"  type="text" required></td>
  </tr>

  

  
</table>
<?php }}?>
</form>
                </div>
              </div>
            
          </div>
        </div>
      </div>
    </div>
    <footer class="footer py-4  ">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              © <script>
                document.write(new Date().getFullYear())
              </script>,
              made with <i class="fa fa-heart"></i> by
              <a href="https://iT_Creation.in" class="font-weight-bold" target="_blank">iT Creation</a>
              as a better certification solution.
            </div>
          </div>
          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.iT_Creation.in" class="nav-link text-muted" target="_blank">iT_Creation</a>
              </li>
              <li class="nav-item">
                <a href="https://www.iT_Creation.in/presentation" class="nav-link text-muted" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="https://www.iT_Creation.in/blog" class="nav-link text-muted" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://www.iT_Creation.in/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </div>
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
</body>

</html>
<?php } ?> 