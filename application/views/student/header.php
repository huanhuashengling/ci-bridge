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
            <li class="<?php echo ($activeLink == 'star-swallow') ? 'active' : ''; ?>"><a href="/student/star-swallow">评价统计</a></li>
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