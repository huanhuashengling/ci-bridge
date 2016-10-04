<div class="container">
    <div class="col-md-6">
        <table class='table table-striped table-hover table-condensed'>
        <tr>
        <td width="10%">编号</td>
        <td width="40%">老师姓名</td>
        <td width="20%">评价次数</td>
        </tr>
        <?php $num = 1;?>
        <?php 
        $num = 0;
        foreach ($teachersEvaluationData as $key => $item): 
        $num++;
        ?>
            <tr>
            <td><?=$num?></td>
            <td><?=$item['username']?></td>
            <td><?=$item['totalCount']?></td>
            </tr>
        <?php endforeach ?>
        </table>
        <button class='btn default export-btn'>导出</button>
    </div>
</div>