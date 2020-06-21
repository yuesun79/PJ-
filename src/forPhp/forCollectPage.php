<?php
session_start();
try {
    require_once('config.php');
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $page = array();
    $sql = 'SELECT UID FROM traveluser WHERE UserName="' . $_SESSION['Username'] . '"';
    $result = $pdo->query($sql);
    if ($row = $result->fetch()){
        $sql = 'SELECT * FROM travelimage WHERE UID=' . $row['UID'];
    }
    $result = $pdo->query($sql);
    if ($result) {
        $totalCount = $result->rowCount();
    } else
        $totalCount = 0;

    if ($totalCount === 0) {
        $page["totalPage"] = 0;
    } else {
        $pageSize = 8;
        $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));
        $page ["totalPage"] = $totalPage;
    }

    if ($page['totalPage'] !== 0) {
        if ($page['totalPage'] > 5)
            $displayPage = 6;
        else
            $displayPage = $page['totalPage'] + 1;
        for ($thisPage = 1; $thisPage < $displayPage; $thisPage++) {
            echo '<li><a href="#"';
            echo 'data-page="' . $thisPage . '"';
            echo '>' . $thisPage . '</a></li>';
        }
    }
    $pdo = null;
} catch (PDOException $e) {
    die($e->getMessage());
}
