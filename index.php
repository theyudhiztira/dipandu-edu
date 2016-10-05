<?php
    if($_SERVER['SERVER_ADDR'] == '103.31.250.117'){
        $dependencies='lib/dependencies-local.php';
    }  else {
        $dependencies='lib/dependencies-local.php';
    }

    require_once 'lib/dipandu.php';
    require_once $dependencies;
    
    session_start();
    
    if(!empty($_SESSION['core'])){
        if($_SESSION['core']['account_type'] == '1'){
            echo "<script>
            location.replace('./admin.php');
            </script>";
        }
        
        if($_SESSION['core']['account_type'] == '2'){
            echo "<script>
            location.replace('./student.php');
            </script>";
        }
        
        if($_SESSION['core']['account_type'] == '3'){
            echo "<script>
            location.replace('./teacher.php');
            </script>";
        }
    }
?>
<html>
    <head>
        <?php
        echo dependencies();
        ?>
        <meta charset="UTF-8">
        <title>DiPandu Smart : Login Page</title>
        
    </head>
    <body style="background-color: #3498db;">
        <div class="row">
            <div class="col s12 m12 l12 center-align home-title" onclick="openFile('home')">
                <h3>DiPandu</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s10 offset-s1 m4 offset-m4 l4 offset-l4 login-container">
                <h5 class="center-align" style="color: #00695C !important;">Login</h5>
                <div class="col s12 m12 l12 input-field">
                    <input id="username" type="text" class="validate">
                    <label for="username">Username</label>
                </div>
                <div class="col s12 m12 l12 input-field">
                    <input id="password" type="password" class="validate">
                    <label for="password">Password</label><br />
                    <b style="color: red; display: inline-block;" id="passwordValidationAlert"></b>
                </div>
                
                <div class="col s12 m12 l12 input-field">
                    <select id="accountType">
                        <option value="" disabled selected>Login as :</option>
                        <option value="1">Administrator</option>
                        <option value="2">Student</option>
                        <option value="3">Teacher</option>
                    </select>   
                    <label>Account Type</label>
                </div>
                <div class="col s12 m12 l12 input-field center-align">
                    <button class="btn" onclick="doLogin()">Login</button>
                </div>
                <div class="col s12 m12 l12 input-field">
                    <p>Don't have an account? <a href="sign-up.php" title="Register">CLICK HERE!</a></p>
                </div>
            </div>
        </div>
        
        
    
    <script type='text/javascript' src='js/outside.js'></script>   
    <?php
    echo javaScriptCall();
    ?>    
    <script type='text/javascript' src='js/main-local.js'></script> 
    </body>
</html>
