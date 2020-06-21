<?php
header('content-type:application/json;charset=utf8');
require_once('config.php');
try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql1 = 'SELECT DISTINCT CountryName,ISO FROM geocountries';
    $jResult = array();
    $result = $pdo->query($sql1);
    while ($row = $result->fetch()) {
//        echo $row['CountryName'] . '  ';
//        $jResult[] = $row['CountryName'];
        $sql2 = 'SELECT AsciiName FROM geocities WHERE CountryCodeISO = "' . $row['ISO'] . '" AND Population > 200000';
        $result2 = $pdo->query($sql2);
        while ($row2 = $result2->fetch()) {
            $jResult[$row['CountryName']][] = $row2['AsciiName'];
        }
    }
    if ($jResult) {
        echo json_encode($jResult);
    }
    else {
        echo 'error';
    }
    $pdo = null;

}
catch (PDOException $e) {
    die($e->getMessage());
}
?>
