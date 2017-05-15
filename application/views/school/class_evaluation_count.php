<div class="container">
    <h4>请选班级</h4>
    <div class='col-md-6'>
        <div class='btn-group' name='class-btn-group' data-toggle='buttons'>
    <?php
        //echo "";//<table class='table table-striped table-hover table-condensed'>";
        foreach ($classesData as $key => $gradeClasses) {
            //echo "<tr>";
            foreach ($gradeClasses as $key => $class) {
                echo "<label class='btn btn-default btn-lg class-btn'><input type='radio' id='" . $class['id'] . "'>" . $class['name'] . "</label>";
                //echo "<td><a class='btn btn-primary class-btn' value='" . $class['id'] . "'>" . $class['name'] . "</a></td>";
            }
            //echo "</tr>";
        }
        //echo "";
    ?>
        </div>
    </div>
    <h4>请选课程</h4>
    <div class='col-md-6'>
        <div class="btn-group" name="course-btn-group" data-toggle="buttons">
            <label class='btn btn-default btn-lg active'><input type='radio'>全部</label>
        <?php
            foreach ($courses as $key => $course) {
                echo "<label class='btn btn-default btn-lg course-btn'><input type='radio' id='" . $course['id'] . "'>" . $course['name'] . "</label>";
            }
        ?>
        </div>
    </div>
    <hr>
    <button class="btn btn-primary" id="check-count">查询</button>
    <hr>
<!--         <table data-toggle="table">
    <thead>
        <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Item Price</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Item 1</td>
            <td>$1</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Item 2</td>
            <td>$2</td>
        </tr>
    </tbody>
</table> -->
    <div id="class-evaluation-list">
    </div>
</div>