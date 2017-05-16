<div class="container">
    <div class="panel panel-success">
            <div class="panel-heading">
                <h4>请选课程</h4>
                <div class="btn-group" name="course-btn-group" data-toggle="buttons">
                    <label class='btn btn-primary course-btn btn-lg active'><input type='radio'>全部</label>
                <?php
                    foreach ($courses as $key => $course) {
                        echo "<label class='btn btn-primary btn-lg course-btn'><input type='radio' id='" . $course['id'] . "'>" . $course['name'] . "</label>";
                    }
                ?>
                </div>
                <h4>请选班级</h4>
                <div class='btn-group' name='class-btn-group' data-toggle='buttons'>
                <?php
                    foreach ($classesData as $key => $gradeClasses) {
                        foreach ($gradeClasses as $key => $class) {
                            echo "<label class='btn btn-primary btn-lg class-btn'><input type='radio' id='" . $class['id'] . "'>" . $class['name'] . "</label>";
                        }
                    }
                ?>
                </div>
            </div>
        </div>
    <div id="class-evaluation-list">
    </div>
</div>