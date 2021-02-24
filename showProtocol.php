<!DOCTYPE html>

<head>

</head>

<body>
    <?php 
        include 'header.php';
        include "db.php";

        $name = $_POST['name'];
        $procedure = $_POST['procedure'];
        $equipment = $_POST['equipment'];
        $chemicals = $_POST['chemicals'];
        $dosages = $_POST['dosages'];
 
        include "closeDB.php";
    ?>

    <h1>Protocol Name</h1>
        <?php
            echo "<div>{$name}</div>";
        ?>

    <h1>Procedure</h1> 
        <?php
            $procedure = nl2br($procedure, true);
            echo "<div>{$procedure}</div>";
        ?>
    <h1>Equipment</h1>
        <?php
            $equipment = nl2br($equipment, true);
            echo "<div>{$equipment}</div>";
        ?>

    <h1>Chemical</h1>
        <?php
            echo '<table>';
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
    
    <form action="insert.inc.php" method='post'>

    </form>