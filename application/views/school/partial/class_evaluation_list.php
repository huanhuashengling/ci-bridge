<div id="student-evaluate-list">
    <table data-toggle="table" class='table table-striped table-hover table-condensed'>
    <thead>
        <tr>
            <th width="5%" data-field="number" 
                    data-sortable="true">编号</th>
            <th width="10%" data-field="name" 
                    data-sortable="true">学生姓名</th>
            <?php foreach ($selectCourses as $key => $course): ?>
                <th width="8%"><?=$course['name']?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    
    <?php foreach ($classEvaluationData as $classEvaluationDataItem): ?>
        <tr>
        <?php foreach ($classEvaluationDataItem as $key => $item): ?>
            <td><?=$item?></td>
        <?php endforeach;?>
        </tr>
    <?php endforeach; ?>
    </tr>
    </table>
    <h5>合计评价<?=$totalCount?>次，<?=$totalScore?>分</h5>
    <button class='btn default export-btn'>导出</button>


</div>