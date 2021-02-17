<!-- Chemicals -->

<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="bootstrap-select.min.css">
<script src="jquery.min.js"></script>

<script src="bootstrap-select.min.js"></script>
<script src="bootstrap.min.js"></script>

<div class="form-group" id="chemicals">
    <label for="chemical">Chemicals:</label><br>
    <select class="selectpicker" placeholder="Chemical" data-live-search="true">
    <?php 
    include 'db.php';               
    $result = mysqli_query($conn,"SELECT * FROM Supplement");
    while($row = $result->fetch_assoc()){
        $catID = $row['SupID'];
        $catName = $row['SupName'];
        echo "<option value='$catID'>$catName</option>";
        echo '<br>';
    }
    include 'closeDB.php';
    ?>
        
    </select>
</div>

<div class="row">
            <div class="form-inline">
                <input type="text" class="form-control" placeholder="关键字" />
                <input type="text" class="form-control" placeholder="hahaha" />
                <button class="btn btn-info" type="button" title="ADD" id="AddLine" onclick="AddLine(this)" disabled><span class="glyphicon glyphicon-plus"></span></button>
            </div>
 </div>

<script>
//添加中心机IP输入框项 
function AddLine(obj){ 
    html = '<div class="form-inline">'+ 
          '<input type="text" class="form-control" placeholder="关键字" />'+ 
          '<input type="text" class="form-control" placeholder="hahaha" />'+ 
          '<span class="input-group-btn">'+ 
                '<button class="btn btn-info" type="button" title="MINUS" id="DelLine"><span class="glyphicon glyphicon-minus"></span></button>'+ 
          '</span>'+ 
        '</div>' 
    obj.insertAdjacentHTML('beforebegin',html) 
  } 

  $(document).on('click','#DelLine',function(){ 
  var el = this.parentNode.parentNode 
  var centerIp = $(this).parent().parent().find('#ipInput').val() 
  alertify.confirm('您确定要删除选中的命令？', 
  function(e){ 
    if(e){ el.parentNode.removeChild(el)}})}) 
</script>






<script>
        function addMore(i, opt) {

            $("#plus").remove();

            var x = opt.entries();
            for (a of x){
                option += '<option value='+$catid'>$catname</option>
            }

            $('#chemicals').append('<div><input type="button" onclick="removeThis(' + i + ');" class="btn btn-danger" name="minus" id="minus' + i + '" value="-"></div>' 
            + '<div><select name="chemical" style="width:85%;float:left;margin-bottom:5px;"class="form-control" name="chemical0" placeholder="Chemical" value="">' 
            + '<option value= + '</select>'
            + '<input type="button" class="btn btn-success" name="plus" id="plus" value="+" onclick="addMore(' + (++i) + ');"></div>');
        
            /*$('#chemicals').append('<div><input type="button" onclick="removeThis(' + i + ');" class="btn btn-danger" name="minus" id="minus' + i + '" value="-"></div>' 
            + '<div><input type="text" style="width:85%;float:left;margin-bottom:5px;" class="form-control" name="chemical' + i + '" placeholder="Chemical" value="">'
            + '<input type="button" class="btn btn-success" name="plus" id="plus" value="+" onclick="addMore(' + (++i) + ');"></div>');*/
        }

        function removeThis(j) {
            $("#chemical" + j).remove();
            $("#minus" + j).remove();
        }
        </script>    

<div class="input-group" id="centerIpGroup"> 
  <label class="input-group-addon" id="basic-addon5">中心机IP:</label>   
  <button class="btn btn-info" type="button" data-toggle="tooltip" title="新增" id="addCenterIpGrpBtn" onclick="addCenterIpGrp(this)" disabled><span class="glyphicon glyphicon-plus"></span></button>    
</div> 

<script>

function addCenterIpGrp(obj){ 
    html = '<div class="input-group centerIp">'+ 
          '<label class="input-group-addon">IP：</label>'+ 
          '<input type="text" class="form-control" id="ipInput">'+ 
          '<label class="input-group-addon">注释：</label>'+ 
          '<input type="text" class="form-control" id="descInput">'+ 
          '<span class="input-group-btn">'+ 
                '<button class="btn btn-info" type="button" data-toggle="tooltip" title="删除" id="delCenterIpGrp"><span class="glyphicon glyphicon-minus"></span></button>'+ 
          '</span>'+ 
        '</div>' 
    obj.insertAdjacentHTML('beforebegin',html) 
  } 

  $(document).on('click','#delCenterIpGrp',function(){ 
  var el = this.parentNode.parentNode 
  var centerIp = $(this).parent().parent().find('#ipInput').val() 
  alertify.confirm('您确定要删除选中的命令？', 
  function(e){ 
    if(e){ el.parentNode.removeChild(el)}})}) 
</script>