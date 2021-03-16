<div id="inputToast" class="toast " role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
  <div class="toast-header">
    <img src="..." class="rounded mr-2" alt="...">
    <strong class="mr-auto">Inventory</strong>
    <small class="text-muted"></small>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
  <?php if(isset($_SESSION["error"])){
                        $error = $_SESSION["error"];
                        echo "<p>$error</p>";
                        unset($_SESSION["error"]);
                    }; ?>
  </div>
</div>