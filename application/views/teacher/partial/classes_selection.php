<div id="classes-selection" class='<?=@$hideClassSelection?>'>
    <h4>请选择评价的班级</h4>
    <?php
        echo "<table class='table table-striped table-hover table-condensed'>";

        foreach ($classesData as $key => $gradeClasses) {
            echo "<tr>";
            foreach ($gradeClasses as $key => $class) {
                echo "<td><a class='btn btn-info btn-lg class-btn' value='" . $class['id'] . "'>" . $class['name'] . "</a></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    ?>
</div>