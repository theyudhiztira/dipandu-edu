<?php
    if($_SERVER['SERVER_ADDR'] == '103.31.250.117'){
        $dependencies='lib/dependencies-local.php';
    }  else {
        $dependencies='lib/dependencies-local.php';
    }

    require_once 'lib/dipandu.php';
    require_once $dependencies;
    
    session_check(2);
?>
<html>
    <head>
        <?php
        echo dependencies();
        ?>
        <meta charset="UTF-8">
        <title>DiPandu > E-Library : <?php echo $_SESSION['core']['username']; ?></title>
    </head>
    <body style="background-color: #3D5AFE;">
        <?php
        echo navigation_bar();
        ?>
        <div class="row">
            <div class="col s12 m12 l12">
                <a href="student/" style="color: #FFF;"><b><i class="fa fa-caret-left"></i> Back To Home</b></a>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l12 center-align center-block center">
                <h1 class="h1" style="color: #FFF;">Hi, we are under development progress</h1>
                <h5 class="h5" style="color: #FFF;">I'm working hard to build this application.</h5>
                <h5 class="h5" style="color: #FFF;">If you feel helped with my application you can send me a bit cents for our server cost.</h5>
                <h6 class="h6" style="color: #FFF;">BNI : 400386283 A.N Pandu Yudhistira</h6>
                <h6 class="h6" style="color: #FFF;">MANDIRI : 1290010609036 A.N Pandu Yudhistira</h6>
            </div>
        </div>
    <?php
    echo javaScriptCall();
    ?>
    <script type='text/javascript' src='js/main-local.js'></script>       
    </body>
</html>
