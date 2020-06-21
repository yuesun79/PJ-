<?php
require_once('config.php');

try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pageSize = 8;
    $mark = ($_POST['page'] - 1) * $pageSize;

    if ($_POST['radio'] === 'titleSearch') {
        $sql = 'SELECT * FROM travelimage WHERE Title Like "%' . $_POST['sTitle'] . '%" LIMIT ' . $mark . ',' . $pageSize;
    }
    elseif ($_POST['radio'] === 'contentSearch') {
        $sql = 'SELECT * FROM travelimage WHERE Description Like "%' . $_POST['sContent'] . '%" LIMIT ' . $mark . ',' . $pageSize;
    }
    $result = $pdo->query($sql);
    while ($row = $result->fetch()) {
        echo '<figure>
        <a target="_Blank" href="detailPage.php?id=' . $row['ImageID'] . '"><img src="../../travel-images/medium/' . $row['PATH'] .'" alt="' . $row['Title'] . '"></a>
        <figcaption>
            <h2>' . $row['Title'] . '</h2>
            <p>' . $row['Description'] . '</p>
        </figcaption>
        </figure>';
    }
    $pdo = null;

}
catch (PDOException $e) {
    die($e->getMessage());
}

