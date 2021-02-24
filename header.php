
<!DOCTYPE html>
<html lang="en">
<head>
    <title>schedLab</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js" integrity="sha512-7oYXeK0OxTFxndh0erL8FsjGvrl2VMDor6fVqzlLGfwOQQqTbYsGPv4ZZ15QHfSk80doyaM0ZJdvkyDcVO7KFA==" crossorigin="anonymous"></script>
  
    <style>
    img.format {
      height:70px;
    }
    p {
      margin:0px;
    }
    </style>
</head>


<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="index.php"><img src="gfx/logo.png" class="format"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" style="margin:0px" id="collapsibleNavbar">
    
    <!-- Nav options -->
    <ul class="navbar-nav">
      
      <!-- Signup -->
      <li class="nav-item">
        <?php if(isset($_SESSION['userName'])) {
          echo("<a class='nav-link' href='#'>". $_SESSION['userName']."</a>" );
          
          } else  {
          echo("<a class='nav-link' data-toggle='modal' href='#signup'> Register </a>");}
          include('signup.php');
        ?>
      </li> 
      
      <!--Login -->
      <li class="nav-item">
        <?php if(isset($_SESSION['userName'])) {
          echo("<a class='nav-link' href='#'>". $_SESSION['userName']."</a>" );
          } else {
          echo("<a class='nav-link' data-toggle='modal' href='#login'> Login </a>");}
          include('login.php');
        ?>
      </li>

      <!-- Protocols -->
      <li class="nav-item">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Protocols</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item">Reports</a>
                        <a href="insert.php" class="dropdown-item">Insert</a>
                        <div class="dropdown-divider"></div>
                        <a href="#"class="dropdown-item">Logout</a>
                    </div>
                </li>
            </ul>
	  
      </li>
      
    </ul>
  </div>  
</nav>

<body>