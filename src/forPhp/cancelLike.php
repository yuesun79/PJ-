<?php

require_once('config.php');
try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'DELETE FROM travelimagefavor WHERE UID=' . intval($_POST['user']) . ' and ImageID=' . intval($_POST['imageID']);
    $result = $pdo->query($sql);
    $sql = 'SELECT DISTINCT travelimage.PATH,travelimage.Title,travelimage.Description,traveluser.UserName,traveluser.UID,travelimagefavor.ImageID FROM travelimage INNER JOIN (traveluser INNER JOIN travelimagefavor ON traveluser.UID=travelimagefavor.UID) ON travelimage.ImageID = travelimagefavor.ImageID WHERE traveluser.UID="' . intval($_POST['user']) . '"';
    $result = $pdo->query($sql);
    if ($result->rowCount() === 0) echo '～～';

    while ($row = $result->fetch()) {
//            echo $row['PATH'].$row['Title'].$row['Description'].$row['UserName'].$row['ImageID'];
        echo '<figure>
            <a href="detailPage.php?id=' . $row['ImageID'] . '"><img src="../../travel-images/medium/' . $row['PATH'] .'" alt="' . $row['Title'] . '"></a>
            <figcaption>
                <h2>' . $row['Title'] . '</h2>
                <p>' . $row['Description'] . '</p>
                <p><input class="button" type="button" id="dislike" value="删除" data-user="' . $row['UserName'] . '" data-image-id="' . $row['ImageID'] . '" onclick="cancelLike('. $row['UID'] . ',' . $row['ImageID'] . ')"></p>
            </figcaption>
            </figure>';
    }
    $pdo = null;
}
catch (PDOException $e) {
    die($e->getMessage());
}
?>
