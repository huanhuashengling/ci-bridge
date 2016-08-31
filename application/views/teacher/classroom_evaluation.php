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

                echo "<table class='table table-striped table-hover table-condensed'><tr>";
                $maxNumPerLine = 4;
                $num = 0;
                foreach ($selectedStudentsData as $key => $student) {
                  if ($num < $maxNumPerLine) {
                    $num++;
                    echo "<td><button class='btn btn-info class-btn' id='" . $student['id'] . "'>" . $student['username'] . "</button></td>";
                  } else {
                    $num = 0;
                    echo "<td><button class='btn btn-info class-btn' id='" . $student['id'] . "'>" . $student['username'] . "</button></td></tr><tr>";
                  }
                        
                }
                echo "</tr></table>";
            }
        ?>
    </div>

    <div id="comment-selection">
        <h4>请选择评价信息</h4>
        <?php
          if (isset($courses)) {
            $courseHtml = "";
            $evaluationIndexHtml = "";
            $evaluationDetailHtml = "";
            foreach ($courses as $key => $course) {
              $courseHtml = $courseHtml . "<button class='btn btn-info class-btn' id='" . $course['id'] . "'>" . $course['name'] . "</button>";

              foreach ($evaluationIndexData[$course['id']] as $key => $evaluationIndex) {
                $evaluationIndexHtml = $evaluationIndexHtml . "<button class='btn btn-info class-btn' id='" . $evaluationIndex['id'] . "'>" . $evaluationIndex['description'] . "</button>";

                foreach ($evaluationDetailData[$evaluationIndex['id']] as $key => $evaluationDetail) {
                  $evaluationDetailHtml = $evaluationDetailHtml . "<button class='btn btn-info class-btn' id='" . $evaluationDetail['id'] . "'>" . $evaluationDetail['description'] . "</button>";
                  
                }
              }

            }

            echo "课程： " . $courseHtml;
            echo "评价指标： " . $evaluationIndexHtml;
            echo "评价细则：" . $evaluationDetailHtml;
            var_dump($courses);
            var_dump($evaluationIndexData);
            var_dump($evaluationDetailData);
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