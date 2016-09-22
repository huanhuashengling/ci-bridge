<div id="comment-selection" class='<?=@$hideCommentSelection?>'>
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
    </div>