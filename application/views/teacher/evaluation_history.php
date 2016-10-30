<div class="container">
    <!--<?php echo form_open('', 'id="myform"');?>
    <div class="form-group">
        <div class="col-sm-2">
            <select id="week-select" class="form-control">
                <option value="1">2016年下学期</option>
                <option value="2">2017年上学期</option>
            </select>
        </div>
        <div class="col-sm-2">
            <select id="week-select" class="form-control">
                <option value="0">所有周次</option>
                <option value="1">第一周</option>
                <option value="2">第二周</option>
                <option value="3">第三周</option>
                <option value="4">第四周</option>
                <option value="5">第五周</option>
                <option value="6">第六周</option>
                <option value="7">第七周</option>
                <option value="8">第八周</option>
                <option value="9">第九周</option>
                <option value="10">第十周</option>
                <option value="11">第十一周</option>
                <option value="12">第十二周</option>
                <option value="13">第十三周</option>
                <option value="14">第十四周</option>
                <option value="15">第十五周</option>
                <option value="16">第十六周</option>
                <option value="17">第十七周</option>
                <option value="18">第十八周</option>
                <option value="19">第十九周</option>
                <option value="20">第二十周</option>
            </select>
        </div>
        <div class="col-sm-2">
            <select id="course-select" class="form-control">
                <option value="0">所有学科</option>
                <?php foreach ($courses as $key => $course): ?>
                <option value="<?=$course['id']?>"><?=$course['name']?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-sm-2">
            <input type="" name="" class="form-control">
        </div>
        <div class="col-sm-2">
            <button class="btn" type="submit">搜索</button>
        </div>
    </div>
<?php echo form_close(); ?>-->
    <div class="content">
    <table class='table table-hover table-condensed'>
    <tr>
    <td width="5%">编号</td>
    <td width="5%">班级</td>
    <td width="10%">学生姓名</td>
    <td width="5%">学科</td>
    <td width="15%">指标</td>
    <td width="35%">细则</td>
    <td width="5%">等第</td>
    <!-- <td width="5%">周次</td> -->
    <td width="10%">时间</td>
    <td width="5%">操作</td>
    </tr>
    <?php 
    $num = $startOrder;
    foreach ($evaluationData as $key => $item): 
    $num++;
    ?>
        <tr>
        <td><?=$num?></td>
        <td><?=$item['class_name']?></td>
        <td><?=$item['username']?></td>
        <td><?=$item['course_name']?></td>
        <td><?=$item['index_desc']?></td>
        <td><?=$item['detail_desc']?></td>
        <td><?=$item['score_name']?></td>
        <!-- <td><?=($item['week_num'] - 34)?></td> -->
        <td><?=date_format(date_create($item['evaluate_date']), "Y-m-d")?></td>
        <td><button class="btn btn-default delete-btn" value="<?=$item['id']?>">删除</button></td>
        </tr>
    <?php endforeach ?>
    </table>
    </div>
    <nav class="pull-right">
      <?php foreach ($data["links"] as $link) {
        echo $link;
        } ?>
    </nav>
</div>

<script type="text/javascript">
    function serialize_form() {
        return $('#myform').serialize();
    }
</script>