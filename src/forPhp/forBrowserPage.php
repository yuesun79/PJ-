<?php
require_once('config.php');
try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT GeoNameID,CountryCodeISO FROM geocities WHERE AsciiName="' . $_POST['city'] . '"';
    $country = ($pdo->query($sql))->fetch()?($pdo->query($sql))->fetch()['CountryCodeISO']:null;
    $city = ($pdo->query($sql))->fetch()?($pdo->query($sql))->fetch()['GeoNameID']:null;
    $sql = 'SELECT * FROM travelimage WHERE Content="' . $_POST['content'] .'" AND CountryCodeISO="' . $country . '" AND CityCode=' . $city . ' ORDER BY Likes DESC';
    $result = $pdo->query($sql);
    if ($result) {
        $totalCount = $result->rowCount();
    } else
        $totalCount = 0;

    if ($totalCount === 0) {
        $page["totalPage"] = 0;
    } else {
        $pageSize = 16;
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

}
catch (PDOException $e) {
    die($e->getMessage());
}