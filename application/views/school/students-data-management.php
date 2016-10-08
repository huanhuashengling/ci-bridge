<div class="container">
    <h4>班级学生信息导入</h4>
    <?php echo form_open_multipart('/school/students-data-management'); ?>
        <div class="form-group">
            <div class="widget col-xs-12">
                <div class="widget-controls">
                    <div class="label" style="display: inline-block">只支持上传csv文件</div>
                </div>
                <input type="file" id="importField" class="btn btn-default pull-left" name="csvfile" />
                <input type="submit" id="importBtn" class="btn btn-default btn-file" value="导入" />
            </div>
      </div>
    <?php echo form_close();?>

    <hr/>
    <div class="col-md-6">

        <h4>管理班级学生信息</h4>
            <select class="form-control" id="class-select">
                <option value="">请选择班级</option>
            <?php foreach ($classes as $key => $class) :?>
                <option value="<?=$class['id']?>"><?=$class['name']?></option>
            <?php endforeach;?>
            </select>
            <div id="students-list"></div>
          </div>
    </div>
</div>