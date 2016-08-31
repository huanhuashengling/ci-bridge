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
            <li class="<?php echo ($activeLink == 'classroom-evaluation') ? 'active' : ''; ?>"><a href="/teacher/classroom-evaluation">课堂评价</a></li>
            <li class="<?php echo ($activeLink == 'course-evaluation-management') ? 'active' : ''; ?>"><a href="/teacher/course-evaluation-management">学科评价设计</a></li>
            <!-- <li class="<?php echo ($activeLink == 'class-student-info') ? 'active' : ''; ?>"><a href="/teacher/class-student-info">班级学生信息</a></li> -->
            <li class="<?php echo ($activeLink == 'students-data-management') ? 'active' : ''; ?>"><a href="/teacher/students-data-management">学生信息管理</a></li>
            <li class="<?php echo ($activeLink == 'class-evaluation-count') ? 'active' : ''; ?>"><a href="/teacher/class-evaluation-count">班级评价统计</a></li>
            <li class="<?php echo ($activeLink == 'school-evaluation-count') ? 'active' : ''; ?>"><a href="/school/school-evaluation-count">学校评价统计</a></li>
            <li class="<?php echo ($activeLink == 'grade-evaluation-count') ? 'active' : ''; ?>"><a href="/school/grade-evaluation-count">年级评价统计</a></li>
            <li class="<?php echo ($activeLink == 'login') ? 'active' : ''; ?>"><a href="/user/login">登录</a></li>
            <li class="<?php echo ($activeLink == 'about') ? 'active' : ''; ?>"><a href="/user/about">关于</a></li>
            <li class="<?php echo ($activeLink == 'contact') ? 'active' : ''; ?>"><a href="/user/contact">联系</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">账户管理 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">修改密码</a></li>
                <li><a href="#">修改信息</a></li>
                <li><a href="#">退出系统</a></li>
              </ul>
            </li>
        </ul>
    </div><!--/.nav-collapse -->
    </div>
</nav>
<h1></h1>
<hr/>