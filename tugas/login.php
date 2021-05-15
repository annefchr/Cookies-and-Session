<?php 
session_start();

//atur koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$nama = "login";
$conn = mysqli_connect($host,$user,$pass,$nama);
//atur variabel
$error = "";
$username = "";
$ingataku = "";

if(isset($_COOKIE['cookie_username'])){
    $cookie_username = $_COOKIE['cookie_username'];
    $cookie_password = $_COOKIE['cookie_password'];

    $var = "select * from login where username = '$cookie_username'";
    $query = mysqli_query($conn,$var);
    $r = mysqli_fetch_array($query);
    if($r['password'] == $cookie_password){
        $_SESSION['session_username'] = $cookie_username;
        $_SESSION['session_password'] = $cookie_password;
    }
}

if(isset($_SESSION['session_username'])){
    header("location:anggota.php");
    exit();
}

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $ingataku = $_POST['ingataku'];

    if($username == '' or $password == ''){
        echo "Silakan masukkan username dan juga password.";
    }else{
        $var = "select * from login where username = '$username'";
        $query   = mysqli_query($conn,$var);
        $r   = mysqli_fetch_array($query);

        if($r['username'] == ''){
            echo "Username tidak tersedia.";
        }elseif($r['password'] != md5($password)){
            echo "Password yang dimasukkan tidak sesuai.";
        }       
        
        if(empty($error)){
            $_SESSION['session_username'] = $username; //server
            $_SESSION['session_password'] = md5($password);

            if($ingataku == 1){
                $cookie_name = "cookie_username";
                $cookie_value = $username;
                $cookie_time = time() + (60 * 60 * 24 * 30);
                setcookie($cookie_name,$cookie_value,$cookie_time,"/");

                $cookie_name = "cookie_password";
                $cookie_value = md5($password);
                $cookie_time = time() + (60 * 60 * 24 * 30);
                setcookie($cookie_name,$cookie_value,$cookie_time,"/");
            }
            header("location:anggota.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style type="text/css">
        .box-1{
            text-align: center;
            margin-top: 100px;
        }
        .img1{
            margin-top: 20px;
            width: 150px;
        }
        .panel-title{
            font-size: 30px;
        }
        .panel-body{
            padding-top: 20px;
        }
        .input-group{
            margin-bottom: 25px;
        }
        .form-group{
            margin-top: 10px;
        }
    </style>
    
<body>
<div class="box-1">    
    <div id="loginbox">                    
        <div class="panel panel-info" >
            <div class="panel-heading">
                <div class="panel-title">Welcome to Our Page. <br> Please Login.</div>
                <img class="img1" src="role-model.png">
            </div>      
            <div class="panel-body" >
                <?php if($error){ ?>
                    <div id="login-alert">
                        <ul><?php echo $error ?></ul>
                    </div>
                <?php } ?>                
                <form id="loginform" class="form-horizontal" action="" method="post" role="form">       
                    <div class="input-group">
                        <input id="login-username" type="text" class="form-control" name="username" value="<?php echo $username ?>" placeholder="username">                                        
                    </div>
                    <div class="input-group">
                        <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                    </div>
                    <div class="input-group">
                        <div class="checkbox">
                        <label>
                            <input id="login-remember" type="checkbox" name="ingataku" value="1" <?php if($ingataku == '1') echo "checked"?>> Remember me
                        </label>
                        </div>
                    </div>
                    <div class="form-group">
                            <input type="submit" name="login" class="btn btn-success" value="Login"/>
                        </div>
                    </div>
                </form>    
            </div>                     
        </div>  
    </div>
</div>
</body>
</html>