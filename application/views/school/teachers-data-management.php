<div class="container">
    <div>
        <h4>教师信息导入</h4>
        <?php echo form_open_multipart('/school/teachers-data-management'); ?>
            <div class="form-group">
                <div class="widget col-xs-12">
                    <div class="widget-controls">
                        <div class="label" style="display: inline-block">只支持上传csv文件</div>
                    </div>
                    <input type="file" id="importField" class="btn btn-default pull-left" name="csvfile" />
                    <input type="submit" id="importBtn" class="btn btn-default btn-file" value="导入" />
                </div>
          </div>
        <?php echo form_close();?>
    </div>

    <div>
        <h4>教师账户列表</h4>
        <table class='table table-striped table-hover table-condensed'>
        <tr>
        <td width="10%">编号</td>
        <td width="20%">教师姓名</td>
        <td width="20%">学科组长</td>
        <td width="20%">班主任</td>
        <td width="10%">重置密码</td>
        <td width="10%">操作</td>
        </tr>
        <?php $num = 1;?>
        <?php 
        $num = 0;
        foreach ($teachers as $key => $item): 
        $num++;
        ?>
            <tr>
            <td><?=$num?></td>
            <td><?=$item['username']?></td>
            <td><?=$item['course_name']?></td>
            <td><?=$item['class_name']?></td>
            <td><button class="btn btn-default reset-btn" value="<?=$item['id']?>">重置</button></td>
            <td><button class="btn btn-default edit-btn" value="<?=$item['id']?>">编辑</button></td>
            </tr>
        <?php endforeach ?>
        </table>
        <button class="btn btn-default add-teacher-btn disabled">添加教师</button>
    </div>
    
    <div id="popup" class="modal fade" data-show="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content data-dump">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">编辑教师信息</h4>
          </div>
          <div class="modal-body">
          <input type="text" hidden id="teachers-id">
          姓名：<input type="text" id="teacher-name" readonly class="form-control"/>
          学科组长：<input type="text" id="course-leader" class="form-control"/>
          班主任：<input type="text" id="class-teacher" class="form-control"/>
          <button class="btn btn-primary" id="edit-teacher-info">编辑</button>
          <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">取消</button>
          </div>
        </div>
        <!-- /.modal-content --> 
        </div>
      <!-- /.modal-dialog -->
    </div>
</div>