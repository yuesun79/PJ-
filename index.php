<?php
require_once('src/forPhp/config.php');
if (!isset($_GET['update']))
    $update = false;
else
    $update = $_GET['update'];
function displayHots($update) {
    try {
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (!$update)
            $sql = "SELECT * FROM travelimage ORDER BY Likes DESC LIMIT 12";
        else
            $sql = "SELECT * FROM travelimage ORDER BY RAND() LIMIT 12";
        $result = $pdo->query($sql);
        while ($row = $result->fetch()) {
            echo '<div class="col-md-3">
                        <figure>
                            <a target="_Blank" href="src/php/detailPage.php?id=' . $row['ImageID'] . '"><img src="travel-images/medium/' . $row['PATH'] .'" ' . 'alt="' . $row['Title'] . ' "></a>
                        </figure>
                        <div class="figcaption">
                            <p>'. $row['Title'] . '</p>
                            <p>'. $row['Description'] . '</p>
                        </div>
                    </div>
                    <div class="clearfix visible-xs"></div>';
        }
        $pdo = null;
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
                                     initial-scale=1.0,
                                     maximum-scale=1.0,
                                     user-scalable=no">
    <title>Jupiter</title>
    <link href="bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="src/styles/index.css">

</head>
<body>

<div class="container">
    <!--navigation-->
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#example-navbar-collapse">
                    <span class="sr-only">切换导航</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#" id="logo"><img src="images/icon/jupiter_logo.png" alt="logo"></a>
            </div>
            <div class="collapse navbar-collapse" id="example-navbar-collapse">
                <ul class="nav navbar-nav" id="mynav">
                    <li class="active"><a href="#">首页</a></li>
                    <li><a href="src/php/browser.php">浏览</a></li>
                    <li><a href="src/php/search.php">搜索</a></li>
                </ul>
<?php
    session_start();
    if (isset($_SESSION['Username'])) {
        echo '
            <ul class="nav navbar-nav nav-pills navbar-right">
                <li class="dropdown pull-right" id="user">
                    <a class="dropdown-toggle navbar-right" data-toggle="dropdown" href="#">用户<span class="caret"></span></a>
                    <ul class="dropdown-menu ">
                        <li><a href="src/php/upload.php"><span class="glyphicon glyphicon-cloud-upload"></span> 上传</a></li>
                        <li><a href="src/php/collections.php"><span class="glyphicon glyphicon-picture"></span> 我的</a></li>
                        <li><a href="src/php/favorites.php"><span class="glyphicon glyphicon-heart"></span> 收藏</a></li>
                        <li><a href="src/forPhp/logout.php"><span class="glyphicon glyphicon-share"></span> 登出</a></li>
                    </ul>
                </li>
            </ul>';
    }
    else {
        echo '
            <ul class="nav navbar-nav nav-pills navbar-right">
                        <li><a href="src/php/login.php">登陆</a></li>
            </ul>';
}
?>


            </div>
        </div>
    </nav>

    <!--carousel-->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- 轮播（Carousel）指标 -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <!-- 轮播（Carousel）项目 -->
        <div class="carousel-inner">
            <div class="item active">
                <img src="images/normal/wallhaven-005.jpg" alt="First slide">
                <div class="carousel-caption">花</div>
            </div>
            <div class="item">
                <img src="images/normal/wallhaven-002.png" alt="Second slide">
                <div class="carousel-caption">柠檬树</div>
            </div>
            <div class="item">
                <img src="images/normal/wallhaven-003.jpg" alt="Third slide">
                <div class="carousel-caption">francaise ville</div>
            </div>
        </div>

        <!-- 轮播（Carousel）导航 -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>


    <div class="row" id="display">

    <?php displayHots($update);?>

    </div>

    <div class="icon"><!--             两个小图标-->
        <a href="#top"><img src="images/icon/top.png" alt="返回顶部"></a>
        <?php echo
        '<a href="'. $_SERVER['SCRIPT_NAME'] . '?update=true' . ' "><img src="images/icon/restore.png" alt="刷新"></a>'
        ?>

    </div>

    <footer class="home-footer">
        <div class="words">
            <p>关于</p>
            <p>联系我们</p>
            <p>侵权申诉</p>
            <p>隐私政策</p>
            <p>帮助中心</p>
            <div class="words-div">
                <div class="footer-img-one">

                    <img class="weixin" src="images/icon/微信.png" alt="微信">
                    <div class="code">
                        <img src="images/icon/weixin-code.png" alt="微信二维码">
                    </div>
                </div>
                <img class="weibo" src="images/icon/微博.png" alt="微博">

            </div>

        </div>

        <p>备案号：18307110426</p>
    </footer>
</div>
<!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<!-- 包括所有已编译的插件 -->
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</body>
</html>