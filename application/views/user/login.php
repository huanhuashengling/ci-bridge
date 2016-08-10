<!--<h1><?php echo lang('login_heading');?></h1>
<p><?php echo lang('login_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("user/login");?>

  <p>
    <?php echo lang('login_identity_label', 'identity');?>
    <?php echo form_input($identity);?>
  </p>

  <p>
    <?php echo lang('login_password_label', 'password');?>
    <?php echo form_input($password);?>
  </p>

  <p>
    <?php echo lang('login_remember_label', 'remember');?>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>


  <p><?php echo form_submit('submit', lang('login_submit_btn'));?></p>

<?php echo form_close();?>

<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
-->
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Jumbotron Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://v3.bootcss.com/examples/jumbotron/jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- <script src="../../assets/js/ie-emulation-modes-warning.js"></script> -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">学生成长评价系统</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <form action="/user/login" method="post" class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="用户名" name="identity" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="密码" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">登录</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>欢迎来到学生成长评价系统!</h1>
        <p>您现在看到的是学生成长评价系统，这是一款旨在记录学生课堂表现的应用程序，学生课堂表现即可反映学生平时在校的学习状态；学科之间的变现差异也体现出孩子对某门功课的兴趣。</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">了解更多 &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>记录学生成长</h2>
          <p>当前主流的教育理念是生本课堂，希望学生做自己学习的主人，学习的主动性如何看得到，当然是记录课堂中的优秀变现最为恰当. </p>
          <p><a class="btn btn-default" href="#" role="button">查看详细 &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>家长关注成长</h2>
          <p>当下家长的素质越来越高，家长群体接受过高等教育，了解最新的教育理念，特别在意自己孩子的成长，尤其是在校变现如何，这款系统为家长提供一个窗口，可以了解孩子每天课堂的表现. </p>
          <p><a class="btn btn-default" href="#" role="button">查看详细 &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>教师关心成长</h2>
          <p>学校管理层，各学科组长，班主任以及每个任课教师，都会对自己的学生整体或者个体的变现有一个大概的印象，模糊但不具体，通过此系统的量化，我们可以了解当前的状况，结合历史数据，我们也可以了解到学生的趋势.</p>
          <p><a class="btn btn-default" href="#" role="button">查看详细 &raquo;</a></p>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Company 2016</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!-- <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script> -->
  </body>
</html>
