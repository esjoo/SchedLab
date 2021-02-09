<?php
  $header = "header.php";
  $content = "home.php";
	$footer = "footer.php";

  session_start();
  include($header);
   
  include($content);
?>


<?php
	include($footer);
?>


</body>

