<div class="container">
      <!-- <form class="form-signin"> -->
      <?php echo form_open("user/login", 'class="form-signin"');?>
        <h1 class="form-signin-heading">学生电子成长档案</h1>
        <h3 class="form-signin-heading">请登录</h3>
        <input type="text" name="identity" class="form-control" placeholder="用户名" required="" autofocus="">
        <input type="password" name="password" class="form-control" placeholder="密码" required="">
        <div class="checkbox">
          <label>
            <!-- <input type="checkbox" value="remember-me"> Remember me -->
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
      <!-- </form> -->
    <?php echo form_close();?>

</div> <!-- /container -->