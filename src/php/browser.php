<?php
    require_once('../forPhp/config.php');
    $index = 'Likes';
    /*
     在左栏按图片数量排序内容类
     */
    function outputContent() {
        try {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT Content, count(ImageID) AS NcontentPic FROM travelimage GROUP BY Content ORDER BY NcontentPic DESC";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()) {

                    echo '<a href="' . $_SERVER["SCRIPT_NAME"] . '?id=' . $row['Content'] . '" >';
                    if (isset($_GET['id']) && $_GET['id'] == $row['Content']) {
                        $GLOBALS['index'] = 'Content';
                    }
                    echo $row['Content'] . '</a>';
            }
            $pdo = null;

        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    /*
    在左栏选拥有图片数量最多的五个国家
    */
    function outputCountry() {
        try {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql1 = "SELECT CountryCodeISO, count(ImageID) AS NcountryPic FROM travelimage GROUP BY CountryCodeISO ORDER BY NcountryPic DESC LIMIT 0,5";
            $result1 = $pdo->query($sql1);

            while ($row1 = $result1->fetch()) {
                if (isset($row1['CountryCodeISO'])) {
                    global $record;
                    $sql2 = 'SELECT CountryName FROM geocountries WHERE ISO="' . $row1['CountryCodeISO'] . '"';
                    $result2 = $pdo->query($sql2);
                    $row2 = $result2->fetch();
                    echo '<a href="' . $_SERVER["SCRIPT_NAME"] . '?id=' . $row1['CountryCodeISO'] . '" >';
                    if (isset($_GET['id']) && $_GET['id'] == $row1['CountryCodeISO']) {
                        $GLOBALS['index'] = 'CountryCodeISO';
                    }
                    echo $row2['CountryName'] . '</a>';
                }
            }
            $pdo = null;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    /*
     在左栏选拥有图片数量最多的五个城市
     */
    function outputCity() {
        try {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $record = 0;
            $sql1 = "SELECT CityCode, count(ImageID) AS NcityPic FROM travelimage GROUP BY CityCode ORDER BY NcityPic DESC LIMIT 0,6";
            $result1 = $pdo->query($sql1);
            while ($row1 = $result1->fetch()) {
                if (isset($row1['CityCode']) && $record < 5) {
                    global $record;
                    $sql2 = 'SELECT AsciiName FROM geocities WHERE GeoNameID="' . $row1['CityCode'] . '"';
                    $result2 = $pdo->query($sql2);
                    $row2 = $result2->fetch();
                    echo '<a href="' . $_SERVER["SCRIPT_NAME"] . '?id=' .$row1['CityCode'] . '" >';
                    if (isset($_GET['id']) && $_GET['id'] == $row1['CityCode']) {
                        $GLOBALS['index'] = 'CityCode';
                    }
                    echo $row2['AsciiName'] . '</a>';
                    $record++;
                }
            }
            $pdo = null;

        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    /*
     根据左栏的点击筛选右栏的图片
     */
    function outputPics($index) {
        try {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (isset($_POST['titleSearch']) || isset($_GET['title'])) {
                if (isset($_POST['titleSearch']))
                    $sql = 'SELECT * FROM travelimage WHERE Title Like "%' . $_POST['titleSearch'] . '%"';
                else
                    $sql = 'SELECT * FROM travelimage WHERE Title Like "%' . $_GET['title'] . '%"';
            }
            elseif (isset($_GET['id'])) {
                $sql = 'SELECT * FROM travelimage WHERE ' . $index . '="' . $_GET['id'] . '" ORDER BY Likes DESC';
            }

            else {
                $sql = 'SELECT * FROM travelimage ORDER BY Likes DESC';
            }
            $result = $pdo->query($sql);
            if ($result) {
                $totalCount = $result->rowCount();
            }
            else
                $totalCount = 0;
            if ($totalCount === 0) {
                $page = array("totalPage"=>$totalCount);
                echo "No result";
            }

            else {
                $pageSize = 16;
                $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));
                if (!isset($_GET['page']))
                    $currentPage = 1;
                else
                    $currentPage = $_GET['page'];
                $mark = ($currentPage - 1) * $pageSize;
                $prePage = ($currentPage > 1) ? $currentPage - 1 : 1;
                $nextPage = ($totalPage - $currentPage > 0) ? $currentPage + 1 : $totalPage;
                if (isset($_POST['titleSearch']) || isset($_GET['title'])) {
//                    echo 2;
                    if (isset($_POST['titleSearch']))
                        $sql = 'SELECT * FROM travelimage WHERE Title Like "%' . $_POST['titleSearch'] . '%"';
                    else
                        $sql = 'SELECT * FROM travelimage WHERE Title Like "%' . $_GET['title'] . '%"';
                }
                elseif (isset($_GET['id'])) {
                    $sql = 'SELECT * FROM travelimage WHERE ' . $index . '="' . $_GET['id'] . '" ORDER BY Likes DESC LIMIT ' . $mark . "," . $pageSize;
                }

                else {
                    $sql = 'SELECT * FROM travelimage ORDER BY Likes DESC LIMIT ' . $mark . "," . $pageSize;
                }
                $result = $pdo->query($sql);
                while ($row = $result->fetch()) {
                    outputPic($row);
                }
                $page = array("prePage"=>$prePage,"nextPage"=>$nextPage,"currentPage"=>$currentPage,"totalPage"=>$totalPage);
            }

            if (isset($_POST['titleSearch'])) {
                $page['titleSearch'] = $_POST['titleSearch'];
            }
            if (isset($_GET['id'])) {
                $page['id'] = $_GET['id'];
            }
            $pdo = null;
            return $page;
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /*
     输出一个图片的html
     */
    function outputPic($row) {
        echo '
            <figure>
                <a href="detailPage.php?id=' . $row['ImageID'] . '" target="_Blank"><img src="../../travel-images/medium/' . $row['PATH'] . '" alt="' . $row['Title'] . '"></a>
                <figcaption></figcaption>
            </figure>
        ';
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
    <title>Jupiter-Browser</title>
    <link href="../../bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/browser.css">
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
                <li class="active"><a href="browser.php">浏览</a></li>
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
                        <li><a href="login.php">登陆</a></li>
            </ul>';
            }
            ?>
        </div>
    </div>
</nav>

<section>
    <aside><!--             侧边栏-->

        <div class="search-bar"><!--             搜索-->
            <form method="post" name="form1">
                <div class="input-group">
                    <input type="text" class="form-control" name="titleSearch" placeholder="标题搜索" autocomplete="off">
                    <span class="input-group-btn">
                        <input class="btn btn-default" type="submit">Go!</input>
                    </span>
                </div>
            </form>
        </div>

        <div class="small-screen">
            <div class="hot-thing"><!--             热门展示-->
                <div>
                    <a class="first-hot">热门内容<img class="tip" src="../../images/icon/三角右.png" alt="图标"></a>
                </div>
                <?php outputContent();?>
            </div>

            <div class="hot-thing">
                <div>
                    <a class="second-hot">热门国家<img class="tip" src="../../images/icon/三角右.png" alt="图标"></a>
                </div>
                <?php outputCountry(); ?>
            </div>

            <div class="hot-thing">
                <div>
                    <a class="third-hot">热门城市<img class="tip" src="../../images/icon/三角右.png" alt="图标"></a>
                </div>
                <?php outputCity(); ?>
            </div>
        </div>

    </aside>

    <div class="browser-content"><!--             右侧浏览部分-->
        <?php
        try {
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
        ?>

        <div class="filter"><!--             筛选-->
            <form name="form" method="post" id="form">
                <select name="content" id="contect">
                    <option value="scenery">scenery</option>
                    <option value="city">city</option>
                    <option value="people">people</option>
                    <option value="animal">animal</option>
                    <option value="building">building</option>
                    <option value="wonder">wonder</option>
                    <option value="other">other</option>
                </select>

                <select name="country" id="country"></select>

                <select name="city" id="city"></select>

                <input type="submit" name="go" value="搜索">
            </form>
        </div>

        <div class="hot-figures" id="txtHint">
            <?php
                $page = outputPics($index);
            ?>
        </div>

        <div class="page">

            <ul class="pagination" id="page">

                <li><a href="<?php echo $_SERVER["SCRIPT_NAME"];
                if (isset($page['PrePage'])) { echo '?page=' . $page['prePage'];}
                if (isset($page['id'])) {echo '&id=' . $page['id'];}
                if (isset($page['titleSearch'])) {echo '&title=' . $page['titleSearch'];}?>"><<</a></li>
                <?php
                if ($page['totalPage'] === 0) {
                    echo '<li>   </li>';
                }
                else{
                    if ($page['totalPage'] > 5)
                        $displayPage = 6;
                    else
                        $displayPage = $page['totalPage'] + 1;
                    for ($thisPage = 1; $thisPage < $displayPage; $thisPage++) {
                        echo '<li><a href="' . $_SERVER["SCRIPT_NAME"] . '?page=' . $thisPage;
                        if (isset($page['id'])) {echo '&id=' . $page['id'];}
                        if (isset($page['titleSearch'])) {echo '&title=' . $page['titleSearch'];}
                        echo '">' . $thisPage . '</a></li>';
                    }
                }
                ?>
                <li><a href="<?php echo $_SERVER["SCRIPT_NAME"];
                if (isset($page['nextPage'])) { echo '?page=' . $page['nextPage'];}
                if (isset($page['id'])) {echo '&id=' . $page['id'];
                if (isset($page['titleSearch'])) {echo '&title=' . $page['titleSearch'];}} ?>">>></a></li>
            </ul>


        </div>
    </div>

</section>

<footer><p>备案号：18307110426</p></footer>
<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
<script src="../../bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script src="../js/ajaxSelector.js"></script>
<script src="../js/ajaxBrowser.js"></script>
<script src="../js/ajaxBrowserPage.js"></script>
</body>
</html>
