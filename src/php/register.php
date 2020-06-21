
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Welcome Jupiter</title>
    <link rel="stylesheet" href="http://jqueryvalidation.org/files/demo/site-demos.css">
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
        <a class="out" href="login.php">登录</a>
        <a class="in" href="register.php">注册</a>
    </div>

    <section>
        <div class="input">
            <form action="#" method="post" name="registerForm" id="form">
                <?php
                require_once('../forPhp/config.php');
                require_once('../forPhp/PasswordHash.php');
                try {
                    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        $sql2 = "SELECT * FROM traveluser WHERE Email=:email";
                        $sql3 = "SELECT * FROM traveluser WHERE UserName=:user";

                        $statement1 = $pdo->prepare($sql2);
                        $statement1->bindValue(':email',$_POST['email']);
                        $statement1->execute();

                        $statement2 = $pdo->prepare($sql3);
                        $statement2->bindValue(':user',$_POST['username']);


                        if ($statement1->rowCount()>0 && $statement2->rowCount()>0) {
                            echo "此用户名和邮箱已经注册过账号";
                        }
                        elseif ($statement1->rowCount()>0) {
                            echo "此邮箱已经注册过账号";
                        }
                        elseif ($statement2->rowCount()>0) {
                            echo "此用户名已经被占用啦";
                        }
                        else {
                            $hashPass = password_hash($_POST['password'], PASSWORD_DEFAULT);

                            $sql1 = 'INSERT INTO traveluser SET Email="' . $_POST['email'] . '", UserName="' . $_POST['username'] .'", Pass="' . $hashPass . '"';
                            $statement2->execute();
                            $count = $pdo->exec($sql1);
                        }

                        if ($count === 1) {
                            echo '注册成功';
                            header("Location:login.php");
                        }
                        else {
                            echo '发生了一些事情！';
                        }
                    }
                    $pdo = null;
                }
                catch (PDOException $e) {
                    die($e->getMessage());
                } catch (Exception $e) {
                }
                ?>
                <input type="text" name="username" id="user" required placeholder="用户名">
                <input type="email" name="email" id="email" required placeholder="E-mail">
                <input type="password"  name="password" id="password" required placeholder="密码">
                <input type="password" class="left" name="password_again" id="password_again" required placeholder="重新输入密码">
                <p id="tip"></p>
                <input type="submit" value="注册" name="register" id="submit">
            </form>
        </div>
    </section>

</div>

<footer>备案号：18307110426</footer>
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<script src="../jsForValid/register.js"></script>
</body>
</html>
