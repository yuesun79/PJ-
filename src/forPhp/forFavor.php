<?php
session_start();
require_once('config.php');
try {
    $pageSize = 8;
    $mark = ($_POST['page'] - 1) * $pageSize;
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT DISTINCT travelimage.PATH,travelimage.Title,travelimage.Description,traveluser.UserName,traveluser.UID,travelimagefavor.ImageID FROM travelimage INNER JOIN (traveluser INNER JOIN travelimagefavor ON traveluser.UID=travelimagefavor.UID) ON travelimage.ImageID = travelimagefavor.ImageID WHERE traveluser.UserName="' . $_SESSION['Username'] . '" LIMIT ' . $mark . ',' . $pageSize;
    $result = $pdo->query($sql);
    if ($result->rowCount() === 0) echo '你还没有收藏的图片呐，到处看看吧～～';
    while ($row = $result->fetch()) {
        echo '<figure>
            <a href="detailPage.php?id=' . $row['ImageID'] . '"><img src="../../travel-images/medium/' . $row['PATH'] . '" alt="' . $row['Title'] . '"></a>
            <figcaption>
                <h2>' . $row['Title'] . '</h2>
                <p>' . $row['Description'] . '</p>
                <p><input class="button dislike" type="button" value="删除" onclick="cancelLike(' . $row['UID'] . ',' . $row['ImageID'] . ')"></p>
            </figcaption>
            </figure>';
    }
    $pdo = null;
} catch (PDOException $e) {
    die($e->getMessage());
}




