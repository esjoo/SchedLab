<?php

include("db.php");

mysqli_query($conn, "DELETE FROM Experiment WHERE CalenID = ?");
mysqli_query($conn,"DELETE FROM UserCalendar WHERE CalenID = ?");

include("closedb.php");
header('Location: index.php');

?>