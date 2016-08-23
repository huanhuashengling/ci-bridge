<div class="container">
    <h1><?php echo $courseName; ?>学科评价设计</h1>
    <div id='evaluation_content'><table class='table table-striped table-hover table-condensed'><tr><td><h3>评价指标</h3></td><td><h3>评价细则</h3></td><td><h3>操作</h3></td></tr>
    <?php
    foreach ($courseEvaluationInfo as $key => $indexItem) {
        echo "<tr><td><h4>" . $indexItem["description"] . "</h4></td><td>";
        echo "<table class='table table-striped table-hover table-condensed'>";

        $details = $indexItem['details'];
        foreach ($details as $key => $detailItem) {
            echo "<tr><td>" . $detailItem["description"] . "</td><td>";
            echo "<button value='" . $detailItem["description"] . "' name='id' class='btn btn-info btn-sm' type='button' onclick=''>编辑</button>";
            echo "<button value='" . $detailItem["description"] . "' name='id' class='btn btn-info btn-sm' type='button' onclick=''>删除</button></td></tr>";
        }

        echo "<tr><td colspan='2'><button name='" . "id" . "' class='btn btn-info btn-sm' id='add_evaluation_detail' type='button' onclick=''>增加评价细则</button></td></tr></table></td>";

        echo "<td><button value='" . $indexItem["description"] . "' name='" . "id" . "' class='btn btn-primary' type='button' onclick=''>编辑</button>";

        echo "<button value='" . $indexItem["description"] . "' name='" . "id" . "' class='btn btn-primary' type='button' onclick=''>删除</button></td></tr>";
    }
    ?>
    <tr><td colspan='3'><button class='btn btn-primary' id='add_evaluation_index' type='button' onclick=''>增加评价指标</button></td></tr></table></div>
</div>


<div id="addEvaluationIndexPop" class="modal fade" data-show="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content data-dump">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">增加评价指标</h4>
      </div>
      <div class="modal-body">
      <h1>增加评价指标</h1>
      <input type="text" id="evaluationIndex" class="form-control"/>
      <button class="btn btn-primary" id="submit_evaluation_index">增加</button>
      <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">取消</button>
      </div>
    </div>
    <!-- /.modal-content --> 
    </div>
  <!-- /.modal-dialog -->
</div>

<div id="editEvaluationIndexPop" class="modal fade" data-show="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content data-dump">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">±à¼­ÆÀ¼ÛÖ¸±ê</h4>
      </div>
      <div class="modal-body">
      <input type="text" id="eidtEvaluationIndex" value="" class="form-control"/>
      <button class="btn btn-primary" id="edit_evaluation_index">±à¼­</button>
      <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">È¡Ïû</button>
      </div>
    </div>
    <!-- /.modal-content --> 
    </div>
  <!-- /.modal-dialog -->
</div>

<div id="delEvaluationIndexPop" class="modal fade" data-show="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content data-dump">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">É¾³ýÆÀ¼ÛÖ¸±ê:</h4>
      </div>
      <div class="modal-body">
      <input type="text" id="delEvaluationIndex" value="" readonly="readonly"  class="form-control"/>
      <button class="btn btn-primary" id="del_evaluation_index">È·¶¨É¾³ý</button>
      <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">È¡Ïû</button>
      </div>
    </div>
    <!-- /.modal-content --> 
    </div>
  <!-- /.modal-dialog -->
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------EvaluationDetailPop-->
<div id="addEvaluationDetailPop" class="modal fade" data-show="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content data-dump">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Ôö¼ÓÆÀ¼ÛÏ¸Ôò</h4>
      </div>
      <div class="modal-body">
      <h1>ÊäÈëÆÀ¼ÛÏ¸ÔòÃèÊö</h1>
      <input type="text" id="evaluationDetail" class="form-control"/>
      <label>ÔÚÏÂÃæµÄÎÄ±¾¿òÊäÈë¼Ó·ÖµÄ·ÖÖµ£¬Ö»ÄÜÎªÊý×Ö£¬¶à¸öÇë°´ÌÝ¶È¶ººÅ¸ô¿ª(1,2,3,4...)</label>
      <input type="text" id="evaluationScore" value="1" class="form-control"/>
      <button class="btn btn-primary" id="submit_evaluation_detail">Ôö¼Ó</button>
      <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">È¡Ïû</button>
      </div>
    </div>
    <!-- /.modal-content --> 
    </div>
  <!-- /.modal-dialog -->
</div>

<div id="editEvaluationDetailPop" class="modal fade" data-show="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content data-dump">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">±à¼­ÆÀ¼ÛÏ¸Ôò</h4>
      </div>
      <div class="modal-body">
      <input type="text" id="eidtEvaluationDetail" value="" class="form-control"/>
      <label>ÔÚÏÂÃæµÄÎÄ±¾¿òÊäÈë¼Ó·ÖµÄ·ÖÖµ£¬Ö»ÄÜÎªÊý×Ö£¬¶à¸öÇë°´ÌÝ¶È¶ººÅ¸ô¿ª(1,2,3,4...)</label>
      <input type="text" id="editEvaluationScore" value="" class="form-control"/>
      <button class="btn btn-primary" id="edit_evaluation_detail">±à¼­</button>
      <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">È¡Ïû</button>
      </div>
    </div>
    <!-- /.modal-content --> 
    </div>
  <!-- /.modal-dialog -->
</div>

<div id="delEvaluationDetailPop" class="modal fade" data-show="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content data-dump">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">É¾³ýÆÀ¼ÛÏ¸Ôò:</h4>
      </div>
      <div class="modal-body">
      <input type="text" id="delEvaluationDetail" value="" readonly="readonly"  class="form-control"/>
      <button class="btn btn-primary" id="del_evaluation_detail">È·¶¨É¾³ý</button>
      <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">È¡Ïû</button>
      </div>
    </div>
    <!-- /.modal-content --> 
    </div>
  <!-- /.modal-dialog -->
</div>

