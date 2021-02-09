<?php 
if(isset($_POST['submit'])) {
    
    require_once('db.php');

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $procedure = mysqli_real_escape_string($conn, $_POST['procedure']);
    $equipment = mysqli_real_escape_string($conn, $_POST['equipment']);
    $i = 1;
    $chemicals = array();
    while(mysqli_real_escape_string($conn, $_POST['chemical' . $i]) != NULL) {
        array_push($chemicals, mysqli_real_escape_string($conn, $_POST['chemical' . $i]));
        $i++;
    }
    //$chemical = mysqli_real_escape_string($conn, $_POST['chemical1']);
    $str_chemicals = implode($chemicals);
    print( $str_chemicals );
    
    $val = "\"".$name."\""   .','  . "\"".$procedure. "\"" .','. "\"".$equipment."\"".','."\"".$str_chemicals."\""; 
   
    $sql = "INSERT INTO protocol (ProtName, Method, AllEquipment, AllReagent) VALUES (".$val.");";
   
    if (mysqli_query($conn, $sql)) {
        $sql = "SELECT ProtID FROM protocol WHERE (ProtName='$name', Method='$procedure');";
        $prot_id = mysqli_query($conn, $sql);
        echo "New record created successfully";

        // $chemicals = explode(",", $chemicals, 1000);
        for ($x = 1; $x <= count($chemicals); $x++){
            if (!mysqli_query($conn, "SELECT SupID FROM supplement WHERE SupName=$chemicals[$x];")){
                if (mysqli_quary($conn, "INSERT INTO supplement (SupName) VALUES ('$chemicals[$x]');")) {
                    echo "New supplement added successfully";
                } else {
                    echo "Error: " . $sql . "" . mysqli_error($conn);
                }
            }
            $sql = "SELECT id FROM supplement WHERE SupName=$chemical";
            $sup_id = mysqli_query($conn, $sql);
            
            $sql = "INSERT INTO include (ProtocolNum, SupID) VALUES ($prot_id, $sup_id);";
            if (mysqli_query($conn, $sql)) {
                echo "New reagent added successfully";
            }
        }
        /*$i = 1;
        while (isset($chemical)) {
            $sql = "SELECT id FROM supplement WHERE SupName=$chemical";
            if (!mysqli_query($conn, $sql)) {
                $sql1 = "INSERT INTO supplement (SupName) VALUES ('$chemical');";
                mysqli_query($conn, $sql1);
            }
            $sup_id = mysqli_query($conn, $sql);
            
            $sql = "INSERT INTO include (ProtocolNum, SupID) VALUES ($prot_id, $sup_id);";
            $i++;
            $chem_tag = "chemical".$i;
            $chemical = mysqli_real_escape_string($conn, $_POST[$chem_tag]);
        }
        */
        //header('Location: index.php');
        //exit();
     } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
     }  
    } 
?>
