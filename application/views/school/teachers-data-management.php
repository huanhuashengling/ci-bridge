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
        <td width="10%">教师姓名</td>
        <td width="10%">学科组长</td>
        <td width="10%">班主任</td>
        <td width="30%">任教学科</td>
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
            <td coursesId="<?=$item['course_leader']?>"><?=$item['course_name']?></td>
            <td classesId="<?=$item['class_teacher']?>"><?=$item['class_name']?></td>
            <td teacherCoursesId="<?=$teacherCoursesId[$item['id']]?>"><?=$teacherCoursesName[$item['id']]?></td>
            <td><button class="btn btn-default reset-btn" value="<?=$item['id']?>">重置</button></td>
            <td><button class="btn btn-default edit-btn" value="<?=$item['id']?>">编辑</button></td>
            </tr>
        <?php endforeach ?>
        </table>
        <button class="btn btn-default add-teacher-btn">添加教师</button>
    </div>
    
    <div id="popup" class="modal fade" data-show="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content data-dump">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 id="modal-title">编辑教师信息</h4>
          </div>
          <div class="modal-body">
          <input type="text" hidden id="teachers-id">
          <div class="col-md-2">姓名：</div>
          <div class="col-md-10"><input type="text" id="teacher-name" class="form-control"/></div><br><br>

          <div class="col-md-2">学科组长：</div>
          <div class="col-md-10">
            <?php foreach ($allCourses as $course) : ?>
              <label class="radio-inline"><input type="radio" name="courseLeader" id="course-leader" value="<?=$course['id']?>"><?=$course['name']?></label>
            <?php endforeach; ?>
            <label class="radio-inline"><input type="radio" name="courseLeader" id="course-leader" value="" checked="true">无</label>
          </div>
          <br><br>

          <div class="col-md-2">班主任：</div>
          <div class="col-md-10">
          <select class="form-control" id="class-teacher">
            <option value="">请选择</option>
            <?php foreach ($allClasses as $class) : ?>
              <option value="<?=$class['id']?>"><?=$class['name']?></option>
            <?php endforeach; ?>
          </select>
          </div>
          <br><br>

          <div class="col-md-2">任教学科：</div>
          <div class="col-md-10">
            <?php foreach ($allCourses as $course) : ?>
              <label class="checkbox-inline"><input type="checkbox" name="teacherCourse" value="<?=$course['id']?>"><?=$course['name']?></label>
            <?php endforeach; ?>
          </div>
          <br><br>

          <button class="btn btn-primary" id="edit-teacher-info">编辑</button>
          <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">取消</button>
          </div>
        </div>
        <!-- /.modal-content --> 
        </div>
      <!-- /.modal-dialog -->
    </div>
</div>