<link rel="stylesheet" href="style/protocol.css">

    <?php 
        include "db.php";
        include_once "includes/functions.php";
        
        // Get labname
        $lab_ID = get_current_user_lab();
        $sql = "SELECT LabName FROM lab WHERE LabID=$lab_ID";
        $result = mysqli_query($conn, $sql);
        if ($r = mysqli_fetch_row($result)){
            $labName = $r[0];
        }

        // Manage user-move requests
        $sql_req = "SELECT users.UserID, users.UserName, users.UserFirstName, users.UserLastName, lab.LabName FROM users LEFT JOIN lab ON request=LabID WHERE (request IS NOT NULL AND lab=$lab_ID)";
        $requested_moves = mysqli_query($conn, $sql_req);

        // Users in the lab
        $sql1 = "SELECT lab.*, users.UserID, users.UserName, users.UserFirstName, users.UserLastName FROM lab LEFT JOIN users ON LabID=lab WHERE lab.LabID=$lab_ID";
        $result1 = mysqli_query($conn, $sql1);
 
        include "closeDB.php";
        include "header.php";
    ?>


<h1 id="demofont3">Manage users</h1>
<h2 id="demofont3" style="text-align:center"><?php echo $labName; ?></h2>

<!-- User requests --> 
<?php
if (mysqli_num_rows($requested_moves)>0){
    echo '<div class="color">
        <h2 id=demofont1>User move requests</h2>
        <form action="includes/manageUsers.request.php" method="POST">
        <table style="width:60%">
        <thead>
        <tr>
            <th></th>
            <th><h6 style="text-align: center;">Username</h6></th> 
            <th><h6 style="text-align: center;">First Name</h6></th>
            <th><h6 style="text-align: center;">Last Name</h6></th>
            <th><h6 style="text-align: center;">Move to lab</h6></th>
        </tr>       
        <tbody>';
    while ($moves = mysqli_fetch_row($requested_moves)){    
        echo '<tr><th><input type="radio" name="request_user" value='.$moves[1].'></th>';                 
        echo '<th>'.$moves[1].'</th>'; //UserName
        echo '<th>'.$moves[2].'</th>'; //FirstName
        echo '<th>'.$moves[3].'</th>'; //LastName
        echo '<th>'.$moves[4].'</th></tr>'; //Lab
    }
    
    echo '</tbody>
    </thead>
    </table>

    <div>
        <button class="submit" name="request" value="approve"><span>Approve</span></button>
        <button class="submit" name="request" value="reject"><span>Reject</span></button>
    </div>
</form>
</div>';
}
?>

<!--Add new users to the labb-->
<div class="color">
    <h3 id="demofont4">Add new users to the lab</h3>
    <div class="search-box">
    <form action="includes/manageUsers.inc.php" method="POST">
        <input style="height:40px" type="text" autocomplete="off" placeholder="Search Username" id="user_name" name="user" />
        <div class="result"></div>
        <button class="submit button"><span>Submit</span></button>
    </form>
    </div>
    
    <!-- Users beloning to a lab in the database --> 
    <div>
        <h3 id="demofont4">Users in the lab</h3>
        <form action="includes/manageUsers.inc.php" method="POST">
        <table style="width:600px;margin:auto">
        <thead>
        <tr>
            <th></th>
            <th><h6>Username</h6></th> 
            <th><h6>First Name</h6></th>
            <th><h6>Last Name</h6></th>
        </tr>       
        <tbody>
            <?php
            $i = 0;
            while ($row = mysqli_fetch_row($result1)){    
                if ($lab_ID==$row[0]){
                    echo '<tr><th><input type="radio" name="record" value='.$row[4].'></th>';                 
                    echo '<th>'.$row[4].'</th>'; //UserName
                    echo '<th>'.$row[5].'</th>'; //FirstName
                    echo '<th>'.$row[6].'</th></tr>'; //LastName
                    }
                    $i++;
                }
                ?>
        
        </tbody>
        </thead>
        </table>
    </div>
        <button class="submit button" name="removed_user"><span>Remove</span></button>   
    </form>
    </div>
            
</div>
</form>    
</div>
<h2 style='opacity:0'> Name </h2>
</body>


               
<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("livesearchFORmanageUsers.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });

});
</script>
