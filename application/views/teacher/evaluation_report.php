<?php $active = ("true"==$todaySelect)?"active":"";?>
<div class="container">
    <div class="form-group">
        <div class="col-sm-2">
            <button class="btn btn-primary <?=$active?>" type="button" id="today-btn"><?=("active" == $active)?"退出":""?>查询今天</button>
        </div>
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
        <h4>选择后查询结果</h4>
    </div>
    <div class="content">
    <table class='table table-hover table-condensed'>
    <tr class="item-row">
    <?php
    $maxNumPerLine = 6;
    $num = 1;
    foreach ($evaluationData as $key => $item):
        if ($num < $maxNumPerLine):
            $num++;
    ?>
            <td><button class="btn btn-success btn-lg" type="button"><?=$item['username']?> <span class="badge"><?=$item['count']?></span></button></td>
          <?php else: $num = 1;?>
            <td><button class="btn btn-success btn-lg" type="button"><?=$item['username']?> <span class="badge"><?=$item['count']?></span></button></td></tr><tr>
          <?php endif; ?>
    <?php endforeach ?>
    </tr>
    </table>
    </div>
</div>
