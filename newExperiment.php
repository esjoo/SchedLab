<!-- The Modal -->
<link rel="stylesheet" href="style/autocomplete.css">

<div class="modal fade" id="newExperiment">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Plan new experiment</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                
                <form autocomplete="off" action="includes/newExperiment.inc.php<?php echo(isset($_GET['w']) ? '?w='.$_GET['w'] : '');?>" method="post" name="experimentForm">
                    
                
					
					
                        
                        <div >
                            <div class="input-group mb-3 ">
                                <div class="input-group-prepend">
                                    <label class="input-group-text pr-4"  for="protocolSearch" id="protocolSearchlabel">Protocol</label>
                                </div>
                                <!-- Search -->
                                <div class="search-box w-75">
                                    <input type="text" class="form-control" placeholder="Search"  minlength="1" id="protocolName" onchange="validateProtocol()" oninput="validateProtocol()" name="protocolName" autocomplete="off" required>
                                    <div class="result overflow-auto h-75   "></div>    
                                </div>
                                
                            </div>
                        </div>
                   
                

                
                <div class="form-group">
                    <label for="labtimeStart">Date:</label>
                    <input type="date" class="form-control" id="labdate" onclick="earliestDate()" name="labdate" required>
                </div>

                    <div class="form-group">
                        <label for="labtimeStart">Start:</label>
                        <input type="time" class="form-control" value="08:00" id="labtimeStart"  min="08:00" max="17:00" name="labtimeStart" oninput="setTimeProtocol()" required>
                    </div>
                    <div class="form-group">
                        <label for="labtimeEnd">End:</label>
                        <input type="time" class="form-control" id="labtimeEnd" min="8:00" max="17:00" name="labtimeEnd" required>
                    </div>

                    <span id="newExpFeedback"></span>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <button name="submit" type="submit" class="btn btn-primary btn-green-transform">Submit</button>
            </div>
            </form>
        </div>
    </div>

<!--DIRTY -->


<script src="scripts/inputValidationExperiment.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("livesearchFORnewExperiment.php", {term: inputVal}).done(function(data){
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
</div>