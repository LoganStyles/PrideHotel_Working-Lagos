<?php
if (isset($_SESSION['us_signature'])) {
    $redirect = "app";
    redirect($redirect);
}

extract($received[0]);

$site_id = $site[0]["ID"];
$site_title = $site[0]["title"];
$site_logo=$received_image="";
if (!empty($site[0]["logo"])) {
    $received_image = base_url() . 'images/UPLOADS/' . $site[0]["logo"];
    $site_logo = "<img style=\"height:40px;max-width:100%;\" src=\"$received_image\" alt=\"Hotel Software logo\" >";    
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="#" type="image/png">

        <title><?php echo $site_title; ?> | Login</title>

        <!--common-->
        <link href="<?php echo base_url(); ?>css_admin/style.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>css_admin/style-responsive.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>fonts/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" href="<?php echo $received_image; ?>" type="image/png"/>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="login-body">
        <div class="container">
            <?php
            $attributes = array('class' => 'form-signin', 'id' => 'save_login');
            echo form_open('app/login/user', $attributes);
            ?>
            <div class="form-signin-heading text-center">
                <h1 class="sign-title">Log In</h1>
                <?php
                echo $site_logo;
                ?>
            </div>
            <div class="login-wrap">
                <?php
                if ($login_error) {
                    $danger_style = "alert alert-danger error";
                } else {
                    $danger_style = "";
                }
                echo validation_errors('<span>***</span><span class="error">', '</span><span>***</span><br>');
                echo '<div class="' . $danger_style . '">' . $login_error . '</div>';
                ?>
                <input name="login_signature" type="text" class="form-control" placeholder="Username" value="<?php echo $signature; ?>" autofocus>
                <input name="login_password" type="password" class="form-control" placeholder="Password" value="<?php echo $password; ?>">

                <input class="btn btn-lg btn-login btn-block" type="submit" name="submit" value="Login" />

            </div>
            <div style="margin-left: 2%;color: #FF4545;"><?php echo $expiration;?></div>

        </form>
        <footer style="text-align: center">
            &copy; <?php echo date('Y'); ?>  Powered by <a href="http://webmobiles.com.ng/" target="_blank" >Webmobiles IT Services Ltd</a>
            &nbsp;&nbsp;&nbsp;&nbsp;<span>Enquiries/Complaints: Magnus (0808 369 9918),Emmanuel(0818 987 6324)</span>
        </footer>

    </div>
    <!-- Placed js at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>js_admin/jquery-1.10.2.min.js"></script>
    <script src="<?php echo base_url(); ?>js_admin/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>js_admin/modernizr.min.js"></script>

    <!--icheck -->
    <script src="<?php echo base_url(); ?>js_admin/iCheck/jquery.icheck.js"></script>
    <script src="<?php echo base_url(); ?>js_admin/icheck-init.js"></script>
</body>
</html>

