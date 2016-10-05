<?php
    if($_SERVER['SERVER_ADDR'] == '103.31.250.117'){
        $dependencies='lib/dependencies-local.php';
    }  else {
        $dependencies='lib/dependencies-local.php';
    }

    require_once 'lib/dipandu.php';
    require_once $dependencies;
    
    $str_faculty=selectQueryDpd($dbname, "setup_faculty_list", "*", $conn, "ORDER BY `fak_short_name` ASC");
    $faculty_option.="<option value=''>Faculty Option</option>";
    while($res_faculty=mysql_fetch_assoc($str_faculty)){
        $faculty_option.="<option value='".$res_faculty['fak_id']."'>".$res_faculty['fak_short_name']." - ".$res_faculty['fak_display_name']."</option>";
    }
?>
<html>
    <head>
        <?php
        echo dependencies();
        ?>
        <meta charset="UTF-8">
        <title>DiPandu</title>
        
    </head>
    <body style="background-color: #3498db;">
        <div class="row">
        </div>
        <div class="row">
            <div class="col s10 offset-s1 m4 offset-m4 l4 offset-l4 login-container">
                <h5 class="center-align" style="color: #00695C !important;">Register Form</h5>
                <div class="col s12 m12 l12 input-field">
                    <select id="accountType" onchange="checkTeacher()">
                        <option value="" disabled selected>Account Type</option>
                        <option value="2">Student</option>
                        <option value="3">Teacher</option>
                    </select>   
                </div>
                <div class="col s12 m12 l12 input-field" id="fakCon">
                    <select id="faculty">
                        <?php
                            echo $faculty_option;
                        ?>
                    </select>   
                </div>
                <div class="col s12 m12 l12 input-field">
                    <input id="registration_number" type="text" class="validate" onchange="checkDouble('registration_number')">
                    <label for="registration_number">Registration Number</label>
                </div>
                <div class="col s12 m12 l12 input-field">
                    <input id="fullname" type="text" class="validate">
                    <label for="fullname">Full name</label>
                </div>
                <div class="col s12 m12 l12 input-field">
                    <input id="username" type="text" class="validate" onchange="checkDouble('username')">
                    <label for="username">Username</label>
                </div>
                <div class="col s12 m12 l12 input-field">
                    <input id="password" type="password" class="validate" onchange="passwordCheck()">
                    <label for="password">Password</label><br />
                    <i style="color: red; display: none !important;" id="passwordAlert">Password must be 8 characters or above!</i>
                </div>
                <div class="col s12 m12 l12 input-field">
                    <input id="passwordValidation" type="password" class="validate" onchange="passwordValidation()">
                    <label for="passwordValidation">Confirm Password</label><br />
                    <i style="color: red; display: none !important;" id="passwordValidationAlert">Password must be same as above!</i>
                </div>
                <div class="col s12 m12 l12 input-field">
                    <input id="email" type="email" class="validate" onchange="checkDouble('email')">
                    <label for="email">Email</label>
                </div>
                <div class="col s12 m12 l12">
                    <img id="captcha-img" src="captcha-generator.php" alt="Chaptcha" />
                </div>
                <div class="col s12 m12 l12 input-field">
                    <input id="captcha" type="password" class="validate">
                    <label for="capthca">Captcha Confirmation</label>
                </div>
                <div class="col s12 m12 l12 input-field center-align">
                    <button class="btn" onclick="runSignUp()">Sign Up</button>
                </div>
                <div class="col s12 m12 l12 input-field" id="iniya">
                    <p><a href="./"><i class="fa fa-caret-left"></i> Back to login page</a></p>
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
