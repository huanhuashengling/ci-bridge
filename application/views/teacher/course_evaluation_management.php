<div id="container">
    <h1><?=$course['name']; ?>学科评价设计</h1>
    <input id='courses-id' type='hidden' value='<?=$course['id']?>'>
    <input id='index-id' type='hidden' value=''>
    <input id='current-operate' name="currentOperate" type='hidden' value=''>
    <input id='current-index-id' type='hidden' value=''>
    <input id='current-detail-id' type='hidden' value=''>

    <div id='evaluation_content'><table class='table table-striped table-hover table-condensed'><tr><td><h3>评价指标</h3></td><td><h3>评价细则</h3></td><td><h3>操作</h3></td></tr>
    <?php
    foreach ($courseEvaluationInfo as $key => $indexItem) {
        echo "<tr><td><h4>" . $indexItem["order_number"] . ". <span>". $indexItem["description"] . "</span></h4></td><td>";
        echo "<table class='table table-striped table-hover table-condensed'>";

        $details = $indexItem['details'];
        foreach ($details as $key => $detailItem) {
            echo "<tr><td>" . $detailItem["order_number"] . ". <span>" . $detailItem["description"] . "</span></td><td>";
            echo "<button value='" . $detailItem["id"] . "' name='' class='btn btn-info btn-sm edit-detail-btn' type='button'>编辑</button>";
            echo "<button value='" . $detailItem["id"] . "' name='' class='btn btn-info btn-sm del-detail-btn' type='button'>删除</button></td></tr>";
        }

        echo '<tr><td colspan="2"><button type="button" class="btn btn-info btn-sm add-detail-btn" value="'. $indexItem['id']. '">增加评价细则</button></td></tr></table></td>';

        echo '<td><button class="btn btn-primary edit-index-btn" type="button" value="'. $indexItem['id']. '">编辑</button>';

        echo '<button class="btn btn-primary del-index-btn" type="button" value="'. $indexItem['id']. '">删除</button></td></tr>';
    }
    ?>
    <tr><td colspan='3'><button class='btn btn-primary' id='add-index-btn' type='button'>增加评价指标</button></td></tr></table></div>


    <div id="addPop" class="modal fade" data-show="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content data-dump">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id='pop-title'></h4>
          </div>
          <div class="modal-body">
          <input type="text" id="pop-input" class="form-control"/>
          <label id="warning-label"></label>
          <hr/>
          <button class="btn btn-primary" id="pop-submit-btn"></button>
          <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">取消</button>
          </div>
        </div>
        <!-- /.modal-content --> 
        </div>
      <!-- /.modal-dialog -->
    </div>
</div>
