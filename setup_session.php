<?php
    if($_SERVER['SERVER_ADDR'] == '103.31.250.117'){
        $dependencies='lib/dependencies-local.php';
    }  else {
        $dependencies='lib/dependencies-local.php';
    }

    require_once 'lib/dipandu.php';
    require_once $dependencies;
    
    session_check(1);
?>
<html>
    <head>
        <?php
        echo dependencies();
        ?>
        <meta charset="UTF-8">
        <title>DiPandu Smart > Setup Session : <?php echo $_SESSION['core']['username']; ?></title>
    </head>
    <body style="background-color: #3D5AFE;" onload="loadData()">
        <?php
        echo navigation_bar();
        ?>
        <div class="row">
            <div class="col s12 m12 l12">
                <a onclick="openFile('admin')" style="color: #FFF;"><b><i class="fa fa-caret-left"></i> Back To Home</b></a>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6">
                <div class="col s12 m12 l12 advanced-search-box" style="padding: 0px !important;">
                    <div class="col s12 m12 l12" style="background-color: #FF9800; color: #FFF; border-radius: 2.5px;">
                        <h5>Session Setup</h5>
                    </div>
                    <div class="col s12 m12 l12" style="margin-top: 10px;">
                        <div class="col s12 m12 l12">
                            <b style="font-size: 18px;">Time Start</b>
                        </div>
                        <div class="col s5 m5 l5 input-field">
                            <select id="start_hour">
                                <?php
                                    $optHour.="<option value='' disabled selected>Hours</option>";
                                    for($hour=1; $hour <= 24; $hour++){
                                        
                                        if(strlen($hour) <= 1){
                                            $resHour="0".$hour;
                                        }  else {
                                            $resHour=$hour;
                                        }
                                        
                                        $optHour.="<option value='".$resHour."'>".$resHour."</option>";
                                    }
                                    
                                    echo $optHour;
                                ?>
                            </select>
                        </div>   
                        <div class="col s1 m1 l1 input-field center-align" style="line-height: 33px; font-size: 33px; height: 33px;">
                            :
                        </div>
                        <div class="col s5 m5 l5 input-field">
                            <select id="start_minutes">
                                <?php
                                    $optMinute.="<option value='' disabled selected>Minutes</option>";
                                    for($minute=0; $minute <= 60; $minute++){
                                        
                                        if(strlen($minute) <= 1){
                                            $resMinute="0".$minute;
                                        }  else {
                                            $resMinute=$minute;
                                        }
                                        
                                        $optMinute.="<option value='".$resMinute."'>".$resMinute."</option>";
                                    }
                                    
                                    echo $optMinute;
                                ?>
                            </select>
                        </div> 
                        <div class="col s12 m12 l12">
                            <b style="font-size: 18px;">Time End</b>
                        </div>
                        <div class="col s5 m5 l5 input-field">
                            <select id="finish_hour">
                                <?php
                                    echo $optHour;
                                ?>
                            </select>
                        </div>   
                        <div class="col s1 m1 l1 input-field center-align" style="line-height: 33px; font-size: 33px; height: 33px;">
                            :
                        </div>
                        <div class="col s5 m5 l5 input-field">
                            <select id="finish_minutes">
                                <?php
                                    echo $optMinute;
                                ?>
                            </select>
                        </div> 
                        <div class="col s12 m6 l6 input-field" style="margin-bottom: 20px;">
                            <button id="addBtn" style="display: inline-block;" class="btn" onclick="addData()">Add</button>
                        </div> 
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l12">
                <table class="striped">
                    <thead class="table-head">
                        <tr>
                            <td style="max-width: 482px !important;">No.</td>
                            <td>Start Time</td>
                            <td>Finish Time</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody id="session-table">
                    </tbody>
                </table>
            </div>
        </div>
    <?php
    echo javaScriptCall();
    ?>
    <script type='text/javascript' src='js/main-local.js'></script>  
    <script type='text/javascript' src='js/setup_session.js'></script>  
    </body>
</html>
