

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
                <form autocomplete="off" action="" method="post">
                    <div class="form-group">
                        <div class="autocomplete" style="width:300px;">
                            <input type="text" id="fname" name="fname" onkeyup="showHint(this.value)">
                            <p>Suggestions: <span id="txtHint"></span></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="labtimeStart">Start:</label>
                        <input type="datetime-local" id="labtimeStart" name="labtimeStart">
                    </div>
                    <div class="form-group">
                        <label for="labtimeEnd">End:</label>
                        <input type="datetime-local" id="labtimeEnd" name="labtimeEnd">
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
    <!--DIRTY -->
    <script src="scripts/autocomplete.js"></script>