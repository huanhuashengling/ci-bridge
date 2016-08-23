<?php
    $popupData = [
        'title' = "增加评价细则",
    ];
?>
<div id="popup" class="modal fade" data-show="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content data-dump">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><? echo $popupData['title']; ?></h4>
      </div>
      <div class="modal-body">
      <h1><? echo $popupData['title']; ?></h1>
      <input type="text" id="evaluationIndex" class="form-control"/>
      <button class="btn btn-primary" id="submit">增加</button>
      <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">取消</button>
      </div>
    </div>
    <!-- /.modal-content --> 
    </div>
  <!-- /.modal-dialog -->
</div>