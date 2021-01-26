
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Website Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
  .fakeimg {
    height: 200px;
    background: #aaa;
  }
  </style>
</head>



<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="index.php">SchedLab</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
      <?php if(isset($_SESSION['user'])) {
        echo("<a class='nav-link' href='#'>". $_SESSION['user']."</a>" );
        
        } else  {
        echo("<a class='nav-link' data-toggle='modal' href='#myModal'> Login/Register </a>");}
        include('loginForm.php');
      ?>
        
        
 

      </li>
      <li class="nav-item">
        <a class="nav-link" href="calendar.php">Calendar</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Protocols</a>
	  </li> 
	  <li class="nav-item">
        <a class="nav-link" href="#">Inventory</a>
	  </li>   
	  <li class="nav-item">
        <a class="nav-link" href="#">Help</a>
	  </li>  
	  <li class="nav-item">
        <a class="nav-link" href="#">About us</a>
      </li>   
      <li class="nav-item">
        <a class="nav-link" href="#">Logout</a>
      </li>  
    </ul>
  </div>  
</nav>

<div class="jumbotron text-center" style="margin-bottom:0">
  <h1>Our LIMS</h1>
  <p>This is a place holder</p> 
</div>

<body>