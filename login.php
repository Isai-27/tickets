<?php
session_start();
// error_reporting(0); // Comentado para mostrar los errores
error_reporting(E_ALL); // Muestra todos los errores durante el desarrollo
include("dbconnection.php");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $ret = mysqli_query($con, "SELECT * FROM user WHERE email='$email' and password='$password'");
    $num = mysqli_fetch_array($ret);

    if ($num > 0) {
        $_SESSION['login'] = $email;
        $_SESSION['id'] = $num['id'];
        $_SESSION['name'] = $num['name'];
        $logindate = date("Y/m/d");
        date_default_timezone_set("America/Guayaquil"); // Zona horaria para Manta, Ecuador
        $logintime = date("h:i:sa");
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $geopluginURL = 'http://www.geoplugin.net/php.gp?ip=' . $ip_address;
        $addrDetailsArr = @unserialize(file_get_contents($geopluginURL)); // Use @ para suprimir warnings

        $city = isset($addrDetailsArr['geoplugin_city']) ? $addrDetailsArr['geoplugin_city'] : '';
        $country = isset($addrDetailsArr['geoplugin_countryName']) ? $addrDetailsArr['geoplugin_countryName'] : '';

        $mac = ''; // Se deja la MAC en blanco por seguridad y fiabilidad

        $insert_log = mysqli_query($con, "INSERT INTO usercheck(logindate, logintime, user_id, username, email, ip, mac, city, country) VALUES('$logindate', '$logintime', '" . $_SESSION['id'] . "', '" . $_SESSION['name'] . "', '$email', '$ip_address', '$mac', '$city', '$country')");

        if ($insert_log) {
            $extra = "dashboard.php";
            echo "<script>window.location.href='" . $extra . "'</script>";
            exit();
        } else {
            // Error al insertar el registro de inicio de sesión
            $_SESSION['action1'] = "Error al registrar el inicio de sesión.";
            $extra = "login.php";
            echo "<script>window.location.href='" . $extra . "'</script>";
            exit();
        }
    } else {
        $_SESSION['action1'] = "Usuari@ o Contraseña Inválida";
        $extra = "login.php";
        echo "<script>window.location.href='" . $extra . "'</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Helix inicio-sesion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom-icon-set.css" rel="stylesheet" type="text/css" />

</head>

<body class="error-body no-top">
    <div class="container">
        <div class="row login-container">
            <div class="col-md-5">
                <h2 class="text-center text-white"><strong>Acceder al Sistema de Tickets</strong></h2>
                <hr style="border-color:#ebe7e7">
                <p class="text-center">
                    Aún no tienes cuenta <a href="registration.php">Regístrate aquí !!</a>
                </p>
            </div>
            <div class="col-md-5 "> <br>
                <p style="color:#F00"><?php echo $_SESSION['action1']; ?><?php echo $_SESSION['action1'] = ""; ?></p>
                <form id="login-form" class="login-form" action="" method="post">
                    <p style="color: #F00"><?php echo $_SESSION['action1']; ?><?php echo $_SESSION['action1'] = ""; ?></p>
                    <div class="form-group">
                        <label for="email" class="control-label">Correo</label>
                        <input type="text" class="form-control rounded-0" id="email" name="email" required="required">
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Contraseña</label>
                        <input type="password" class="form-control rounded-0" id="password" name="password" required="required">
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary btn-cons pull-right" name="login" type="submit">Acceder</button>
                    </div>
                </form>
            </div>


        </div>
    </div>
    <script src="assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="assets/js/login.js" type="text/javascript"></script>
</body>

</html>