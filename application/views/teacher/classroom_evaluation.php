<div class="container" id="classroom-evaluation">
    <div id="classes-selection" class="">
        <h4>请选择评价的班级</h4>
        <?php
            echo "<table class='table table-striped table-hover table-condensed'>";

            foreach ($classesData as $key => $gradeClasses) {
                echo "<tr>";
                foreach ($gradeClasses as $key => $class) {
                    echo "<td><button class='btn btn-info btn-lg class-btn' value='" . $class['id'] . "'>" . $class['name'] . "</button></td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        ?>
    </div>

    <div id="students-selection" class='hidden'>
        <h4>请选择评价的学生</h4>
        <?php
            if (isset($selectedStudentsData)) {

                echo "<table class='table table-striped table-hover table-condensed'>";

                foreach ($selectedStudentsData as $key => $student) {
                    echo "<tr>";
                        echo "<td><button class='btn btn-info btn-lg class-btn' id='" . $student['id'] . "'>" . $student['username'] . "</button></td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
    </div>

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