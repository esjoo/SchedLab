<?php
include_once("header.php");
?>
<link rel="stylesheet" href="style/protocol.css">
<div class="container">
    <div class="color overflow-auto mt-3 h-25">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Amount</th>
                <th scope="col">State</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    printLabInventory($_SESSION['lab']);
                ?>
            </tbody>
        </table>
    </div>


<h2 id="demofont3" class="text-center">Add or remove chemicals</h2>
<!--To add chemicals-->
    <div class="color">
        <div class='add_chemicals'>
        <form action="add_to_inventory.php" method="POST"> 
            <div class="search-box">
                <label name="chemical_name mx-0">Chemical:</label>
                <input type="text" name="chemical_name" required autocomplete="off" />
                <div class="result"></div>
            </div>
            <label name="amount">Amount (ml):</label>
            <input type="number" min="-2000" max="2000" value="0" list="inventorySuggestions" name="amount">
            <datalist id="inventorySuggestions">
                <option value="-2000">
                <option value="-1000">
                <option value="500">
                <option value="1000">
                <option value="1500">
            </datalist>

            <label name="price">Price($):</label>
            <input id="supPrice" type="number" min="0"  placeholder="current price"  name="price">
                       
            <button name="submit" type="submit" class="button"><span>Enter</span></button>
            <?php if(isset($_SESSION["error"])){
                        $error = $_SESSION["error"];
                        echo "<p>$error</p>";
                        unset($_SESSION["error"]);
                    }; ?>
         
        </form>
        </div>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("livesearchFORinventory.php", {term: inputVal}).done(function(data){
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
        
        document.getElementById("supPrice").value = $(this).attr("data-supPrice");     


        $(this).parent(".result").empty();
    });

});
</script>

