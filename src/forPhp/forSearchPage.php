<?php
try {
    require_once('config.php');
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $page = array();
    if (isset($_POST['radio'])) {
        if (isset($_POST['sTitle']) && $_POST['radio'] === 'titleSearch') {
            $sql = 'SELECT * FROM travelimage WHERE Title Like "%' . $_POST['sTitle'] . '%"';
        }
        elseif (isset($_POST['sContent']) && $_POST['radio'] === 'contentSearch'){
            $sql = 'SELECT * FROM travelimage WHERE Description Like "%' . $_POST['sContent'] . '%"';
        }
        $result = $pdo->query($sql);

        if ($result) {
            $totalCount = $result->rowCount();
        }
        else
            $totalCount = 0;

        if ($totalCount === 0) {
            $page["totalPage"] = 0;
            echo "No result";
        }
        else {
            $pageSize = 8 ;
            $totalPage = (int)(($totalCount % $pageSize == 0) ? ($totalCount / $pageSize) : ($totalCount / $pageSize + 1));
            $page ["totalPage"]=$totalPage;
        }
    }
    else {
        $page["totalPage"] = 0;
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
}
catch (PDOException $e) {
    die($e->getMessage());
}
?>
