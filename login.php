

<!-- The Modal -->
<div class="modal fade" id="login">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Welcome</h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form action="includes/login.inc.php" method='post'>
                <div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="name" class="form-control" placeholder="Enter name" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" placeholder="Enter password" id="pwd" name="pwd">
                </div>
                <div class="form-group form-check">
                    <label class="form-check-label">
                    <input class="form-check-input" type="checkbox"> Remember me </label>
                </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </div>
            </form>