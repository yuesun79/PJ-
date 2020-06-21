<?php
session_start();
require_once('config.php');
try {
    $pageSize = 8;
    $mark = ($_POST['page'] - 1) * $pageSize;
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT UID FROM traveluser WHERE UserName="' . $_SESSION['Username'] . '"';
    $result = $pdo->query($sql);
    if ($row = $result->fetch()) {
        $sql = 'SELECT * FROM travelimage WHERE UID=' . $row['UID'] . ' LIMIT ' . $mark . ',' . $pageSize;
        $result = $pdo->query($sql);
        if ($result->rowCount() === 0) echo '你还没有上传过图片诶，快来吧～～';
        while ($row = $result->fetch()) {
            echo '<figure>
            <a href="detailPage.php?id=' . $row['ImageID'] . '"><img src="../../travel-images/medium/' . $row['PATH'] . '" alt="' . $row['Title'] . '"></a>
            <figcaption>
                <h2>' . $row['Title'] . '</h2>
                <p>' . $row['Description'] . '</p>
                <p>
                    <input type="button" value="修改" class="another-button" onclick="window.location.href=\'' . 'upload.php?PATH=' . $row['PATH'] . '&imageID=' . $row['ImageID'] . '\'">
                    <input class="button dislike" type="button" value="删除" onclick="deleteImage(' . $row['UID'] . ',' . $row['ImageID'] . ')">
                </p>
            </figcaption>
            </figure>';
        }
    }

} catch (PDOException $e) {
    die($e->getMessage());
}


