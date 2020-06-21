<?php
require_once('config.php');
try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'DELETE FROM travelimage WHERE ImageID=' . intval($_POST['deleteID']);
    $result = $pdo->query($sql);
    $sql = 'DELETE FROM travelimagefavor WHERE ImageID=' . intval($_POST['deleteID']);
    $result = $pdo->query($sql);

        $sql = 'SELECT * FROM travelimage WHERE UID=' . intval($_POST['userUID']);
        $result = $pdo->query($sql);
        if ($result->rowCount() === 0) echo '你还没有上传过图片诶，快来';
        while ($row = $result->fetch()) {
            echo '<figure>
            <a href="detailPage.php?id=' . $row['ImageID'] . '"><img src="../../travel-images/medium/' . $row['PATH'] .'" alt="' . $row['Title'] . '"></a>
            <figcaption>
                <h2>' . $row['Title'] . '</h2>
                <p>' . $row['Description'] . '</p>
                <p>
                    <input type="button" value="修改" class="another-button" onclick="alert(\'oops暂时不支持修改\')">
                    <input class="button dislike" type="button" value="删除" onclick="deleteImage('. $row['UID'] . ',' . $row['ImageID'] . ')">
                </p>
            </figcaption>
            </figure>';
        }

    $pdo = null;
}
catch (PDOException $e) {
    die($e->getMessage());
}
?>
