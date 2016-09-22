<div id="students-selection" class='<?=@$hideStudentsSelection?>'>
    <div><a class="btn btn-primary" href="/teacher/classroom-evaluation">返回班级选择</a></div>
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
</div>