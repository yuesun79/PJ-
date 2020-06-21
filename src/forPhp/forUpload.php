<?php
session_start();
require_once('config.php');
function get_file_name($len)//获取一串随机数字，用于做上传到数据库中文件的名字
{
    $new_file_name = '';
    $chars = "1234567890qwertyuiopasdfghjklzxcvbnm";//随机生成图片名
    for ($i = 0; $i < $len; $i++) {
        $new_file_name .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $new_file_name;
}

try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    extract($_POST); //extract() 函数从数组中将变量导入到当前的符号表。使用数组键名作为变量名，使用数组键值作为变量值。针对数组中的每个元素，将在当前符号表中创建对应的一个变量。

    $date = date('Y-m-d');
    $file_name = $_FILES['image']['name'];//获取缓存区图片,格式不能变 第一个参数是表单的 input name
    $type = array("jpg", "gif", 'png', 'bmp','jpeg');//允许选择的图片类型
    $ext = explode(".", $file_name);//拆分获取图片名
    $ext = $ext[count($ext) - 1];//取图片的后缀名
    if (in_array($ext,$type)){
        do{
            $new_name = get_file_name(6).'.'.$ext;//全是中文会报错
            $path='../../travel-images/medium/'.$new_name;//upload为目标文件夹
        }
        while (file_exists($path));//检查图片是否存在文件夹，存在返回ture,否则false
        $temp_file=$_FILES['image']['tmp_name'];//获取服务器里图片 存储在服务器的文件的临时副本的名称
        $sql = 'SELECT GeoNameID FROM geocities WHERE AsciiName ="' . $_POST['city'] . '"';
        $city = ($pdo->query($sql))->fetch()?($pdo->query($sql))->fetch()['GeoNameID']:null;
        $sql = 'SELECT ISO FROM geocountries WHERE CountryName ="' . $_POST['country'] . '"';
        $country = ($pdo->query($sql))->fetch()?($pdo->query($sql))->fetch()['ISO']:null;
        $sql = 'SELECT UID FROM traveluser WHERE UserName ="' . $_SESSION['Username'] . '"';
        $author = ($pdo->query($sql))->fetch()?($pdo->query($sql))->fetch()['UID']:null;
        if (!isset($_POST['ImageID'])) {
            $sql = 'INSERT INTO travelimage (Title, Description, CityCode, CountryCodeISO, UID, PATH, Content, Likes) VALUES ("' . $_POST['title'] . '","' . $_POST['description'] . '",' . $city . ',"' . $country . '",' . $author . ',"' . $new_name . '","' . $_POST['content'] . '",0)';
        }
        else {
            $sql = 'UPDATE travelimage SET Title="' . $_POST['title'] . '", Description="' . $_POST['description'] . '", Citycode =' . $city . ', CountryCodeISO="' . $country . '", PATH="' . $new_name . '", Content="' . $_POST['content'] . '", Likes=0 WHERE ImageID=' . $_POST['ImageID'];
        }
        $result = $pdo->exec($sql);
        if ($result){
            move_uploaded_file($temp_file,$path);//移动临时文件到目标路径
            $arr['flag'] = 1;
        }else{
            $arr['flag'] = 2;
        }
    }
    else{
        $arr['flag'] = 3;
    }

    echo json_encode($arr) . json_encode($_POST['title']);
    $pdo = null;

}
catch (PDOException $e) {
    die(json_encode($e->getMessage()));
}