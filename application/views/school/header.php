<?php
    $activeLink = '';
    $activeLink = $route['method'];
    // $activeLink = strtolower($route['method']);
    // $method = str_replace('_', '-', $method);
    // $methodParts = explode('-', $method);
    // $activeLink = $methodParts[0];
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            <a class="navbar-brand" href="#">燕山小学明星燕评价系统</a>
        </div>
    <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="<?php echo ($activeLink == 'students-data-management') ? 'active' : ''; ?>"><a href="../school/students-data-management">学生账户</a></li>
            <li class="<?php echo ($activeLink == 'teachers-data-management') ? 'active' : ''; ?>"><a href="../school/teachers-data-management">教师账户</a></li>
            <li class="<?php echo ($activeLink == 'class-evaluation-count') ? 'active' : ''; ?>"><a href="../school/class-evaluation-count">班级统计</a></li>
            <li class="<?php echo ($activeLink == 'teacher-evaluation-count') ? 'active' : ''; ?>"><a href="../school/teacher-evaluation-count">教师统计</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">账户管理 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">修改密码</a></li>
                <li><a href="#">修改信息</a></li>
                <li><a href="../user/logout">退出系统</a></li>
              </ul>
            </li>
        </ul>
    </div><!--/.nav-collapse -->
    </div>
</nav>
<h1></h1>
<hr/>