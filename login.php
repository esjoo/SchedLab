

<!-- The Modal -->
<div class="modal fade" id="login" ng-app="">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Welcome</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form action="includes/login.inc.php" method='post' name="loginForm">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text pr-4" id="usernamelabel">Name</span>
					</div>
					<input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="usernamelabel" name="userName" ng-model="userName" required>
				  </div>
				  <span ng-show="loginForm.userName.$touched && loginForm.userName.$invalid">Username is required.</span>
			
				  <div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="passwordlabel">Password</span>
					</div>
					<input type="password" class="form-control" placeholder="Enter password" aria-label="Username" aria-describedby="passwordlabel"  id="pwd" name="pwd"
          title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
				  </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button name="submit" type="submit" class="btn btn-green-transform">Submit</button>
        </div>
            </form>

            <script>
                $(document).ready( function () {
                    showLogin();
            });
            </script>
            