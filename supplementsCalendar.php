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
        <?php
          foreach($listSupplements as $t) {
            printf('<tr>
                      <td>%s</td>
                      <td>%s</td>
                    </tr>',$t['SupName'],$t['total']);
          } 
        ?>

    </tbody>
  </table>
</div>