<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>学生成长评价系统</title>
    <link rel="shortcut icon" href="/favicon.ico?v=2" />
    <link rel="stylesheet" href="/css/basic.css">
    <link rel="stylesheet" href="/css/carousel.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/jquery-ui.css">
    <!-- <link rel="stylesheet" href="/css/flatit.css"> -->
    
    <!-- <link rel="stylesheet" href="/js/libraries/tablesorter/css/style_system_data.css"> -->
    <!-- <link rel="stylesheet" href="/js/libraries/jqwidgets/styles/jqx.base.css" type="text/css" /> -->
    <?php
    if (isset($csses)) {
        for ($i = 0; $i < count($csses); $i++) {
            echo "<link href=\"".$csses[$i]."\" rel=\"stylesheet\" type=\"text/css\" />\n";
        }
    }
    ?>

    <script src="/js/jquery-1.12.4.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/jquery.cookie.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/basic.js"></script>
    
    
    <!--<script type="text/javascript" src="/js/libraries/tablesorter/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="/js/libraries/tablesorter/jquery.tablesorter.pager.js"></script>
    <script type="text/javascript" src="/js/libraries/tablesorter/jquery.tablesorter.staticrow.min.js"></script>
    <script type="text/javascript" src="/js/libraries/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="/js/libraries/jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="/js/libraries/jqwidgets/jqxchart.core.js"></script>
    <script type="text/javascript" src="/js/libraries/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="/js/libraries/jqwidgets/jqxchart.annotations.js"></script>
    <script type="text/javascript" src="/js/libraries/jqwidgets/jqxchart.api.js"></script>
    <script type="text/javascript" src="/js/libraries/chart_plugin.js"></script>-->


    <!-- scripts for Canara -->
    <script src="/js/libraries/ajax.js"></script>
    <script src="/js/libraries/validate-methods.js"></script>
    <script src="/js/libraries/popups.js"></script>
    <!-- <script src="/js/base.js" type="text/javascript"></script> -->
    <?php
    if (isset($jses)) {
        for ($i = 0; $i < count($jses); $i++) {
            echo "<script src=\"".$jses[$i]."\" type=\"text/javascript\"></script>"."\n";
        }
    }
    ?>


</head>
<body class="<?=$bodycss?> noselect">
<?php
// loads reuse-able popup
// echo $this->load->view('popups/iframe_snippet', [], true);
// echo $this->load->view('popups/loading_spinner_snippet', [], true);
?>
<div id="wrap">
    <?= $header ?>
    <div id="main">
        <?= $body ?>
    </div>
    <div class="clear"></div>
    <?= $footer ?>
</div>
</body>
</html>

