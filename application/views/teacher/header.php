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
            <li class="<?php echo ($activeLink == 'classroom-evaluation') ? 'active' : ''; ?>"><a href="/teacher/classroom-evaluation">课堂评价</a></li>
            <li class="<?php echo ($activeLink == 'evaluation-history') ? 'active' : ''; ?>"><a href="/teacher/evaluation-history">评价历史</a></li>
            <?php if ($courseLeader) :?>
            <li class="<?php echo ($activeLink == 'course-evaluation-management') ? 'active' : ''; ?>"><a href="/teacher/course-evaluation-management">学科评价设计</a></li>
            <?php endif;?>
            <?php if ($classTeacher) :?>
                <li class="<?php echo ($activeLink == 'class-student-info') ? 'active' : ''; ?>"><a href="/teacher/class-student-info">班级学生信息</a></li>
                <!-- <li class="<?php echo ($activeLink == 'class-evaluation-report') ? 'active' : ''; ?>"><a href="/teacher/class-evaluation-report">班级评价报告</a></li> -->
            <?php endif;?>
            <?php //if ($manager) :?>
                <!-- <li class="<?php echo ($activeLink == 'class-daily-evaluate') ? 'active' : ''; ?>"><a href="/teacher/class-daily-evaluate">班级日常评价</a></li> -->
            <?php //endif;?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">账户管理 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class='disabled'><a href="#">修改密码</a></li>
                <li class='disabled'><a href="#">修改信息</a></li>
                <li><a href="/user/logout">退出系统</a></li>
              </ul>
            </li>
        </ul>
    </div><!--/.nav-collapse -->
    </div>
</nav>
<h1></h1>
<hr/>