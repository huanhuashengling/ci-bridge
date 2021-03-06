<div id="student-evaluate-list" class="col-md-12">
    <h3><p class="text-center"><?=$className?>班2017上学期“明星燕”评价统计结果：</p></h3>
    <table id="table" class='table table-striped table-hover table-condensed' data-toggle="table">
        <thead>
            <tr>
                <th width="5%" data-sortable="true">编号</th>
                <th width="8%" data-sortable="true">
                学生姓名</th>
                <?php foreach ($selectCourses as $key => $course): ?>
                    <th width="5%" data-sortable="true"><?=$course['name']?></th>
                <?php endforeach; ?>
                <th width="5%" data-sortable="true">合计</th>
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

