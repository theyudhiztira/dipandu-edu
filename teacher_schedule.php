<?php
    if($_SERVER['SERVER_ADDR'] == '103.31.250.117'){
        $dependencies='lib/dependencies-local.php';
    }  else {
        $dependencies='lib/dependencies-local.php';
    }

    require_once 'lib/dipandu.php';
    require_once $dependencies;
    
    $str_teacher=selectQueryDpd($dbname, "core_user", "*", $conn, "where level = '3'");
    $teacher_option.="<option value=''>Teacher Option</option>";
    while($res_teachers_name=mysql_fetch_assoc($str_teacher)){
        $teacher_option.="<option value='".$res_teachers_name['registration_number']."'>".$res_teachers_name['fullname']."</option>";
    }
    
    $str_faculty=selectQueryDpd($dbname, "setup_faculty_list", "*", $conn, "ORDER BY `fak_short_name` ASC");
    $faculty_option.="<option value=''>Faculty Option</option>";
    while($res_faculty=mysql_fetch_assoc($str_faculty)){
        $faculty_option.="<option value='".$res_faculty['fak_id']."'>".$res_faculty['fak_short_name']." - ".$res_faculty['fak_display_name']."</option>";
    }

    $str_session=selectQueryDpd($dbname, "setup_schedule_session", "*", $conn, "ORDER BY `ses_start` ASC");
    $session_option.="<option value=''>Session  Option</option>";
    while($res_session=mysql_fetch_assoc($str_session)){
        $session_option.="<option value='".$res_session['ses_id']."'>".substr($res_session['ses_start'], 0, 5)." - ".substr($res_session['ses_end'], 0, 5)."</option>";
        }
    $session_option.="</select>";

    $str_subject=selectQueryDpd($dbname, "setup_subject_list", "*", $conn, "ORDER BY `short_name` ASC");
    $subject_option.="<option value=''>Subject Option</option>";
    while($res_subject=mysql_fetch_assoc($str_subject)){
        $subject_option.="<option value='".$res_subject['subject_id']."'>".$res_subject['short_name']." - ".$res_subject['display_name']."</option>";
    }
    
    session_check(3);
?>
<html>
    <head>
        <?php
        echo dependencies();
        ?>
        <meta charset="UTF-8">
        <title>DiPandu Smart > Schedule : <?php echo $_SESSION['core']['username']; ?></title>
    </head>
    <body style="background-color: #3D5AFE;" onload="loadData()">
        <?php
        echo navigation_bar();
        ?>
        <div class="row">
            <div class="col s12 m12 l12">
                <a onclick="openFile('teacher')" style="color: #FFF;"><b><i class="fa fa-caret-left"></i> Back To Home</b></a>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6">
                <div class="col s12 m12 l12 advanced-search-box" style="padding: 0px !important;">
                    <div class="col s12 m12 l12" style="background-color: #FF9800; color: #FFF; border-radius: 2.5px;">
                        <h5>Advance Search</h5>
                    </div>
                    <div class="col s12 m12 l12" style="margin-top: 10px;">
                        <div class="col s6 m6 l6 input-field">
                            <input id="src_date" type="date" class="datepicker" onchange="searchBy()">
                            <label>Date</label>
                        </div> 
                        <div class="col s6 m6 l6 input-field" onchange="searchBy()">
                            <select id="src_faculty">
                                <?php 
                                    echo $faculty_option;
                                ?>
                            </select>
                        </div>  
                        <div class="col s6 m6 l6 input-field" onchange="searchBy()">
                            <select id="src_subject">
                                <?php 
                                    echo $subject_option;
                                ?>
                            </select>
                        </div> 
                        <div class="col s6 m6 l6 input-field" onchange="searchBy()">
                            <select id="src_session">
                                <?php 
                                    echo $session_option;
                                ?>
                            </select>
                        </div>
                        <div class="col s6 m6 l6 input-field">
                            <select id="src_status" onchange="searchBy()">
                                <option value="">Status Option</option>
                                <option value="0">Not started</option>
                                <option value="1">Ongoing</option>
                                <option value="2">Finished</option>
                            </select>
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
                            <td>Tanggal</td>
                            <td>Teacher</td>
                            <td>Subject</td>
                            <td>Start</td>
                            <td>End</td>
                            <td>Status</td>
                            <td>Classroom</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody id="schedules-table">
                    </tbody>
                    <tfoot id="e-library-table-foot">
                        <tr>
                            <td colspan="9" class="center-align center" style="display: none !important;">
                                <ul class="pagination" id="pageDisplay">
                                    
                                </ul>
                            </td>
                        </tr>
                        
                    </tfoot>
                </table>
            </div>
        </div>
    <?php
    echo javaScriptCall();
    ?>
    <script type='text/javascript' src='js/main-local.js'></script>  
    <script type='text/javascript' src='js/teacher_schedule.js'></script>  
    </body>
</html>
