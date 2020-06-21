<?php
require_once('config.php');
try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT GeoNameID,CountryCodeISO FROM geocities WHERE AsciiName="' . $_POST['city'] . '"';
    $country = ($pdo->query($sql))->fetch()?($pdo->query($sql))->fetch()['CountryCodeISO']:null;
    $city = ($pdo->query($sql))->fetch()?($pdo->query($sql))->fetch()['GeoNameID']:null;
    $sql = 'SELECT * FROM travelimage WHERE Content="' . $_POST['content'] .'" AND CountryCodeISO="' . $country . '" AND CityCode=' . $city;
    $result = $pdo->query($sql);
    while ($row = $result->fetch()) {
        echo '
            <figure>
                <a href="detailPage.php?id=' . $row['ImageID'] . '" target="_Blank"><img src="../../travel-images/medium/' . $row['PATH'] . '" alt="' . $row['Title'] . '"></a>
                <figcaption></figcaption>
            </figure>
        ';
    }
    $pdo = null;

}
catch (PDOException $e) {
    die($e->getMessage());
}
