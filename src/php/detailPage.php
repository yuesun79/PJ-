<?php ?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,
                                     initial-scale=1.0,
                                     maximum-scale=1.0,
                                     user-scalable=no">
    <title>detail</title>
    <link href="../../bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/detail.css">
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


<section>
    <figure class="container">
        <div class="row">
        <?php
        require_once('../forPhp/config.php');
        try {
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = 'SELECT * FROM travelimage WHERE ImageID=' . $_GET['id'];
        $result = $pdo->query($sql);
        while ($row = $result->fetch()) {
        ?>
            <div class="col-md-8">
                <img src="../../travel-images/medium/<?php echo $row['PATH']; ?>" alt="<?php echo $row['Title'] ?>">
            </div>

            <div class="col-md-4">
                <figcaption><!--             主要信息-->
                    <div id="picture">
                        <h2><?php echo $row['Title']?></h2>
                        <p class="author">
                            <?php
                            $sql = 'SELECT UserName FROM traveluser WHERE UID=' . $row['UID'];
                            $result2 = $pdo->query($sql);
                            while ($row2 = $result2->fetch()) {
                                echo $row2['UserName'];
                            }
                            ?>
                        </p>
                        <p class="like"><?php echo $row['Likes']; ?></p>
                        <p class="hate">7 不感兴趣</p>
                    </div>
                    <div>
                        <h2>图片详情</h2>
                        <p>主题：<?php echo $row['Content']; ?></p>
                        <p>国家：
                            <?php
                            $sql = 'SELECT CountryName FROM geocountries WHERE ISO="' . $row['CountryCodeISO'] . '"';
                            $result3 = $pdo->query($sql);
                            if ($row3 = $result3->fetch()) {
                                echo $row3['CountryName'];
                            }
                            else
                                echo '无'
                            ?>
                        </p>
                        <p>城市：
                            <?php
                            $sql = 'SELECT AsciiName FROM geocities WHERE GeoNameID="' . $row['CityCode'] . '"';
                            $result4 = $pdo->query($sql);
                            if ($row4 = $result4->fetch()) {
                                echo $row4['AsciiName'];
                            }
                            else
                                echo '无'
                            ?>
                        </p>
                    </div>

                    <div id="like-button">
                        <input type="button" name="like" value="喜欢" id="<?php echo $row['ImageID']?>">
                    </div>
                </figcaption>
            </div>
    </figure>

    <div class="row">
        <div class="description"><!--             文字描述-->
            <p><?php
                echo $row['Description'];
                }
                }
                catch (PDOException $e) {
                    die($e->getMessage());
                }
                ?>
            </p>
        </div>
    </div>



</section>

<footer><p>备案号：18307110426</p></footer>
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="../../bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="../js/ajaxLike.js"></script>

</body>
</html>
