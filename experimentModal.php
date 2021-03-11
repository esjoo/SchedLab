<!-- The Modal -->
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModallabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <div id="#description"></div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <a href="#" class="btn btn-green-transform">View Protocol</a>
        <a id="remove_exp" class="btn btn-danger" href="remove_exp.php?" onclick="return confirm('Are you sure you want to remove this experiment?');" >Remove experiment</a>
        </div>
    </div>
</div>
   
<script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var protocolContent = button.attr('data-protocolContent'); // Extract info from data-* attributes
  var protocolHead = button.attr('data-protocolHead');
  var calenID = button.attr('data-calenID');
  var week = <?php echo(isset($_GET['w']) ?$_GET['w'] : date_format($today,'W'));?>
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text(protocolHead)
  modal.find('.modal-body').text(protocolContent)
  modal.find('#remove_exp').attr("href","remove_exp.php?w="+week+"&cali="+calenID+"&p="+protocolHead)
});

</script>
