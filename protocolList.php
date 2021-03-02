
<head>
    <style>
        div.part {
            border-radius: 5px;
            margin:50px;
            background-color: #f5e0e0;
            padding: 20px;
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


<body>

    <?php
        include 'header.php';
    ?>
    <div class="part">
        <form action='showProtocol.php' method = 'post'>      
            <?php
                include 'db.php';
                if (isset($_POST['submit1'])){
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
            <h6 style="color:#343A40">Please enter the name of the protocol you want to query in the search box below.</h6>
            <button type="submit" class="button"><span>Show</span></button>
        </form>


        <form action="" method='post'>

            <!--<div class="search-box">
                <input style="height:40px" type="text" autocomplete="off" placeholder="Search Protocols" name="From_prot" />
                <div class="result"></div>
            </div>-->

            <link rel="stylesheet" href="bootstrap-select.min.css">
            <script src="bootstrap-select.min.js"></script>
            <select class="selectpicker" data-live-search="true" name="From_prot">
                <?php
                    include 'db.php';
                    $result = mysqli_query($conn,"SELECT * FROM Protocols");

                    while($row = $result->fetch_assoc()) {
                        $ProtocolName = $row['ProtName'];
                        echo '<option value="' . $ProtocolName . '">' . $ProtocolName . '</option>';
                    }    
                    include 'closeDB.php';
                ?>
            </select>
            

            <button type="submit" class="button" name="submit1"><span>Confirm</span></button>

        </form>
    </div>

</body>


<!-- Live search -->
<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("livesearchFORprotList.php", {term: inputVal}).done(function(data){
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


