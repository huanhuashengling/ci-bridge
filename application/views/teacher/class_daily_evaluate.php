<div class="container">
    <?php 
    echo $this->load->view('teacher/partial/multi_classes_select', [
        'classesData' => $classesData,
    ], true);
    ?>
    <div>
        <h4>选择评价内容</h4>
        
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