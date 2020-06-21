<?php
    session_start();
    require_once('config.php');
try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT UID FROM traveluser WHERE UserName ="' . $_SESSION['Username'] . '"';
    $author = ($pdo->query($sql))->fetch()?($pdo->query($sql))->fetch()['UID']:null;
    $sql = 'INSERT INTO travelimagefavor (UID, ImageID) VALUES (' . $author . ',' . $_POST['imageID'] . ')';
    $result = $pdo->exec($sql);
    if ($result) {
        $sql = 'SELECT Likes FROM travelimage WHERE ImageID =' . $_POST['imageID'];
        $likes = ($pdo->query($sql))->fetch()?($pdo->query($sql))->fetch()['Likes'] + 1:null;
        $sql = 'UPDATE travelimage SET Likes=' . $likes;
        $pdo->exec($sql);
    }
    $pdo = null;

}
catch (PDOException $e) {
    die(json_encode($e->getMessage()));
}