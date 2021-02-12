<?php 
include 'db.php';
$q = isset($_GET["q"]) ? intval($_GET["q"]) : '';
 
if(empty($q)) {
    echo 'choose a supplement:';
    exit;
}
$result = mysqli_query($conn,"SELECT SupID, SupName FROM Supplement WHERE SupName = '".$q."'"); 
                    
echo "<table border='1'>
    <tr>
    <th>SupID</th>
    <th>SumName</th>
    </tr>";
 
while($row = mysqli_fetch_array($result))
{
    echo "<tr>";
    echo "<td>" . $row['SupID'] . "</td>";
    echo "<td>" . $row['SupName'] . "</td>";
    echo "</tr>";
}
echo "</table>";

include 'closeDB.php';
?>