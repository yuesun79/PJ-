
<?php
    session_start();
    require_once('../forPhp/config.php');
    function validLogin(){
        $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
        //very simple (and insecure) check of valid credentials.
        $sql = 'SELECT * FROM traveluser WHERE UserName="' . $_POST['username'] . '"';
        $result = $pdo->query($sql);
        if($row = $result->fetch()){
            if (password_verify($_POST['password'], $row['Pass']))
                return true;
            else
                return false;
        }
        return false;
    }

?>

<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Welcome-Jupiter</title>
    <link rel="stylesheet" href="../styles/reset.css">
    <link rel="stylesheet" href="../styles/log-in.css">
</head>

<body>
    <div class="main-body">

        <div class="logo">
            <img src="../../images/icon/jupiter_logo.png" alt="jupiter-logo">
            <h3>welcome to the Jupiter</h3>
        </div>

        <div class="row">
            <a class="in" href="login.php">登陆</a>
            <a class="out" href="register.php">注册</a>
        </div>

        <section>
            <div class="input">
                <form action="#" method="post" name="form1">
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if(validLogin()){
                                // add 1 day to the current time for expiry time
                                $_SESSION['Username']=$_POST['username'];
                            }
                            else{
                                echo "<p id='tip' >   账号或密码不正确</p>";
                            }
                        }
                        if (isset($_SESSION['Username'])){
                            header("Location: ../../index.php");
                        }
                    ?>
                    <input type="text" name="username" required placeholder="用户名/常用邮箱登录" aria-placeholder="以字母开始的用户名">
                    <input type="password"  name="password" required placeholder="密码">
                    <input type="submit" value="登录" name="login">
                </form>
            </div>
        </section>

    </div>

    <footer>备案号：18307110426</footer>
</body>
</html>