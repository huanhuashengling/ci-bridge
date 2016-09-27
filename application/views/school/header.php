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
            <a class="navbar-brand" href="#">学生电子成长档案</a>
        </div>
    <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="<?php echo ($activeLink == 'students-data-management') ? 'active' : ''; ?>"><a href="/school/students-data-management">学生信息管理</a></li>
            <li class="<?php echo ($activeLink == 'class-evaluation-count') ? 'active' : ''; ?>"><a href="/school/class-evaluation-count">班级评价统计</a></li>
            <li class="<?php echo ($activeLink == 'school-evaluation-count') ? 'active' : ''; ?>"><a href="/school/school-evaluation-count">学校评价统计</a></li>
            <li class="<?php echo ($activeLink == 'grade-evaluation-count') ? 'active' : ''; ?>"><a href="/school/grade-evaluation-count">年级评价统计</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">账户管理 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">修改密码</a></li>
                <li><a href="#">修改信息</a></li>
                <li><a href="/user/logout">退出系统</a></li>
              </ul>
            </li>
        </ul>
    </div><!--/.nav-collapse -->
    </div>
</nav>
<h1></h1>
<hr/>