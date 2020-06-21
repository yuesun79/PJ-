<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
                                     initial-scale=1.0,
                                     maximum-scale=1.0,
                                     user-scalable=no">
    <title>UpLoad</title>
    <link href="../../bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/upload.css">
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
<!--<form id="form1" method="post" class="upload-content" enctype="multipart/form-data">-->
<form id="form2" method="post" class="upload-content" enctype="multipart/form-data">
    <div id="box"
        <?php
            if (isset($_GET['PATH'])) {echo 'data-id="'. $_GET['imageID'] . '"';}
            echo '>';
            if (isset($_GET['PATH'])) { echo '<img src="../../travel-images/medium/' . $_GET['PATH'] . '">';}

        ?>
    </div>
    <a class="file"><?php if (isset($_GET['PATH'])) {echo '修改图片';} else echo '上传图片';?>
        <input name="image" id="file" type="file">
    </a>
    <div class="filter">
    <select name="content" id="content" required>
        <option value="scenery">Scenery</option>
        <option value="city">City</option>
        <option value="people">People</option>
        <option value="animal">Animal</option>
        <option value="building">Building</option>
        <option value="wonder">Wonder</option>
        <option value="others">others</option>
    </select>


    <select name="country" id="country" onchange="select(this)" required></select>

    <select name="city" id="city"></select>
    </div>
    <input name="title" id="title" class="normal" type="text" placeholder="图片标题" required>

    <textarea name="description" id="description" cols="100%" rows="1" wrap="soft" placeholder="图片描述" required></textarea>

    <input name="uploads" class="button" type="submit" value="<?php if (isset($_GET['PATH'])) {echo '修改';} else echo '上传';?>" ">

</form>

<footer><p>备案号：18307110426</p></footer>

<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="../../bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="../js/ajaxSelector.js"></script>
<script src="../js/upload.js"></script>

</body>
</html>
