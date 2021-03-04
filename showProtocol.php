<!DOCTYPE html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <style>
        div {
            margin-top:25px;
	        margin-bottom:25px;
	        margin-right:50px;
	        margin-left:50px;
            color:black;
        }
        div.part {
            border-radius: 5px;
            background-color: #f5e0e0;
            padding: 20px;
        }
        h2.margin {
            margin-top:25px;
	        margin-bottom:25px;
	        margin-right:50px;
	        margin-left:50px;
            color:black;
        }
        table, td, th 
        {
            margin:25px;
            padding:0px 20px;
            width:50%;
        }
        td, th {
            border:2px solid #e2a6a6;
            background-color: #FBF3F3;
            width:50%;
        }
        h5 {
            margin-top:1px;
	        margin-bottom:1px;
        }
        .button {
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
    </style>
</head>

<body style="background-color:#FBF3F3;">
    <?php 
        include 'header.php';
        include "db.php";

        $protName = $_POST['protName'];
        $procedure = $_POST['procedure'];
        $equipment = $_POST['equipment'];
        $chemicals = $_POST['chemicals'];
        $dosages = $_POST['dosages'];
        $ProtCreater = $_POST['ProtCreater'];
 
        include "closeDB.php";
    ?>

    <h2 class="margin">Protocol Name</h2>
        <div class="part">
        <?php
            echo "<div>{$protName}</div>";
        ?>
        </div>

    <h2 class="margin">Procedure</h2> 
        <div class="part">
        <?php
            $procedure = nl2br($procedure, true);

            echo "<div>{$procedure}</div>";
        ?>
        </div>

    <h2 class="margin">Equipment</h2>
        <div class="part">
        <?php
            $equipment = nl2br($equipment, true);
 
            echo "<div>{$equipment}</div>";
        ?>
        </div>

    <h2 class="margin">Chemical</h2>
        <div class="part" style="text-align: center;">
            <?php
                echo '<table width="50%">';
                echo '<tr>
                        <th>Chemical</th>
                        <th>Dosage</th>
                    </tr>';
                
                $cheLen = count($chemicals);
                for($i=0;$i<$cheLen;$i++){
                    $c = $chemicals[$i];
                    $d = $dosages[$i];
                    echo "<tr>
                            <td>{$c}</td>
                            <td>{$d}</td>
                        </tr>";
                };

                echo "</table>";

            ?>
        </div>
    
        <div class="form-inline" style="text-align: center">
            <form action="insert.inc.php" method='post' onsubmit="return checkName()">
                
                <?php
                    // check if there is a same protocol name in the db.
                    include 'db.php';
                    $result = mysqli_query($conn,"SELECT ProtName FROM Protocols WHERE ProtName = '$protName'");
                    $num1 = mysqli_num_rows($result);
                    if($num1 == '0'){
                        echo '<input type="hidden" id="test1" name="test1" value="0">';
                    }else{
                        echo '<input type="hidden" id="test1" name="test1" value="1">';
                    }
                    include 'closeDB.php';

                ?>

                <input type="hidden" name="protName" value="<?php echo $protName?>">
                <input type="hidden" name="ProtCreater" value="<?php echo $ProtCreater?>">
                <input type="hidden" name="procedure" value="<?php echo strip_tags($procedure, true)?>">
                <input type="hidden" name="equipment" value="<?php echo strip_tags($equipment, true)?>">

                <?php
                    $len = count($chemicals);
                    for($i=0;$i<$len;$i++){
                        echo '<input type="hidden" name="chemicals[]" value="' . $chemicals[$i] . '">';
                        echo '<input type="hidden" name="dosages[]" value="' . $dosages[$i] . '">';
                    }
                ?>

                <div>
                    <button name="submit1" type="submit" class="button" style="width: 200px"><span>Submit</span></button>
                </div>
            </form>

            <form action="editProtocol.php" method='post'>
                <input type="hidden" name="protName" value="<?php echo $protName?>">
                <input type="hidden" name="procedure" value="<?php echo $procedure?>">
                <input type="hidden" name="equipment" value="<?php echo $equipment?>">
                
                <?php
                    $len = count($chemicals);
                    for($i=0;$i<$len;$i++){
                        echo '<input type="hidden" name="chemicals[]" value="' . $chemicals[$i] . '">';
                        echo '<input type="hidden" name="dosages[]" value="' . $dosages[$i] . '">';
                    }
                ?>

                <div>

                    <?php
                        $userName = $_SESSION['userName'];
                        echo '<input type="hidden" name="ProtCreater" value="' . $userName . '">';
                        if ($userName == $ProtCreater){
                            echo '<button name="submit2" type="submit" class="button" style="width: 200px"><span>Edit</span></button>';
                        }else{
                            echo '<button name="submit2" type="submit" class="button" style="width: 200px"><span>Copy</span></button>';
                        }
                    ?>
                    
                </div>
            </form>
        </div>


<!-- send form to insert.inc.php -->
<script language="javascript">
function checkName(){
    var protTest1 = $('#test1').val()
    if(protTest1 == 1){
        alert('Protocol name already exists, please change!')
        return false;
    }else{
        return true;
    }
}
</script>

</html>

