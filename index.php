<?php
  $header = "header.php";
  $content = "home.php";
	$footer = "footer.php";

  $register ='signup.php';
  include($header);
  if(isset($_SESSION['loggedIn'])) {
    include($content);
  } else {
    include($register);
  }
  
?>


<?php
	include($footer);
?>


</body>

