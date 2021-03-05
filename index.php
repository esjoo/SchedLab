<?php
  $header = "header.php";
  $content = "home.php";

  $register ='signup.php';
  include($header);
  if(isset($_SESSION['loggedIn'])) {
    include($content);
  } else {
    include($register);
  }
  
?>



</body>
</html>
