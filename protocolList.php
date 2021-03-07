
<head>
    <link rel="stylesheet" type="text/css" href="protocolList.css">
</head>


<body>
    <?php
        include 'header.php';
    ?>

    <?php
        $value = "Choose a protocol";
		if($_REQUEST) 
		{
			$value=$_REQUEST["From_prot"];
		}
	?>

    <div class="list">
        <div class="part">
            <h6 class="list">Please enter the name of the protocol you want to view in the search box below.</h6>

            <form action="" method='post' id="myPname">
                <link rel="stylesheet" href="bootstrap-select.min.css">
                <script src="bootstrap-select.min.js"></script>
                <select class="selectpicker" data-live-search="true" name="From_prot" onchange="submitform()">
                    <?php
                        include 'db.php';
                        $result = mysqli_query($conn,"SELECT * FROM Protocols");

                        while($row = $result->fetch_assoc()) {
                            $ProtocolName = $row['ProtName']; 
                        ?>

                        <option value="<?php echo $ProtocolName; ?>"<?php echo $value=="$ProtocolName"?"selected='$ProtocolName'":""?>><?php echo $ProtocolName; ?></option>
                        
                        <?php
                        }  
                        include 'closeDB.php';
                    ?>
                </select>
                <!--<button class="button1" type="submit" onClick="javascript:fsubmit(document.form1);"><span>Show</span></button>-->
                
            </form>
            
            <form id="form1" name="form1" action='showProtocol.php' method = 'post'>      
                <?php
                    include 'db.php';
                    if (isset($_POST['From_prot'])){
                        $protName = $_POST['From_prot'];

                        $result = mysqli_query($conn,"SELECT * FROM Protocols where ProtName = '$protName'");
                        while($row = $result->fetch_assoc()) {
                            $ProtID = $row['ProtID'];
                            $ProtName = $row['ProtName'];
                            $procedure = $row['ProtMethod'];
                            $equipment = $row['EquipmentID'];
                            $protCreater = $row['Creater'];
                        }

                        echo '<input type="hidden" name="protName" value="' . $ProtName . '">';
                        echo '<input type="hidden" name="procedure" value="' . $procedure . '">';
                        echo '<input type="hidden" name="equipment" value="' . $equipment . '">';
                        echo '<input type="hidden" name="ProtCreater" value="' . $protCreater . '">';

                        $result = mysqli_query($conn,"SELECT * FROM ProtocolGuide where ProtID = '$ProtID'");

                        while($row = $result->fetch_assoc()) {
                            $dosage = $row['Dosage'];
                            $SupID = $row['SupID'];
                            
                            $result1 = mysqli_query($conn,"SELECT * FROM Supplement where SupID = '$SupID'");
                            while($row1 = $result1->fetch_assoc()) {
                                $chemical = $row1['SupName'];
                                echo '<input type="hidden" name="chemicals[]" value="' . $chemical . '">';
                                echo '<input type="hidden" name="dosages[]" value="' . $dosage . '">';
                            }
                        }
                    
                    }
                    

                    include 'closeDB.php';
                ?> 
                <button class="button1" type="submit" onClick="javascript:fsubmit(document.form1);"><span>Show</span></button>
            </form>
        </div>
    </div>
</body>


<!-- submit the protocol name to this page -->
<script type="text/javascript">  
function submitform(){  
    var form = document.getElementById("myPname");
    form.submit(); 
} 
</script> 

<script type="text/javascript">
  document.getElementById('myPname').value = "<?php echo $_POST['From_prot'];?>";
</script>

<script language="javascript">
    function fsubmit(obj){
    obj.submit();
    }
</script>