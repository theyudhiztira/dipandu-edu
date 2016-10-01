<?php

/* 
 * Pandu Yudhistira Wicaksono, 
 * Jakarta 21 September 2016 4:56AM
 */

ini_set("display_errors", 1);

include_once 'lib/dipandu.php';


session_start();

$post=$_POST;

switch($post['proc']){
    case 'upload_file':
        $file_type=strtolower(end(explode('.', $_FILES['file_data']['name'])));

    //    exit($_POST['subject']);

        $upload_path = "media/library/";

        $file = $_FILES['file_data']['name'];
        $tmp  = $_FILES['file_data']['tmp_name'];

        $str_check_file=selectQueryDpd($dbname, "media_ebook", "*", $conn, "WHERE `file_name` = '".$_FILES['file_data']['name']."'");
        $check_file=mysql_num_rows($str_check_file);

        if($check_file == 0){
            if($file_type != 'pdf'){
                exit("3");
            }else{
                $fieldsName="`file_id`, `file_name`, `file_display_name`, `file_extension`, `file_uploader`, `last_update`, `subject_id`, `semester`, `download_counter`";
                $toInsert="NULL, '".$file."', '".$post['display_name']."', 'PDF', '".$_SESSION['core']['registration_number']."', '".date("Y-m-d H:i:s")."', '".$post['subject']."', '".$post['semester']."', '0'";
                $insert_query=insertQueryDpd($dbname, "media_ebook", $fieldsName, $conn, $toInsert);

                if($insert_query == "0"){
                    exit("0");
                }

                if ((isset($file)) && ($file != "")) { 
                    if (move_uploaded_file($tmp, $upload_path.$file)) {
                        exit("1");
                    } else {
                        exit("0");
                    }
                }
            }
        }else{
            exit("2");
        }   
    break;
    
    case 'openPage':        
        if(!empty($post['teacher'])){
            $teacher="= '".$post['teacher']."'";
        }else{
            $teacher="like '%'";
        }
        
        if(!empty($post['subject'])){
            $subject_opt="= '".$post['subject']."'";
        }else{
            $subject_opt="like '%'";
        }
        
        $str_subject=selectQueryDpd($dbname, "setup_subject_list", "subject_id, short_name, display_name", $conn, "");
        while($res_subject=mysql_fetch_assoc($str_subject)){
            $subject['display'][$res_subject['subject_id']]=$res_subject['display_name'];
            $subject['short'][$res_subject['subject_id']]=$res_subject['short_name'];
        }

        $str_teacher=selectQueryDpd($dbname, "core_user", "*", $conn, "where level = '3'");
        while($res_teachers_name=mysql_fetch_assoc($str_teacher)){
            $teacher_name[$res_teachers_name['registration_number']]=$res_teachers_name['fullname'];
        }
        
        $get_row_data=selectQueryDpd($dbname, "media_ebook", "*", $conn, "WHERE  `file_uploader` ".$teacher." AND `subject_id` ".$subject_opt." ORDER BY `subject_id` ASC");
        $row_data=mysql_num_rows($get_row_data);
        
        
        if($row_data < 1){
            $table.="<tr class='".$td_style."' title='Title : ".$res_lib['file_display_name']." ( Semester : ".$res_lib['semester']." )'>
            <td colspan=4 style='text-align: center;'><b style='color: red;'>NO DATA</b></td>
            </tr>";
        }else{
            $loadData=selectQueryDpd($dbname, "media_ebook", "*", $conn, "WHERE `file_uploader` ".$teacher." AND `subject_id` ".$subject_opt." ORDER BY `file_id` ASC LIMIT ".($post['page'] - 1).", 10 ");
            $no=0;
            while($res_lib=mysql_fetch_assoc($loadData)){  
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
                </tr>";  
            }
        }

        $jml_pages=ceil($row_data/10);

        for($pages = 1; $pages <= $jml_pages; $pages++){
            $pagination.="<li class='waves-effect' onclick=\"openPage('".$pages."')\"><a>".$pages."</a></li>";
        }
        
        echo $table."###".$pagination;
    break;
}

    


?>