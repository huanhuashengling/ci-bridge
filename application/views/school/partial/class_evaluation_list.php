<div id="student-evaluate-list">
    <table id="table" class='table table-striped table-hover table-condensed' data-toggle="table">
        <thead>
            <tr>
                <th width="5%" data-sortable="true">编号</th>
                <th width="10%" data-sortable="true">
                学生姓名</th>
                <?php foreach ($selectCourses as $key => $course): ?>
                    <th width="8%" data-sortable="true"><?=$course['name']?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
    
    <?php foreach ($classEvaluationData as $i => $classEvaluationDataItem): ?>
        <tr>
        <?php foreach ($classEvaluationDataItem as $key => $item): ?>
            <td><?=$item?></td>
        <?php endforeach;?>
        </tr>
    <?php endforeach; ?>
    </tr>
    </table>
    <h5>合计评价<?=$totalCount?>次，<?=$totalScore?>分</h5>
    <!-- <button class='btn default export-btn'>导出</button> -->
</div>
<script type="text/javascript">
    $('#table').bootstrapTable();
</script>

