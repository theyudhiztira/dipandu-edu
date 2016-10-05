<?php

/* 
 * Pandu Yudhistira Wicaksono, 
 * Jakarta 21 September 2016 4:56AM
 */

//ini_set("display_errors", 1);

include_once 'lib/dipandu.php';


session_start();

$post=$_POST;

switch ($post['proc']){
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
        
        if(!empty($post['title'])){
            $title_opt="like '%".$post['title']."%'";
        }else{
            $title_opt="like '%'";
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
        
        $get_row_data=selectQueryDpd($dbname, "media_ebook", "*", $conn, "WHERE `file_display_name` ".$title_opt." AND `file_uploader` ".$teacher." AND `subject_id` ".$subject_opt." ORDER BY `subject_id` ASC");
        $row_data=mysql_num_rows($get_row_data);
        
        
        if($row_data < 1){
            $table.="<tr class='".$td_style."' title='Title : ".$res_lib['file_display_name']." ( Semester : ".$res_lib['semester']." )'>
            <td colspan=4 style='text-align: center;'><b style='color: red;'>NO DATA</b></td>
            </tr>";
        }else{
            $loadData=selectQueryDpd($dbname, "media_ebook", "*", $conn, "WHERE `file_display_name` ".$title_opt." AND `file_uploader` ".$teacher." AND `subject_id` ".$subject_opt." ORDER BY `file_id` ASC ");
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