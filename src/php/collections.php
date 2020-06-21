<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
                                     initial-scale=1.0,
                                     maximum-scale=1.0,
                                     user-scalable=no">
    <title>Collections</title>
    <link href="../../bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/search.css">
    <link rel="stylesheet" href="../styles/collection.css">
</head>
<body>
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse">
                <span class="sr-only">切换导航</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../../index.php" id="logo"><img src="../../images/icon/jupiter_logo.png" alt="logo"></a>
        </div>
        <div class="collapse navbar-collapse" id="example-navbar-collapse">
            <ul class="nav navbar-nav" id="mynav">
                <li><a href="../../index.php">首页</a></li>
                <li><a href="browser.php">浏览</a></li>
                <li><a href="search.php">搜索</a></li>
            </ul>

            <?php
            session_start();
            if (isset($_SESSION['Username'])) {
                echo '
            <ul class="nav navbar-nav nav-pills navbar-right">
                <li class="dropdown pull-right" id="user">
                    <a class="dropdown-toggle navbar-right" data-toggle="dropdown" href="#">用户<span class="caret"></span></a>
                    <ul class="dropdown-menu ">
                        <li><a href="upload.php"><span class="glyphicon glyphicon-cloud-upload"></span> 上传</a></li>
                        <li><a href="collections.php"><span class="glyphicon glyphicon-picture"></span> 我的</a></li>
                        <li><a href="favorites.php"><span class="glyphicon glyphicon-heart"></span> 收藏</a></li>
                        <li><a href="../forPhp/logout.php"><span class="glyphicon glyphicon-share"></span> 登出</a></li>
                    </ul>
                </li>
            </ul>';
            }
            else {
                echo '
            <ul class="nav navbar-nav nav-pills navbar-right">
                        <li><a href="../../src/php/login.php">登陆</a></li>
            </ul>';
            }
            ?>
        </div>
    </div>
</nav>

<div class="result" id="txtHint">

</div>

<div class="page">

    <ul class="pagination" id="page">

        <li class="arrows"><a href="#" id="prev" data-page="1"><<</a></li>
        <li class="arrows"><a  href="#" id="next" data-page="2">>></a></li>
    </ul>

</div>

<footer><p>备案号：18307110426</p></footer>
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="../../bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="../js/ajaxCancelLike.js"></script>
<script src="../js/ajaxCollect.js"></script>
</body>
</html>
