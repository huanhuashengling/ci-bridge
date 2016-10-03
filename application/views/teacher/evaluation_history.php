<div class="container">
    <table class='table table-striped table-hover table-condensed'>
    <tr>
    <td width="5%">编号</td>
    <td width="10%">学生姓名</td>
    <td width="10%">学科</td>
    <td width="20%">指标</td>
    <td width="40%">细则</td>
    <td width="10%">时间</td>
    <td width="10%">操作</td>
    </tr>
    <?php $num = 1;?>
    <?php 
    $num = 0;
    foreach ($evaluationData as $key => $item): 
    $num++;
    ?>
        <tr>
        <td><?=$num?></td>
        <td><?=$item['username']?></td>
        <td><?=$item['course_name']?></td>
        <td><?=$item['index_desc']?></td>
        <td><?=$item['detail_desc']?></td>
        <td><?=date_format(date_create($item['evaluate_date']), "Y-m-d")?></td>
        <td><button class="btn btn-default delete-btn" value="<?=$item['id']?>">删除</button></td>
        </tr>
    <?php endforeach ?>
    </table>
</div>