<div class="container">
<input type="hidden" name="" id="courses_id" value="<?php echo $coursesId; ?>">
<input type="hidden" name="" id="users_id" value="<?php echo $usersId; ?>">
 <div class="panel panel-success">
  <div class="panel-heading"><?php echo $coursesName; ?>学科评价详细</div>
  <div class="panel-body">
    <table id="student-evaluate-detail-list" class="table table-condensed table-responsive">
        <thead>
            <tr>
              <th data-field="">
                  序号
              </th> 
              <th data-field="teacher_name">
                  教师
              </th>
              <th data-field="courses_name">
                  学科
              </th>
              <th data-field="eidesc">
                  评价指标
              </th>
              <th data-field="eddesc">
                  评价细则
              </th>
              <th data-field="level_name">
                  等第
              </th>
              <th data-field="score">
                  分数
              </th>
              <th data-field="evaluate_date">
                  时间
              </th>
            </tr>
        </thead>
    </table>
  </div>
</div>
</div>