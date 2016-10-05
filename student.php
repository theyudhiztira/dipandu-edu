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
        <title>DiPandu : <?php echo $_SESSION['core']['username']; ?></title>
    </head>
    <body style="background-color: #3D5AFE;">
        <?php
        navigation_bar();
        ?>
        <div class="row">
            <div class="col s6 m3 l3 drawer-container">
                <div class="drawer-box waves-effect waves-light" onclick="openFile('e-library')" style="background-color: #2ecc71;">
                    <i class="fa fa-book drawer-icon"></i><br />
                    <span class="drawer-caption">E-Library</span>
                </div>
            </div>  
            <div class="col s6 m3 l3 drawer-container">
                <div class="drawer-box waves-effect waves-light" onclick="openFile('student_schedule')" style="background-color: #e74c3c;">
                    <i class="fa fa-list drawer-icon"></i><br />
                    <span class="drawer-caption">Schedules</span>
                </div>
            </div>  
            <div class="col s6 m3 l3 drawer-container">
                <div class="drawer-box waves-effect waves-light" onclick="openFile('development')" style="background-color: #f1c40f;">
                    <i class="fa fa-line-chart drawer-icon"></i><br />
                    <span class="drawer-caption">Study Report</span>
                </div>
            </div>  
            <div class="col s6 m3 l3 drawer-container">
                <div class="drawer-box waves-effect waves-light" onclick="openFile('development')" style="background-color: #e67e22;">
                    <i class="fa fa-paperclip drawer-icon"></i><br />
                    <span class="drawer-caption">Task Cloud</span>
                </div>
            </div>  
        </div>
        <div class="row">
            <div class="col s12 m12 l12" style="color: #FFF;">
                <p>
                <h6>This app is under development progress. :)</h6>    
                <h6>Work In Progress :</h6>
                <ul>
                    <li><i class="fa fa-caret-right"></i> Online schedules ( with email notification if the teacher change their schedule )</li>
                    <li><i class="fa fa-caret-right"></i> Study report ( you can manage your score target and see the live report of your progress )</li>
                    <li><i class="fa fa-caret-right"></i> Task Cloud ( you can just upload all your homework here and your teacher will be able to read it faster! )</li>
                    <li><i class="fa fa-caret-right"></i> Application security</li>
                    <li><i class="fa fa-caret-right"></i> User control panel</li>
                    <li><i class="fa fa-caret-right"></i> Notification</li>
                    <li><i class="fa fa-caret-right"></i> Languages support ( this application will be come in Bahasa and English )</li>
                </ul>
                </p>
            </div> 
        </div>
        
        
    
     
    <?php
    echo javaScriptCall();
    ?>
    <script type='text/javascript' src='js/main-local.js'></script>       
    </body>
</html>
