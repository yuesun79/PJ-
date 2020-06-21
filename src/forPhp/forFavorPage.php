<?php
session_start();
try {
    require_once('config.php');
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $page = array();
    $sql = 'SELECT DISTINCT travelimage.PATH,travelimage.Title,travelimage.Description,traveluser.UserName,traveluser.UID,travelimagefavor.ImageID FROM travelimage INNER JOIN (traveluser INNER JOIN travelimagefavor ON traveluser.UID=travelimagefavor.UID) ON travelimage.ImageID = travelimagefavor.ImageID WHERE traveluser.UserName="' . $_SESSION['Username'] . '"';
    $result = $pdo->query($sql);
    if ($result) {
        $totalCount = $result->rowCount();
    }
    else
        $totalCount = 0;

    if ($totalCount === 0) {
        $page["totalPage"] = 0;
    }
    else {
        $pageSize = 8 ;
        $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));
        $page ["totalPage"]=$totalPage;
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
