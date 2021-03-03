<style>
div {
    margin-bottom:25px;
    margin-right:25px;
    margin-left:25px;
}

div.part {
    border-radius: 5px;
    background-color: #f5e0e0;
    padding: 20px;
}

a:hover {
    cursor: pointer;
    background-color: yellow;
}

table, input {
    margin-top:15px;
    margin-bottom:15px;
    text-align:left;
}

table, td, th {
    margin:25px;
    padding:4px 20px;
    border:2px solid #e2a6a6;
    background-color: #FBF3F3;
}

input[type=text] {
    border: 2px solid #e2a6a6;
}

input[type=number] {
    border: 2px solid #e2a6a6;
}

textarea{
    border: 2px solid #e2a6a6;
}

select{
    border: 2px solid #e2a6a6;
}

h1.margin, h2.margin {
    margin-top:25px;
    margin-bottom:25px;
    margin-right:50px;
    margin-left:50px;
    color:black;
}

h5.margin {
    margin-top:1px;
    margin-bottom:1px;
    color:black;
}

h6.font {
    margin:0px;
    color:black;
}

.button, .submit {
    background-color:#79ab79;
    border: none;
    color:white;
    font-size: 20px;
    text-align: center;
    border-radius: 12px;
    height: 40px;
    transition: all 0.5s;
    cursor: pointer;
}

.button span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
}

.button span:after {
    content: '\00bb';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.5s;
}

.button:hover span {
    padding-right: 25px;
}

.button:hover span:after {
    opacity: 1;
    right: 0;
}

p{
    color:black;
}

.dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
}

.dropdown {
    position: relative;
    display: inline-block; 
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>    

    <?php 
        include "db.php";
        include_once "includes/functions.php";
        $lab_ID = get_current_user_lab();
        $sql = "SELECT LabName FROM lab WHERE LabID=$lab_ID";
        $result = mysqli_query($conn, $sql);
        if ($r = mysqli_fetch_row($result)){
            $labName = $r[0];
        }

        $sql1 = "SELECT lab.*, users.UserID, users.UserName, users.UserFirstName, users.UserLastName FROM lab LEFT JOIN users ON LabID=lab WHERE lab.LabID=$lab_ID";
        $result1 = mysqli_query($conn, $sql1);
 
        include "closeDB.php";
        include "header.php";
    ?>

<!-- Users beloning to a lab in the database --> 
<h1 class="margin">Manage users</h1>
<h2 class="margin"><?php echo $labName; ?></h2>
<div class="part">
    
    <div class="search-box">
    <form action="includes/manageUsers.inc.php" method="POST">
        <input style="height:40px" type="text" autocomplete="off" placeholder="Search Username" id="user_name" name="user" />
        <div class="result"></div>
        <button class="submit"><span>Submit</span></button>
    </form>
    </div>

    <form action="includes/manageUsers.inc.php" method="POST">
    <table style="width:60%">
    <thead>
    <tr>
        <th></th>
        <th><h6 class="font" style="text-align: center;">Username</h6></th> 
        <th><h6 class="font" style="text-align: center;">First Name</h6></th>
        <th><h6 class="font" style="text-align: center;">Last Name</h6></th>
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

    <div>
        <button class="submit"><span>Remove</span></button>
        </div>    
    </form>
    </div>

            
</div>
</form>    
</div>
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

<script>
    $(document).ready(function(){
        $(".add-row").click(function(){
            var input = $("#user_name").val();
            var array_input = input.split(",");
            var markup = '<tr> '+
                         '<th><input type="checkbox" name="record"></th>' +
                         '<th>'+array_input[0]+'</th>'+
                         '<th>'+array_input[1]+'</th>'+
                         '<th>'+array_input[2]+'</th></tr>';
            $("table tbody").prepend(markup);        
        }        
        );     
    });

        // Find and remove selected table rows
        $(".delete-row").click(function(){
            $("table tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                    return TRUE;
                }
            });
        });
    });    
</script>

<script>
(function(){
    var f1 = document.getElementById('name'),     
        b1 = document.getElementById('add'),
		t = document.getElementById('To_che');
    b1.onclick = function() {
        t.value = f1.value;        
    };
})();


</script>