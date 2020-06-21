<?php
require_once('../forPhp/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--    <meta name="viewport" content="width=device-width">-->
    <meta name="viewport" content="width=device-width,
                                     initial-scale=1.0,
                                     maximum-scale=1.0,
                                     user-scalable=no">
    <title>Jupiter-Search</title>
    <link href="../../bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/search.css">
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
                <li class="active"><a href="search.php">搜索</a></li>
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
                        <li><a href="login.php">登陆</a></li>
            </ul>';
            }
            ?>
        </div>
    </div>
</nav>

    <div class="search"><!--            搜索部分-->

        <form method="post" name="form" id="form">


            <div class="radio">
                <input class="radio-type" id="radio-1" type="radio" name="radio" value="titleSearch" checked>
                <label for="radio-1" class="radio-label" name="label">  标题搜索</label>
                <input type="text" name="sTitle">
            </div>

            <div class="radio">
                <input class="radio-type" id="radio-2" type="radio" name="radio" value="contentSearch">
                <label for="radio-2" class="radio-label" name="label">  内容搜索</label>
                <textarea name="sContent" cols="auto" rows="1"></textarea>
            </div>

            <br>
            <input type="submit" name="go" value="搜索">
        </form>

    </div>

    <div class="result" id="txtHint">

    </div>

<div class="page">

    <ul class="pagination" id="page">

        <li class="arrows"><a href="#" id="prev" data-page="1"><<</a></li>
        <li class="arrows"><a  href="#" id="next" data-page="2">>></a></li>
    </ul>


</div>
</section>

<footer><p>备案号：18307110426</p></footer>

<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="../../bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="../js/ajaxSearch.js"></script>
<script src="../js/ajaxSearchPage.js"></script>
<!--<script src="../js/ajaxChangePage.js"></script>-->
</body>
</html>
