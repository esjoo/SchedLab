<!-- The Modal -->
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModallabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content modal-lowered">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <p class="modaltimes align-self-top my-2">A</p>
          <button type="button" class="btn btn-link" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body modal-body-50">
            <div id="#description"></div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <a href="#" class="btn btn-green-transform">View Protocol</a>
        <span id="remove_exp" class="btn btn-danger" href="remove_exp.php?" onmouseout="this.textContent='Remove'" onmouseover="this.textContent='Confirm'" >Remove</a>
        </div>
    </div>
</div>
   
<script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var protocolContent = button.attr('data-protocolContent'); // Extract info from data-* attributes
  var protocolHead = button.attr('data-protocolHead');
  var protocolStartTime = button.attr('data-startTime');
  var protocolEndTime = button.attr('data-endTime');
  var calenID = button.attr('data-calenID');
  var week = <?php echo(isset($_GET['w']) ?$_GET['w'] : date_format($today,'W'));?>
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  console.log(protocolContent);
  modal.find('.modal-title').text(protocolHead)
  modal.find('.modal-body').text(protocolContent)
  modal.find('.modaltimes').text(protocolStartTime+'-'+protocolEndTime)
  modal.find('#remove_exp').attr("href","remove_exp.php?w="+week+"&cali="+calenID+"&p="+protocolHead)
});

</script>
