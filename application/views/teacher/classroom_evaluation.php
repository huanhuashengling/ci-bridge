<div class="container" id="classroom-evaluation">
    <?php 
    echo $this->load->view('teacher/partial/classes_selection', [
        'classesData' => $classesData,
        'hideClassSelection' => $hideClassSelection,
    ], true);
    ?>

    <?php 
    echo $this->load->view('teacher/partial/students_selection', [
        'selectedStudentsData' => $selectedStudentsData,
        'hideStudentsSelection' => ("hidden" == $hideClassSelection)?"":"hidden",
    ], true);
    ?>

    <?php 
    echo $this->load->view('teacher/partial/comment_selection', [
        'courses' => $courses,
        'evaluationIndexInfo' => $evaluationIndexInfo,
        'evaluationIndexHtml' => $evaluationIndexHtml,
        'evaluationDetailHtml' => $evaluationDetailHtml,
        'evaluationDetailInfo' => $evaluationDetailInfo,
        'hideCommentSelection' => ("hidden" == $hideClassSelection)?"":"hidden",
    ], true);
    ?>
    
    <!-- <div id="students-selection">
        <div><a class="btn btn-primary" href="/teacher/classes-selection">返回班级选择</a></div>
        <h4>请选择评价的学生</h4>
        <?php
            if (isset($selectedStudentsData)) {
                // var_dump($selectedStudentsData);
                echo "<table class='table table-striped table-hover table-condensed'><tr>";
                $maxNumPerLine = 4;
                $num = 0;
                foreach ($selectedStudentsData as $key => $student) {
                  $btnClass = (0 == $student['gender'])?"btn-danger":"btn-primary";
                  $gender = (0 == $student['gender'])?"gender='girl'":"gender='boy'";
                  if ($num < $maxNumPerLine) {
                    $num++;
                    echo "<td><button class='btn " . $btnClass . " student-btn' " . $gender . " value='" . $student['id'] . "'>" . $student['username'] . "</button></td>";
                  } else {
                    $num = 0;
                    echo "<td><button class='btn " . $btnClass . " student-btn' " . $gender . " value='" . $student['id'] . "'>" . $student['username'] . "</button></td></tr><tr>";
                  }
                        
                }
                echo "</tr></table>";
            }
        ?>
    </div> -->

    <!-- <div id="comment-selection">
        <h4>请选择评价信息</h4>
        <?php
          if (isset($courses)) {
            
            $courseHtml = "<div class='btn-group' id='course-btn-group' name='course-btn-group' data-toggle='buttons'>";
            $evaluationIndexHtml = "<div class='btn-group' id='evaluation-index-btn-group' name='evaluation-index-btn-group' data-toggle='buttons'>";
            $evaluationDetailHtml = "<div class='btn-group' id='evaluation-detail-btn-group' name='evaluation-detail-btn-group' data-toggle='buttons'>";

            $courseActive = "active";
            foreach ($courses as $key => $course) {
              $courseHtml = $courseHtml . "<label class='btn btn-default " .$courseActive. "'><input type='radio' id='" . $course['id'] . "'>" . $course['name'] . "</label>";
              $courseActive = "";
            }
            $courseHtml = $courseHtml . "</div>";


            $evaluationIndexActive = "active";
            foreach ($evaluationIndexInfo as $key => $evaluationIndex) {
              $evaluationIndexHtml = $evaluationIndexHtml . "<label class='btn btn-default " .$evaluationIndexActive. "''><input type='radio' id='" . $evaluationIndex['id'] . "'>" . $evaluationIndex['description'] . "</label>";
              $evaluationIndexActive = "";
            }
            $evaluationIndexHtml = $evaluationIndexHtml . "</div>";

            $evaluationDetailActive = "active";
            foreach ($evaluationDetailInfo as $key => $evaluationDetail) {
              $evaluationDetailHtml = $evaluationDetailHtml . "<label class='btn btn-default " .$evaluationDetailActive. "'><input type='radio' id='" . $evaluationDetail['id'] . "'>" . $evaluationDetail['description'] . "</label>";
              $evaluationDetailActive = "";
            }
            $evaluationDetailHtml = $evaluationDetailHtml . "</div>";

            $evaluationLevel = "<div class='btn-group' name='level-btn-group' data-toggle='buttons'>
            <label class='btn btn-default active'><input type='radio' id='1'>优</label>
            <label class='btn btn-default'><input type='radio' id='2'>良</label>
            <label class='btn btn-default'><input type='radio' id='3'>差</label>
                              </div>";

            echo "<div>课程： " . $courseHtml . "</div>";
            echo "<div>评价指标： " . $evaluationIndexHtml . "</div>";
            echo "<div>评价细则：" . $evaluationDetailHtml . "</div>";
            echo "<div>评价等第：" . $evaluationLevel . "</div>";
            echo "<button id='submit-comment' class='btn btn-primary'>提交评价</button>";
          }
            
        ?>
    </div> -->

    <div id="addPop" class="modal fade" data-show="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content data-dump">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id='pop-title'></h4>
          </div>
          <div class="modal-body">
          <!-- <input type="text" id="pop-input" class="form-control"/> -->
          <!-- <label id="warning-label"></label> -->
          <!-- <hr/> -->
          <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">确认</button>
          </div>
        </div>
        <!-- /.modal-content --> 
        </div>
      <!-- /.modal-dialog -->
    </div>
</div>