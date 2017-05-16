<div class="container">
    <div class="panel panel-default">
            <div class="panel-body">
                <div class='col-md-12'>
                    <div class='col-md-12'><h4>请选课程</h4></div>
                    <div class='col-md-12'>
                        <div class="btn-group" name="course-btn-group" data-toggle="buttons">
                            <label class='btn btn-default course-btn btn-lg active'><input type='radio'>全部</label>
                        <?php
                            foreach ($courses as $key => $course) {
                                echo "<label class='btn btn-default btn-lg course-btn'><input type='radio' id='" . $course['id'] . "'>" . $course['name'] . "</label>";
                            }
                        ?>
                        </div>
                    </div>
                </div>
                <div class='col-md-12'>
                    <div class='col-md-11'><h4>请选班级</h4></div>
                    <div class='col-md-12'>
                        <div class='btn-group' name='class-btn-group' data-toggle='buttons'>
                        <?php
                            foreach ($classesData as $key => $gradeClasses) {
                                foreach ($gradeClasses as $key => $class) {
                                    echo "<label class='btn btn-default btn-lg class-btn'><input type='radio' id='" . $class['id'] . "'>" . $class['name'] . "</label>";
                                }
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div id="class-evaluation-list">
    </div>
</div>