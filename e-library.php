<?php
    if($_SERVER['SERVER_ADDR'] == '103.31.250.117'){
        $dependencies='lib/dependencies-local.php';
    }  else {
        $dependencies='lib/dependencies-local.php';
    }

    require_once 'lib/dipandu.php';
    require_once $dependencies;
    
    session_check(2);
    
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
    
//    echo $_SESSION['core']['username'];
    $str_getLibrary=selectQueryDpd($dbname, "media_ebook", "*", $conn, "ORDER BY `subject_id` ASC LIMIT 0, 10");
    $no=0;
    while($res_lib=mysql_fetch_assoc($str_getLibrary)){
        $no+=1;
        if($no % 2 == 0){
            $td_style="library-td-genap";
        }else{
            $td_style="library-td-ganjil";
        }
        $table.="<tr class='".$td_style."' title='Title : ".$res_lib['file_display_name']." ( Semester : ".$res_lib['semester']." )'>
            <td>".$res_lib['file_display_name']."</td>
            <td class='library-td'>".$teacher_name[$res_lib['file_uploader']]."</td>
            <td class='library-td'>".$subject['short'][$res_lib['subject_id']]."</td>
            <td class='library-td'>
                <a href='do_library_download.php?file_id=".$res_lib['file_id']."' class='fa fa-download library-download-icon' title='Download : ".$res_lib['file_display_name']."'></a>
                <a href='media/library/".$res_lib['file_name']."' target='_blank' class='fa fa-eye library-view-icon' title='View : ".$res_lib['file_display_name']."' style='margin-left: 15px;'></a>
            </td> 
        </tr>
        ";
    }
    
    $get_row_data=selectQueryDpd($dbname, "media_ebook", "*", $conn, "");
    $row_data=mysql_num_rows($get_row_data);

    $jml_pages=ceil($row_data/10);

    for($pages = 1; $pages <= $jml_pages; $pages++){
        $pagination.="<li class='waves-effect' onclick=\"openPage('".$pages."')\"><a>".$pages."</a></li>";
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
    <body style="background-color: #3D5AFE;">
        <?php
        echo navigation_bar();
        ?>
        <div class="row">
            <div class="col s12 m12 l12">
                <a href="student.php" style="color: #FFF;"><b><i class="fa fa-caret-left"></i> Back To Home</b></a>
            </div>
        </div>
        <div class="row">
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
    </body>
</html>
