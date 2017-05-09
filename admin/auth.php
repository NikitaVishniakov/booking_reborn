<?php 
//    session_start();
    include("funcs.php");
    if(isset($_SESSION['id'])){
        header("location:index.php");
    }
    else{
        if(isset($_POST['submit'])) {
            auth($_POST['login'],$_POST['pass']);
        }
    }
    if(!isset($_SESSION['error'])){
        $_SESSION['error'] = "";
    }
?>
<!DOCTYPE html>
<html lang="RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в административную панель</title>
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/css/login.css?12">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
    
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 logo">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4 form-box">
                <form class="form" method="post" action="#" name="login">
                    <?php echo "<p class='error'>{$_SESSION['error']}</p>"; ?>
                    <div class="form-group col-md-6 col-md-offset-3">
                        <label class="text-center" for="login">Введите логин:</label>
                        <input type="text" class="form-control" name="login" id="login" required>
                    </div>  
                    <div class="form-group col-md-6 col-md-offset-3">
                        <label for="pass">Введите пароль:</label>
                        <input type="password" class="form-control" name="pass" id="pass" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="col-md-offset-4 col-md-4 col-xs-10 col-xs-offset-1    btn btn-choco" value="Вход" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
