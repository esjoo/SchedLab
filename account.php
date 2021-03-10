<?php
echo '<link rel="stylesheet" href="style/protocol.css">';
include "header.php";
include "db.php";
include_once "includes/functions.php";

$labID = get_current_user_lab();
$sql = "SELECT LabName FROM lab WHERE LabID=$labID";
$result = $conn->query($sql);
$labName= $result -> fetch_array();
if(empty($labName)){
    $labName ="unassigned";
}


$userID = get_current_user_id();
$sql = "SELECT * from users WHERE UserID=$userID";
$result = $conn->query($sql);
$row = $result -> fetch_assoc();
?>

<!--wrapper -->
<div class="box pl-3 pt-1 ">
    <!--left col -->
    <div class="box-col" id= "accountLeftcol">
        <div id="userImage">
        
        </div>

        <div class="box-child">
            <h1> <?php echo($row['UserFirstName'].' '.$row['UserLastName']);?> <h1>
            <h2> LAB: <?php echo($labName); ?> </h2>
        </div>

        
        <div class="box-child">
            <p>In medicine, modern biotechnology has many applications in areas such as pharmaceutical drug discoveries and production, pharmacogenomics, and genetic testing (or genetic screening).</p>

            <p>Examples in food crops include resistance to certain pests.</p>
        </div>
            
        
    </div>





    <!--Right col -->
    <div class="box-col w-100 ">

        <!--History -->
        <div class="box-child" id="accountHistory">
            <h2>Actions</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>John</td>
                    <td>Doe</td>
                    <td>john@example.com</td>
                </tr>
                <tr>
                    <td>Mary</td>
                    <td>Moe</td>
                    <td>mary@example.com</td>
                </tr>
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                </tr>
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                </tr>
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                </tr>
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                </tr>
                </tbody>
            </table>
        </div>

        <!--change INFO -->
        <div class="box-col">
            <div class="box-row">
                <h2>Change info </h2>
            </div>
            <div class="w-100"></div>
            <div class="box-row">
                

                <form method='POST'>
                        
                    <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="first_name">Firstname</label>
                          <input type="text" class="form-control" id="first_name" value="<?php echo($row['UserFirstName']);?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="last_name">Lastname</label>
                            <input type="text" class="form-control" id="last_name" value="<?php echo($row['UserLastName']);?>">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="email">email</label>
                            <input type="email" class="form-control" id="email" value="<?php echo( $row['UserEmail']);?>">
                        </div>
                        <button class='button submit' type='submit' name='submit'><span>Submit changes</span></button>
                    </div>
                </form>
                <div>
                    <input type="checkbox" onclick="toggleDarkmode()" id="darktoggle">
                </div>
            </div>

            <?php
            if(isset($_POST['submit'])){
                $firstName=$_POST['first_name']; 
                $firstName=mysqli_real_escape_string($firstName);
                $lastName=$_POST['last_name']; 
                $lastName=mysqli_real_escape_string($lastName);
                $email=$_POST['email']; 
                $email=mysqli_real_escape_string($email);
                $sql = "UPDATE users SET UserFirstName='$firstName', UserLastName='$lastName', UserEmail='$email' WHERE UserID=$userID";
                $result = mysqli_query($conn, $sql);
                echo "<script type='text/javascript'>
                    window.location=document.location.href;
                    </script>";
            }
            ?>
        <div class="box-child ">
            <form method='POST'>
                <div class="form-row">
                    <div class="form group">
                        <label name='password'>New password:</label>
                        <input class="form-control" placeholder='Password...' name='password' type='password' >
                    </div>
                    <div class="form group">
                        <lable name='confirm_password'>Confirm password:</lable>
                        <input class="form-control"     type='password' placeholder='Confirm Password' name='confirm_password' required>
                    </div>
                <div>
                    <button class='button submit' type='submit' name='new_password'><span>Change password</span></button><br>
                </div>
                <?php
                if(isset($_POST['new_password'])){
                    if ($_POST['password']==$_POST['confirm_password']){
                        $password = password_hash(mysqli_real_escape_string($conn,$_POST['password']),PASSWORD_DEFAULT);
                        $sql = "UPDATE users SET UserPassword='$password' WHERE UserID=$userID";
                        $result = mysqli_query($conn, $sql);
                    } else {
                        echo "<p>Passwords not matching</p>";
                    }
                }
                ?>
            </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) { 
    var scrollpos = localStorage.getItem("scrollpos");
    if (scrollpos) window.scrollTo(0, scrollpos);
});

window.onbeforeunload = function(e) {
    localStorage.setItem("scrollpos", window.scrollY);
};

</script>';
<?php
include "closeDB.php";
?>
