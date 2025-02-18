<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:login.php');
}
else{

// code for update the read notification status
$isread=1;
$did=intval($_GET['Certificateid']);  
date_default_timezone_set('Asia/Kolkata');
$admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
$sql="update tcertificate set IsRead=:isread where id=:did";
$query = $dbh->prepare($sql);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->bindParam(':did',$did,PDO::PARAM_STR);
$query->execute();

// code for action taken on Certificate
if(isset($_POST['update']))
{ 
$did=intval($_GET['Certificateid']);
$description=$_POST['description'];
$status=$_POST['status'];   
date_default_timezone_set('Asia/Kolkata');
$admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
$sql="update tcertificate set AdminRemark=:description,Status=:status,AdminRemarkDate=:admremarkdate where id=:did";
$query = $dbh->prepare($sql);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':admremarkdate',$admremarkdate,PDO::PARAM_STR);
$query->bindParam(':did',$did,PDO::PARAM_STR);
$query->execute();
$msg="Certificate updated Successfully";
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
    Certificates Details | College e-Certification
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
.delete_icon{
    color:#FF033E !important;
}

.edit_icon{
    color:#00FA9A !important;
}
</style>
</head>

<body class="g-sidenav-show  bg-gray-200">
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
          <a class="nav-link text-white active" href="../admin/dashboard">
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
                                <li class="nav-link-text ms-1"><a class="nav-link text-white active bg-gradient-primary" href="../admin/certificates">All Certificates</a></li>
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
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Certificate Details</h6>
               
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
              <table id="example" class="table align-items-center mb-0">
                               
                                 
                               <tbody>
<?php 
$lid=intval($_GET['Certificateid']);
$sql = "SELECT tcertificate.id as lid,tstudent.FirstName,tstudent.LastName,tstudent.Sid,tstudent.id,tstudent.Gender,tstudent.Phonenumber,tstudent.EmailId,tcertificate.CertificateType,tcertificate.pursuingClass,tcertificate.Description,tcertificate.PostingDate,tcertificate.Status,tcertificate.AdminRemark,tcertificate.AdminRemarkDate from tcertificate join tstudent on tcertificate.Sid=tstudent.id where tcertificate.id=:lid";
$query = $dbh -> prepare($sql);
$query->bindParam(':lid',$lid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{         
 ?>  

                                   <tr>
                                       <td style="font-size:16px;"> <b>Student Name :</b></td>
                                         <td><a href="editstudent.php?Sid=<?php echo htmlentities($result->id);?>" target="_blank">
                                           <?php echo htmlentities($result->FirstName." ".$result->LastName);?></a></td>
                                         <td style="font-size:16px;"><b>Student Id :</b></td>
                                         <td><?php echo htmlentities($result->Sid);?></td>
                                         <td style="font-size:16px;"><b>Gender :</b></td>
                                         <td><?php echo htmlentities($result->Gender);?></td>
                                     </tr>

                                     <tr>
                                        <td style="font-size:16px;"><b>Student Email id :</b></td>
                                       <td><?php echo htmlentities($result->EmailId);?></td>
                                        <td style="font-size:16px;"><b>Student Contact No. :</b></td>
                                       <td><?php echo htmlentities($result->Phonenumber);?></td>
                                       <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                   </tr>

<tr>
                                        <td style="font-size:16px;"><b>Certificate Type :</b></td>
                                       <td><?php echo htmlentities($result->CertificateType);?></td>
                                        <td style="font-size:16px;"><b>Class :</b></td>
                                       <td><?php echo htmlentities($result->pursuingClass);?></td>
                                       <td style="font-size:16px;"><b>Posting Date</b></td>
                                      <td><?php echo htmlentities($result->PostingDate);?></td>
                                   </tr>

<tr>
                                        <td style="font-size:16px;"><b>Student Certificate Description : </b></td>
                                       <td colspan="5"><?php echo htmlentities($result->Description);?></td>
                                     
                                   </tr>

<tr>
<td style="font-size:16px;"><b>Certificate Status :</b></td>
<td colspan="5"><?php $stats=$result->Status;
if($stats==1){
?>
<span style="color: green">Approved</span>
<?php } if($stats==2)  { ?>
<span style="color: red">Not Approved</span>
<?php } if($stats==0)  { ?>
<span style="color: blue">waiting for approval</span>
<?php } ?>
</td>
</tr>

<tr>
<td style="font-size:16px;"><b>Admin Remark: </b></td>
<td colspan="5"><?php
if($result->AdminRemark==""){
echo "waiting for Approval";  
}
else{
echo htmlentities($result->AdminRemark);
}
?></td>
</tr>

<tr>
<td style="font-size:16px;"><b>Admin Action taken date : </b></td>
<td colspan="5"><?php
if($result->AdminRemarkDate==""){
echo "NA";  
}
else{
echo htmlentities($result->AdminRemarkDate);
}
?></td>

</tr>
<?php 
if($stats==0)
{

?>
<tr>
<td colspan="5">
    <!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
Take Action
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Action on Certificate...</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form name="adminaction" method="post">
      <div class="modal-body">
     <select class="browser-default" name="status" required="">
                                       <option value="">Choose your option</option>
                                       <option value="1">Approved</option>
                                       <option value="2">Not Approved</option>
                                   </select></p>
                                   <p><textarea id="textarea1" name="description" class="materialize-textarea" name="description" placeholder="Description" length="500" maxlength="500" required></textarea></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit"  name="update" value="Submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</td>
</tr>
<?php } ?>
</form>                                     </tr>
                                    <?php $cnt++;} }?>
                               </tbody>
                           </table>
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
                <a href="https://www.iT_Creation.in" class="font-weight-bold" target="_blank">iT_Creation</a>
                for a better certification.
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
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
</body>

</html>
<?php } ?>