<link rel="stylesheet" href="style/main.css">
<?php
include "header.php";
include "db.php";
?>

<h1>Log</h1>
<div class="part">
    <table>
        <tr><th><h6>Time</h6></th><th><h6>User</h6></th><th><h6>Action</h6></th></tr>
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