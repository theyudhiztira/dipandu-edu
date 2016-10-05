<?php

/* 
 * Pandu Yudhistira Wicaksono, 
 * Jakarta 21 September 2016 4:56AM
 */

//ini_set("display_errors", 1);

include_once 'lib/dipandu.php';


session_start();

$post=$_POST;

switch($post['proc']){
    case 'loadData':
        $str_teacher=selectQueryDpd($dbname, "core_user", "*", $conn, "where level = '3'");
        while($res_teachers_name=mysql_fetch_assoc($str_teacher)){
            $teacher_name[$res_teachers_name['registration_number']]=$res_teachers_name['fullname'];
            $teacher_option.="<option value='".$res_teachers_name['registration_number']."'>".$res_teachers_name['fullname']."</option>";
        }
        
        $str_session=selectQueryDpd($dbname, "setup_schedule_session", "*", $conn, "ORDER BY `ses_start` ASC");
        while($res_session=mysql_fetch_assoc($str_session)){
            $session_start[$res_session['ses_id']]=substr($res_session['ses_start'], 0, 5);
            $session_end[$res_session['ses_id']]=substr($res_session['ses_end'], 0, 5);
        }
        
        $str_subject=selectQueryDpd($dbname, "setup_subject_list", "*", $conn, "ORDER BY `short_name` ASC");
        while($res_subject=mysql_fetch_assoc($str_subject)){
            $subject_lib['short'][$res_subject['subject_id']]=$res_subject['short_name'];
            $subject_lib['display'][$res_subject['subject_id']]=$res_subject['display_name'];
        }
        
        $str_faculty=selectQueryDpd($dbname, "setup_faculty_list", "*", $conn, "ORDER BY `fak_short_name` ASC");
        while($res_faculty=mysql_fetch_assoc($str_faculty)){
            $faculty_lib[$res_faculty['fak_id']]=$res_faculty['fak_display_name'];
        }
        
        $str_teacher_attendant=selectQueryDpd($dbname, "teacher_confirm_status", "*", $conn, " ");
        while($res_ta=mysql_fetch_assoc($str_teacher_attendant)){
            $ta[$res_ta['date']][$res_ta['teacher_id']]=$res_ta['status'];
        }
        
        $strGetData=selectQueryDpd($dbname, "schedule_list", "*", $conn, "ORDER BY `sch_date` ASC");
        $rowData=mysql_num_rows($strGetData);
        
        if($rowData < 1){
            $table.="<tr style='color: ".$color.";'>
            <td colspan=9 style='text-align: center;'><b style='color: red;'>No Data</b></td>
            </tr>";
        
            exit($tables."####");
        }
        
        
        $no=0;
        while($res_data=mysql_fetch_assoc($strGetData)){            
            $no+=1;
            
            if($no % 2 == 0){
                $td_style="library-td-genap";
            }else{
                $td_style="library-td-ganjil";
            }
                        
            if($res_data['sch_status'] == '0'){
                $active_state="<a onclick=\"setActive('".$res_data['sch_id']."')\" target='_blank' class='fa fa-toggle-on library-download-icon' title='Start class schedule No. ".$no."'></a>";
                $active_icon="<i class='fa fa-times'></i>";
                $status="Not started";
                $color="#000";
            }
            
            if($res_data['sch_status'] == '1'){
                $active_icon="<i class='fa fa-refresh'></i>";
                $status="Ongoing";
                $color="#311B92";
            }
            
            if($res_data['sch_status'] == '2'){
                $active_icon="<i class='fa fa-check'></i>";
                $status="Finished";
                $color="#D50000";
            }
            
            if($res_data['sch_classroom'] == '0'){
                $classroom="Not set";
            }else{
                $classroom=$res_data['sch_classroom'];
            }
            
            if($_SESSION['core']['faculty'] === $res_data['sch_faculty_id']){
                if($res_data['sch_status'] == '0'){
//                    $permition="<a onclick=\"permission('".$res_data['sch_id']."')\" class='fa fa-low-vision library-download-icon' title='Delete schedule No : ".$no."'></a>";
                    $permition=" - ";
                }else{
                    $permition=" - ";
                }
            }  else {
                $permition=" - ";
            }
            
            if(!empty($ta[$res_data['sch_date']][$res_data['sch_teacher_id']])){
                if($ta[$res_data['sch_date']][$res_data['sch_teacher_id']] == '0'){
                    $teacher_stat="circle-o";
                }

                if($ta[$res_data['sch_date']][$res_data['sch_teacher_id']] == '1'){
                    $teacher_stat="check";
                }

                if($ta[$res_data['sch_date']][$res_data['sch_teacher_id']] == '2'){
                    $teacher_stat="times";
                }
            }  else {
                $teacher_stat="circle-o";
            }
                
            
            $table.="<tr style='color: ".$color.";' class='".$td_style."' title='Schedule No.".$no." Faculty : ".$faculty_lib[$res_data['sch_faculty_id']]." - Status : ".$status."'>
            <td style='text-align: center;'>".$no."</td>
            <td class='library-td' style='text-align: center;'>".$res_data['sch_date']."</td>    
            <td class='library-td' style='text-align: center;'>".$teacher_name[$res_data['sch_teacher_id']]."</td>
            <td class='library-td' style='text-align: center;'><i class='fa fa-".$teacher_stat."'></i></td>
            <td class='library-td' style='text-align: center;'>".$subject_lib['short'][$res_data['sch_subject_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$session_start[$res_data['sch_session_id']]." - ".$session_end[$res_data['sch_session_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$active_icon."</td>
            <td class='library-td' style='text-align: center;'>".$classroom."</td>    
            <td class='library-td'>
                ".$permition."
            </td> 
            </tr>";  
        }
        
        $jml_pages=ceil($rowData/25);

        for($pages = 1; $pages <= $jml_pages; $pages++){
            $pagination.="<li class='waves-effect' onclick=\"openPage('".$pages."')\"><a>".$pages."</a></li>";
        }
        
        echo $table."####".$pagination;
    break;
    
    case 'addData':
        $fieldsName="`sch_id`, `sch_date`, `sch_session_id`, `sch_teacher_id`, `sch_subject_id`, `sch_faculty_id`, `sch_confirm`, `sch_status`, `sch_classroom`, `sch_last_update`";
        $toInsert="NULL, '".$post['date']."', '".$post['session']."', '".$post['teacher']."', '".$post['subject']."', '".$post['faculty']."', '0', '0', '".$post['classroom']."', CURRENT_TIMESTAMP";
        $strInput=insertQueryDpd($dbname, "schedule_list", $fieldsName, $conn, $toInsert);
        
        echo $strInput;
    break;
    
    case 'deleteData':
        $strDelete="DELETE FROM ".$dbname.".`schedule_list` WHERE `schedule_list`.`sch_id` = '".$post['ses_id']."'";
        
        if(mysql_query($strDelete, $conn)){
            echo "1";
        }else{
            echo "2";
        }
    break;
    
    case 'setStatus':
        if($post['state'] == '2'){
            $strChange="UPDATE ".$dbname.".`schedule_list` SET `sch_classroom` = '".$post['classroom']."', `sch_status` = '".$post['state']."' WHERE `schedule_list`.`sch_id` = '".$post['id']."';";

        //        exit($strChange);

                if(mysql_query($strChange, $conn)){
                    echo "1";
                }else{
                    echo "2";
                }
        }  else {
            $cekData=selectQueryDpd($dbname, 'schedule_list', "count(*) as data", $conn, "WHERE `sch_classroom` = '".$post['classroom']."' AND `sch_status` = '1'");
            list($data)=mysql_fetch_row($cekData);

            if($data < 1){
                $strChange="UPDATE ".$dbname.".`schedule_list` SET `sch_classroom` = '".$post['classroom']."', `sch_status` = '".$post['state']."' WHERE `schedule_list`.`sch_id` = '".$post['id']."';";

        //        exit($strChange);

                if(mysql_query($strChange, $conn)){
                    echo "1";
                }else{
                    echo "2";
                }
            }  else {
                echo "3";
            }
        }
    break;
    
    case 'openPage':
        $str_teacher=selectQueryDpd($dbname, "core_user", "*", $conn, "where level = '3'");
        while($res_teachers_name=mysql_fetch_assoc($str_teacher)){
            $teacher_name[$res_teachers_name['registration_number']]=$res_teachers_name['fullname'];
            $teacher_option.="<option value='".$res_teachers_name['registration_number']."'>".$res_teachers_name['fullname']."</option>";
        }
        
        $str_session=selectQueryDpd($dbname, "setup_schedule_session", "*", $conn, "ORDER BY `ses_start` ASC");
        while($res_session=mysql_fetch_assoc($str_session)){
            $session_start[$res_session['ses_id']]=substr($res_session['ses_start'], 0, 5);
            $session_end[$res_session['ses_id']]=substr($res_session['ses_end'], 0, 5);
        }
        
        $str_subject=selectQueryDpd($dbname, "setup_subject_list", "*", $conn, "ORDER BY `short_name` ASC");
        while($res_subject=mysql_fetch_assoc($str_subject)){
            $subject_lib['short'][$res_subject['subject_id']]=$res_subject['short_name'];
            $subject_lib['display'][$res_subject['subject_id']]=$res_subject['display_name'];
        }
        
        $str_faculty=selectQueryDpd($dbname, "setup_faculty_list", "*", $conn, "ORDER BY `fak_short_name` ASC");
        while($res_faculty=mysql_fetch_assoc($str_faculty)){
            $faculty_lib[$res_faculty['fak_id']]=$res_faculty['fak_display_name'];
        }
        
        $str_teacher_attendant=selectQueryDpd($dbname, "teacher_confirm_status", "*", $conn, " ");
        while($res_ta=mysql_fetch_assoc($str_teacher_attendant)){
            $ta[$res_ta['date']][$res_ta['teacher_id']]=$res_ta['status'];
        }
        
        //Condition if empty param sent
        
        if(!empty($post['date'])){
            $date="= '".$post['date']."'";
        }else{
            $date="like '%'";
        }
        
        if(!empty($post['sto'])){
            $sto="= '".$post['sto']."'";
        }else{
            if($post['sto'] == '0'){
                $sto="= '0'";
            }else{
                $sto="like '%'";
            }
            
        }
        
//        exit($sto);
        
        if(!empty($post['to'])){
            $src_teacher="= '".$post['to']."'";
        }else{
            $src_teacher="like '%'";
        }
        
        if(!empty($post['fak'])){
            $src_fak="= '".$post['fak']."'";
        }else{
            $src_fak="like '%'";
        }
        
        if(!empty($post['seso'])){
            $src_seso="= '".$post['seso']."'";
        }else{
            $src_seso="like '%'";
        }
        
        if(!empty($post['so'])){
            $so="= '".$post['so']."'";
        }else{
            $so="like '%'";
        }
        
        
        $strGetData=selectQueryDpd($dbname, "schedule_list", "*", $conn, "WHERE `sch_status` ".$sto." AND `sch_date` ".$date." AND `sch_teacher_id` ".$src_teacher." AND"
                . " `sch_faculty_id` ".$src_fak." AND `sch_session_id` ".$src_seso." AND `sch_subject_id` ".$so." ORDER BY `sch_id` ASC");
        $rowData=mysql_num_rows($strGetData);
        
        if($rowData == '0'){
            $table.="<tr style='color: ".$color.";'>
            <td colspan=9 style='text-align: center;'><b style='color: red;'>No Data</b></td>
            </tr>";
        
            exit($table."####");
        }
        
        $no=0;
        while($res_data=mysql_fetch_assoc($strGetData)){            
            $no+=1;
            
            if($no % 2 == 0){
                $td_style="library-td-genap";
            }else{
                $td_style="library-td-ganjil";
            }
                        
            if($res_data['sch_status'] == '0'){
                $active_icon="<i class='fa fa-times'></i>";
                $status="Not started";
                $color="#000";
            }
            
            if($res_data['sch_status'] == '1'){
                $active_icon="<i class='fa fa-refresh'></i>";
                $status="Ongoing";
                $color="#311B92";
            }
            
            if($res_data['sch_status'] == '2'){
                $active_state="";
                $active_icon="<i class='fa fa-check'></i>";
                $status="Finished";
                $color="#D50000";
            }
            
            if($res_data['sch_classroom'] == '0'){
                $classroom="Not set";
            }else{
                $classroom=$res_data['sch_classroom'];
            }
            
            if(!empty($ta[$res_data['sch_date']][$res_data['sch_teacher_id']])){
                if($ta[$res_data['sch_date']][$res_data['sch_teacher_id']] == '0'){
                    $teacher_stat="circle-o";
                }

                if($ta[$res_data['sch_date']][$res_data['sch_teacher_id']] == '1'){
                    $teacher_stat="check";
                }

                if($ta[$res_data['sch_date']][$res_data['sch_teacher_id']] == '2'){
                    $teacher_stat="times";
                }
            }  else {
                $teacher_stat="circle-o";
            }
            
            
            
            $table.="<tr style='color: ".$color.";' class='".$td_style."' title='Schedule No.".$no." Faculty : ".$faculty_lib[$res_data['sch_faculty_id']]." - Status : ".$status."'>
            <td style='text-align: center;'>".$no."</td>
            <td class='library-td' style='text-align: center;'>".$res_data['sch_date']."</td>    
            <td class='library-td' style='text-align: center;'>".$teacher_name[$res_data['sch_teacher_id']]."</td>
            <td class='library-td' style='text-align: center;'><i class='fa fa-".$teacher_stat."'></i></td>
            <td class='library-td' style='text-align: center;'>".$subject_lib['short'][$res_data['sch_subject_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$session_start[$res_data['sch_session_id']]." - ".$session_end[$res_data['sch_session_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$active_icon."</td>
            <td class='library-td' style='text-align: center;'>".$classroom."</td>    
            <td class='library-td'>
                -
            </td> 
            </tr>";  
        }
        
        $jml_pages=ceil($rowData/25);

        for($pages = 1; $pages <= $jml_pages; $pages++){
            $pagination.="<li class='waves-effect' onclick=\"openPage('".$pages."')\"><a>".$pages."</a></li>";
        }
        
        echo $table."####".$pagination;
    break;
}

    


?>