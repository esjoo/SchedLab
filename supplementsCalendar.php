<?php
//fetch SupplementList
if(isset($_GET['w'])) {
    $listSupplements = getWeekSupplements($_GET['w']);
} else {
    $listSupplements = getWeekSupplements(date_format(date_create(),'W')); 
}
?>
<div class="collapse" id="supplementTable">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Supplements</th>
        <th scope="col">ml</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php
          foreach($listSupplements as $t) {
            printf('<td>%s</td>
                    <td>%s</td>',$t['SupName'],$t['total']);
          } 
        ?>
      </tr>
    </tbody>
  </table>
</div>