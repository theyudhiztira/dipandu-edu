<?php
    if($_SERVER['SERVER_ADDR'] == '103.31.250.117'){
        $dependencies='lib/dependencies-local.php';
    }  else {
        $dependencies='lib/dependencies-local.php';
    }

    require_once 'lib/dipandu.php';
    require_once $dependencies;
    
    session_start();
    
    session_check();
    
//    echo $_SESSION['core']['username'];
?>
<html>
    <head>
        <?php
        echo dependencies();
        ?>
        <meta charset="UTF-8">
        <title>DiPandu : <?php echo $_SESSION['core']['username']; ?></title>
    </head>
    <body style="background-color: #3498db;">
        <div class="row" style="margin-bottom: 50px;">
            <nav class="navigation-bar">
                <div class="nav-wrapper">
                    <a class="brand-logo home-title">DiPandu</a>
                    <a data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <li><a><?php echo $_SESSION['core']['username']; ?> <i class="fa fa-cogs"></i></a></li>
                        <li><a><i class="fa fa-bell"></i> <span class="new badge red">4</span></a></li>
                        <li><a>Logout <i class="fa fa-lock"></i></a></li>
                    </ul>
                    <ul class="side-nav" id="mobile-demo">
                        <li><a href="sass.html">User Settings</a></li>
                        <li><a href="badges.html">Notifications <span class="new badge red">4</span></a></li>
                        <li><a>Logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="row">
            <div class="col s6 m3 l3 drawer-container">
                <div class="drawer-box waves-effect waves-light" onclick="openFile('e-library')" style="background-color: #2ecc71;">
                    <i class="fa fa-book drawer-icon"></i><br />
                    <span class="drawer-caption">E-Library</span>
                </div>
            </div>  
            <div class="col s6 m3 l3 drawer-container">
                <div class="drawer-box waves-effect waves-light" style="background-color: #e74c3c;">
                    <i class="fa fa-list drawer-icon"></i><br />
                    <span class="drawer-caption">Schedules</span>
                </div>
            </div>  
            <div class="col s6 m3 l3 drawer-container">
                <div class="drawer-box waves-effect waves-light" style="background-color: #f1c40f;">
                    <i class="fa fa-line-chart drawer-icon"></i><br />
                    <span class="drawer-caption">Score Report</span>
                </div>
            </div>  
            <div class="col s6 m3 l3 drawer-container">
                <div class="drawer-box waves-effect waves-light" style="background-color: #e67e22;">
                    <i class="fa fa-paperclip drawer-icon"></i><br />
                    <span class="drawer-caption">Task Cloud</span>
                </div>
            </div>  
        </div>
        
        
    
     
    <?php
    echo javaScriptCall();
    ?>
    <script type='text/javascript' src='js/main-local.js'></script>       
    </body>
</html>
