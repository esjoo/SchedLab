<!DOCTYPE>
  
<html>
<head>
    <title>Sign up</title>
    
</head>
<body>
    <?php
        include "db.php";
    ?>
    <!-- start header div -->
    <div id="header">
        <h3>NETTUTS > Sign up</h3>
    </div>
    <!-- end header div -->  
      
    <!-- start wrap div -->  
    <div id="wrap">
          
        <!-- start php code -->
        <?php
  
            if(isset($_POST['name']) && !empty($_POST['name']) AND isset($_POST['email']) && !empty($_POST['email'])){
                // Form Submited
            }       
              
        ?>
          
        <!-- stop php code -->
      
        <!-- title and description -->   
        <h3>Signup Form</h3>
        <p>Please enter your name and email addres to create your account</p>

        <?php 
            if(isset($msg)){  // Check if $msg is not empty
                echo '<div class="statusmsg">'.$msg.'</div>'; // Display our message and wrap it with a div with the class "statusmsg".
            } 
        ?>
          
        <!-- start sign up form -->  
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" value="" />
            <label for="email">Email:</label>
            <input type="text" name="email" value="" />
              
            <input type="submit" class="submit_button" value="Sign up" />
        </form>
        <!-- end sign up form -->
          
    </div>
    <!-- end wrap div -->
</body>
</html>