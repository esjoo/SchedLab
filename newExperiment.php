<!-- The Modal -->
<link rel="stylesheet" href="style/autocomplete.css">
<div class="modal fade" id="newExperiment" >
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
                    <div class="form-group" ng-app="searchModule">
                        <label for="protocol">Protocol:</label>
                        <div ng-controller="searchController">
                            <input type="search" class="form-control" placeholder="Search" ng-model="query" ng-focus="focus=true" name="protocolName"
                            min="08:00:00" max="18:00:00" required>
                            <div id="search-results" ng-show="focus">
                                <div class="search-result" ng-repeat="item in data | search:query" ng-bind="item" ng-click="setQuery(item)"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" ng-controller="dateCtrl">
                        <label for="labtimeStart">Start:</label>
                        <input type="datetime-local"  class="form-control" id="labtimeStart" name="labtimeStart">
                    </div>
                    <div class="form-group">
                        <label for="labtimeEnd">End:</label>
                        <input type="datetime-local" class="form-control" id="labtimeEnd" name="labtimeEnd">
                    </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>

<!--DIRTY -->
<script>
    var data = <?php echo json_encode(get_protocols()); ?>;
</script>
<script src="scripts/autocomplete.js"></script>
</div>