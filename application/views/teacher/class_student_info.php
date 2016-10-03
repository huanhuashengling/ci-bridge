<div class="container">
<table class='table table-striped table-hover table-condensed'>
    <tr>
    <td width="5%">编号</td>
    <td width="10%">学生姓名</td>
    <td width="10%">性别</td>
    <td width="10%">操作</td>
    </tr>
    <?php $num = 1;?>
    <?php 
    $num = 0;
    foreach ($studentsData as $key => $student): 
    $num++;
    ?>
        <tr>
        <td><?=$num?></td>
        <td><?=$student['username']?></td>
        <td><?=((1 == $student['gender'])?"男":"女")?></td>
        <td><button class="btn btn-default delete-btn" value="<?=$student['id']?>">删除</button></td>
        </tr>
    <?php endforeach ?>
    </table>
    <button id="add-btn" class="btn btn-default" value="<?=$classesId?>">增加</button>
</div>