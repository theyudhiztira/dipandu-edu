<?php
    if($_SERVER['SERVER_ADDR'] == '103.31.250.117'){
        $dependencies='lib/dependencies-local.php';
    }  else {
        $dependencies='lib/dependencies-local.php';
    }

    require_once 'lib/dipandu.php';
    require_once $dependencies;
    
    session_check(3);
    
    $str_subject=selectQueryDpd($dbname, "setup_subject_list", "subject_id, short_name, display_name", $conn, "");
    $subject_option="<option value=''>Default</option>";
    while($res_subject=mysql_fetch_assoc($str_subject)){
        $subject['display'][$res_subject['subject_id']]=$res_subject['display_name'];
        $subject['short'][$res_subject['subject_id']]=$res_subject['short_name'];
        $subject_option.="<option value='".$res_subject['subject_id']."'>".$res_subject['short_name']." - ".$res_subject['display_name']."</option>";
    }

    $str_teacher=selectQueryDpd($dbname, "core_user", "*", $conn, "where level = '3'");
    $teacher_option="<option value=''>Default</option>";
    while($res_teachers_name=mysql_fetch_assoc($str_teacher)){
        $teacher_name[$res_teachers_name['registration_number']]=$res_teachers_name['fullname'];
        $teacher_option.="<option value='".$res_teachers_name['registration_number']."'>".$res_teachers_name['fullname']."</option>";
    }
?>
<html>
    <head>
        <?php
        echo dependencies();
        ?>
        <meta charset="UTF-8">
        <title>DiPandu Smart > E-Library : <?php echo $_SESSION['core']['username']; ?></title>
    </head>
    <body style="background-color: #3D5AFE;" onload="loadData()">
        <?php
        echo navigation_bar();
        ?>
        <div class="row">
            <div class="col s12 m12 l12">
                <a href="student.php" style="color: #FFF;"><b><i class="fa fa-caret-left"></i> Back To Home</b></a>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l6" style="margin-bottom: 20px;">
                <div class="col s12 m12 l12 advanced-search-box" style="padding: 0px !important;">
                    <div class="col s12 m12 l12" style="background-color: #FF9800; color: #FFF; border-radius: 2.5px;">
                        <h5>E-Book Uploader</h5>
                    </div>
                    <div class="col s12 m12 l12" style="margin-top: 10px;">
                        <form enctype="multipart/form-data">
                            <div class="col s12 m12 l12 input-field">
                                <input id="upload_display_name" name="display_name" type="text" />
                                <label>Display Name</label>
                            </div> 
                            <div class="col s12 m6 l6 input-field">
                                <select id="upload_subject_option">
                                    <?php 
                                        echo $subject_option;
                                    ?>
                                </select>
                                <label>Subjects Name</label>
                            </div>
                            <div class="col s12 m6 l6 input-field">
                                <select id="upload_semester_option">
                                    <?php
                                        $semester.="<option value='' disabled selected>Choose Semester</option>";
                                        for($smt=1; $smt <= 8; $smt++){
                                            $semester.="<option value='".$smt."'>Semester ".$smt."</option>";
                                        }

                                        echo $semester
                                    ?>
                                </select>
                                <label>Semester</label>
                            </div>
                            <div class="col s12 m12 l12 input-field file-field">
                                <div class="btn">
                                    <span>File</span>
                                    <input name="file_data" id="upload_file" type="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text">
                                </div>
                            </div> 
                            
                            <h3 id="status"></h3>
                            <p id="total"></p>
                            <input type="button" class="btn elib-btn-upload" style="background-color: #D84315; margin-bottom: 10px;" value="UPLOAD" onclick="uploadFile()"></form>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6">
                <div class="col s12 m12 l12 advanced-search-box" style="padding: 0px !important;">
                    <div class="col s12 m12 l12" style="background-color: #FF9800; color: #FFF; border-radius: 2.5px;">
                        <h5>Advance Search</h5>
                    </div>
                    <div class="col s12 m12 l12" style="margin-top: 10px;">
                        <div class="col s12 m6 l6 input-field">
                            <select id="teacher_option" onchange="sortBy('1')">
                                <?php 
                                    echo $teacher_option;
                                ?>
                            </select>
                            <label>Teacher Name</label>
                        </div>   
                        <div class="col s12 m6 l6 input-field">
                            <select id="subject_option" onchange="sortBy('1')">
                                <?php 
                                    echo $subject_option;
                                ?>
                            </select>
                            <label>Subjects Name</label>
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
                            <td style="max-width: 482px !important;">Title</td>
                            <td>Uploader</td>
                            <td>Subject</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody id="e-library-table">
                        <?php 
                            echo $table;
                        ?>
                    </tbody>
                    <tfoot id="e-library-table-foot">
                        <tr>
                            <td colspan="4" class="center-align center">
                                <ul class="pagination" id="pageDisplay">
                                    <?php
                                        echo $pagination;
                                    ?>
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
    <script type='text/javascript' src='js/e-library_uploader.js'></script>
    </body>
</html>
