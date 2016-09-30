<div class="container">
    <h4>教师信息导入</h4>
    <?php echo form_open_multipart('/school/teachers-data-management'); ?>
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
</div>