<link rel="stylesheet" href="style/protocol.css">
<?php
include "header.php";
include "db.php";
?>

<h1 id="demofont3">Log Records</h1>
<div class="color">
    <table>
        <tr><th><h6 id="demofont4">Time</h6></th><th><h6 id="demofont4">User</h6></th><th><h6 id="demofont4">Action</h6></th></tr>
        <?php
        $sql = "SELECT logs.Timestamp, users.UserName, logs.Action 
        FROM logs 
        LEFT JOIN users 
        ON logs.UserAction=users.UserID 
        ORDER BY logs.Timestamp";
        $result = mysqli_query($conn, $sql);

        // Show action
        while ($row = mysqli_fetch_row($result)) {
            echo "<tr><th>".$row[0]."</th><th>".$row[1]."</th><th>".$row[2]."</th></tr>";
        }
        ?>
    </table>

<?php
include "closeDB.php";
?>