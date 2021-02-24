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
    </style>
</head>

<body style="background-color:#FBF3F3;">
    <?php 
        include 'header.php';
        include "db.php";
        //$name = mysqli_real_escape_string($conn, $_POST['name']);
        //$procedure = mysqli_real_escape_string($conn, $_POST['procedure']);
        //$equipment = mysqli_real_escape_string($conn, $_POST['equipment']);
        $name = $_POST['name'];
        $procedure = $_POST['procedure'];
        $equipment = $_POST['equipment'];
        $chemicals = $_POST['chemicals'];
        $dosages = $_POST['dosages'];
        $NEWchemicals = $_POST['NEWchemicals'];
        $NEWdosages = $_POST['NEWdosages'];  
        include "closeDB.php";
    ?>

    <h2 class="margin">Protocol Name</h2>
        <div class="part">
        <?php
            echo "<div>{$name}</div>";
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

                $cheLen1 = count($NEWchemicals);
                for($i=0;$i<$cheLen1;$i++){
                    $c = $NEWchemicals[$i];
                    $d = $NEWdosages[$i];
                    echo "<tr>
                            <td>{$c}</td>
                            <td>{$d}</td>
                        </tr>";
                };

                echo "</table>";

            ?>
        </div>
    
    <form action="insert.inc.php" method='post'>

    </form>