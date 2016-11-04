<div class="container">
    <!-- <?php echo form_open('', 'id="myform"');?> -->
    <div class="form-group">
        <!-- <div class="col-sm-2">
            <select id="week-select" class="form-control">
                <option value="1">2016年下学期</option>
                <option value="2">2017年上学期</option>
            </select>
        </div> -->
                <?php //var_dump($weekData);?>

        <div class="col-sm-2">
            <select id="week-select" class="form-control">
                <?php foreach ($weekData as $key => $week): ?>
                        <?php $weekSelected = ($key == $weekSelect)?"selected":""; ?>
                    <option value="<?=$key?>" <?=$weekSelected?>><?=$week?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-sm-2">
            <select id="class-select" class="form-control">
                <option value="0">所有班级</option>
                <?php foreach ($classes as $key => $class): ?>
                        <?php $classSelected = ($class['id'] == $classSelect)?"selected":""; ?>
                    <option value="<?=$class['id']?>" <?=$classSelected?>><?=$class['name']?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-sm-2">
            <select id="course-select" class="form-control">
                <option value="0">所有学科</option>
                <?php foreach ($courses as $key => $course): ?>
                    <?php $courseSelected = ($course['id'] == $courseSelect)?"selected":""; ?>
                    <option value="<?=$course['id']?>" <?=$courseSelected?>><?=$course['name']?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-sm-2">
            <input type="" name="" placeholder="学生姓名" class="form-control">
        </div>
        <div class="col-sm-2">
            <button class="btn" id="searchBtn" type="button">搜索</button>
        </div>
    </div>
<!-- <?php echo form_close(); ?> -->
<!-- <form id='search' class='search' method='post'>
    <input type='hidden' id='recno' name='recno' />
    <label for='searchterm'>查找</label>
    <input id='searchterm' name='searchterm' />
    <button type='submit'> 搜尋 </button>
</form> -->
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
        <tr class="item-row">
        <td><input type="checkbox" name="" class="history-item" value="<?=$item['id']?>">&nbsp<?=$num?></td>
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