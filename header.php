<?php 
if(!isset($_SESSION)) { 
        session_start(); 
      }
#declare helper functions 
require_once('includes/functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <title>schedLab</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <!--jquery,popper,bootstap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!--AngularJS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js" integrity="sha512-7oYXeK0OxTFxndh0erL8FsjGvrl2VMDor6fVqzlLGfwOQQqTbYsGPv4ZZ15QHfSk80doyaM0ZJdvkyDcVO7KFA==" crossorigin="anonymous"></script>
  <!--main styles -->
  <link rel="stylesheet" href="style/main.css">
  <!--utility functions -->
  <script src="scripts/login.js"></script>
  <script src="scripts/functions.js"></script>
</head>


<nav class="navbar navbar-expand-sm bg-dark navbar-dark">

  <a class="navbar-brand" href="index.php"><img src="gfx/logo.png"></a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" style="margin:0px" id="collapsibleNavbar">
    
    <!-- Nav options -->
    <ul class="navbar-nav">
      

      <!--Login -->
      <li class="nav-item">

      <?php if(isset($_SESSION['userName'])) {
        echo '<ul class="nav navbar-nav ml-auto">
                <li class="nav-item dropdown">';
        echo '<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">'.$_SESSION['userFirstName'].'</a>';
        echo '<div class="dropdown-menu dropdown-menu-left">
                  <a class="dropdown-item" href="account.php"> Account</a>
                  <a href="logout.php"class="dropdown-item">Logout</a>
                  </div>
                </li>
              </ul>
                ';
       

        } else  {
        echo("<a class='nav-link' data-toggle='modal' href='#login'> Login </a>");}
        include('login.php');
      ?>
      </li>

      <!-- Admin -->
      <?php
          $adminOptions= '
              <li class="nav-item">
              <ul class="nav navbar-nav ml-auto">
                  <li class="nav-item dropdown">
                      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Admin</a>
                      <div class="dropdown-menu dropdown-menu-right">
                          <a href="manageUsers.php" class="dropdown-item">Manage Users</a>
                          <a href="log.php" class="dropdown-item">Logs</a>    
                      </div>
                  </li>
              </ul>
          ';

      if(isset($_SESSION['isAdmin'])) {
        if($_SESSION['isAdmin']) {
          print($adminOptions);
        }
      }
      ?>

      <!-- Protocols -->
      <?php
      $navOptions = '
      <li class="nav-item">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Protocols</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item">Reports</a>
                        <a href="insert.php" class="dropdown-item">Insert</a>
                        <a href="protocolList.php" class="dropdown-item">All protocol</a>    
                    </div>
                </li>
            </ul>
    </li>
      <li class="nav-item">
        <a type="button" class="nav-link" data-toggle="collapse" data-target="#leftCol">Stats</a>
      </li>
      ';

      if(isset($_SESSION['userName'])) {
        print($navOptions);
      }
      ?>
      
      <!-- Inventory -->
       <?php
      $adminOptions_invent = '
      <li class="nav-item">
      <a type="button" class="nav-link" href="inventory.php" >Inventory</a>
      </li>
      ';
      
      if(isset($_SESSION['isAdmin'])) {
        if($_SESSION['isAdmin']) {
          print($adminOptions_invent);
        }
      }
      ?>
            
      <!-- Chemical consumption --> 
      <?php
      $adminOptions_chem = '
      <li class="nav-item">
      <a type="button" class="nav-link" href="chemicalCalcThis.php" >Chemical consumption</a>
      </li>
      ';
      
      if(isset($_SESSION['isAdmin'])) {
        if($_SESSION['isAdmin']) {
          print($adminOptions_chem);
        }
      }
      ?>
      
    </ul>
  </div>  
</nav>

<body ng-app="searchModule">

