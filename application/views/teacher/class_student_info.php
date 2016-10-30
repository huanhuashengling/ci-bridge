<div class="container">
    <div class="col-md-6">
        <input type="text" hidden name="classesId" value="<?=$classesId?>">
        <table class='table table-striped table-hover table-condensed'>
            <tr>
            <td width="10%">编号</td>
            <td width="30%">学生姓名</td>
            <td width="10%">性别</td>
            <td width="20%">激活</td>
            <td width="10%">操作</td>
            </tr>
            <?php $num = 1;?>
            <?php 
            $num = 0;
            foreach ($studentsData as $key => $student):
            $num++;
            if (1 == $student['active']) {
              $class = 'btn-danger';
              $text = '冻结';
            } else {
              $class = 'btn-success';
              $text = '激活';
            }
            $activeHtml = "<button class='btn " . $class . " active-btn' value='" . $student['id'] . "' >" . $text . "</button>";
            ?>
                <tr>
                <td><?=$num?></td>
                <td><?=$student['username']?></td>
                <td><?=((1 == $student['gender'])?"男":"女")?></td>
                <td><?=$activeHtml?></td>
                <td><button class="btn btn-default delete-btn <?=$enableDelete?>" value="<?=$student['id']?>">删除</button></td>
                </tr>
            <?php endforeach ?>
        </table>
        <button id="add-btn" class="btn btn-default" value="<?=$classesId?>">增加</button>
    </div>

    <div id="addPop" class="modal fade" data-show="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content data-dump">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id='pop-title'>增加学生</h4>
          </div>
          <div class="modal-body">
            姓名：<input type="text" name="studentName" class="form-control"/>
            性别：<input type="text" name="studentGender" class="form-control"/>
          <label id="warning-label"></label>
          <hr/>
          <button class="btn btn-primary" id="pop-submit-btn">增加</button>
          <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">取消</button>
          </div>
        </div>
        <!-- /.modal-content --> 
        </div>
      <!-- /.modal-dialog -->
    </div>
</div>