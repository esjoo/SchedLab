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
                    
                
					
					
                        
                        <div ng-controller="searchController">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text pr-4"  for="protocolSearch" id="protocolSearchlabel">Protocol</label>
                                </div>
                                <!-- Search -->
                                <input type="text" class="form-control" placeholder="Search" ng-model="query" minlength="1" ng-focus="focus=true" id="protocolName" onchange="validateProtocol()" oninput="validateProtocol()" name="protocolName">
                                
            
                            </div>
                            <div id="search-results" ng-show="focus">
                                <div class="search-result" ng-repeat="item in data | search:query" ng-bind="item" ng-click="setQuery(item)" required></div>
                            </div>
                        </div>
                   
                

                
                <div class="form-group" ng-controller="dateCtrl">
                    <label for="labtimeStart">Start:</label>
                    <input type="date" class="form-control" id="labdate" onclick="earliestDate()" name="labdate" required>
                </div>

                    <div class="form-group" ng-controller="dateCtrl">
                        <label for="labtimeStart">Start:</label>
                        <input type="time" class="form-control" value="08:00" id="labtimeStart"  min="08:00" max="17:00" name="labtimeStart" oninput="setTimeProtocol()" required>
                    </div>
                    <div class="form-group">
                        <label for="labtimeEnd">End:</label>
                        <input type="time" class="form-control" id="labtimeEnd" max="17:00" name="labtimeEnd" required>
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

<script>var data =<?php echo(json_encode(get_protocols()));?></script>
<script src="scripts/inputValidationExperiment.js"></script>
<script src="scripts/autocomplete.js"></script>
</div>