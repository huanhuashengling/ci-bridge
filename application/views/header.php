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
            <li class="<?php echo ($activeLink == 'login') ? 'active' : ''; ?>"><a href="../user/login">登录</a></li>
            <li class="<?php echo ($activeLink == 'about') ? 'active' : ''; ?>"><a href="../user/about">关于</a></li>
            <li class="<?php echo ($activeLink == 'contact') ? 'active' : ''; ?>"><a href="../user/contact">联系</a></li>
        </ul>
    </div><!--/.nav-collapse -->
    </div>
</nav>
<h1></h1>
<hr/>