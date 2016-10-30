<div id="multi-classes-select">
    <h4>请选择班级</h4>
    <?php
        echo "<table class='table table-striped table-hover table-condensed'>";

        foreach ($classesData as $key => $gradeClasses) {
            echo "<tr>";
            foreach ($gradeClasses as $key => $class) {
                echo "<td><a class='btn btn-default btn-lg class-btn' value='" . $class['id'] . "'>" . $class['name'] . "</a></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    ?>
</div>