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
        
        $strGetData=selectQueryDpd($dbname, "schedule_list", "*", $conn, "WHERE `sch_teacher_id` = '".$_SESSION['core']['registration_number']."'ORDER BY `sch_date`");
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
                $active_state="<a onclick=\"changeState('".$res_data['sch_id']."###2')\" class='fa fa-toggle-off library-download-icon' title='End class schedule No. ".$no."'></a>";
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
                $input_cl="<input type='text' class='browser-default' id='input_cl".$res_data['sch_id']."' placeholder='Fill your classroom!' />";
            }else{
                $classroom=$res_data['sch_classroom'];
                $input_cl="<label>You can change your classroom if it's in use</label>
                    <input type='text' class='browser-default' id='input_cl".$res_data['sch_id']."' value='".$res_data['sch_classroom']."' />";
            }
            
            
            
            $table.="<tr style='color: ".$color.";' class='".$td_style."' title='Schedule No.".$no." Faculty : ".$faculty_lib[$res_data['sch_faculty_id']]." - Status : ".$status."'>
            <td style='text-align: center;'>".$no."</td>
            <td class='library-td' style='text-align: center;'>".$res_data['sch_date']."</td>    
            <td class='library-td' style='text-align: center;'>".$teacher_name[$res_data['sch_teacher_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$subject_lib['short'][$res_data['sch_subject_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$session_start[$res_data['sch_session_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$session_end[$res_data['sch_session_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$active_icon."</td>
            <td class='library-td' style='text-align: center;'>".$classroom."</td>    
            <td class='library-td'>
                ".$active_state."
            </td> 
            </tr>
            
            <!-- Modal untuk input kelas -->
            <div id='modalActive".$res_data['sch_id']."' class='modal modal-fixed-footer'>
                <div class='modal-content'>
                    <h4>Detail Of Schedule</h4>
                    <div class='col s12 m12 l12'><b>Faculty :</b></div>
                    <div class='col s12 m12 l12'>".$faculty_lib[$res_data['sch_faculty_id']]."</div>
                    <div class='col s12 m12 l12'><b>Teacher Name :</b></div>
                    <div class='col s12 m12 l12'>".$teacher_name[$res_data['sch_teacher_id']]."</div>
                    <div class='col s12 m12 l12'><b>Date :</b></div>
                    <div class='col s12 m12 l12'>".$res_data['sch_date']."</div>
                    <div class='col s12 m12 l12'><b>Subject :</b></div>
                    <div class='col s12 m12 l12'>".$subject_lib['short'][$res_data['sch_subject_id']]." - ".$subject_lib['display'][$res_data['sch_subject_id']]."</div>
                    <div class='col s12 m12 l12'><b>Time :</b></div>
                    <div class='col s12 m12 l12'>".$session_start[$res_data['sch_session_id']]." - ".$session_end[$res_data['sch_session_id']]."</div>
                    <div class='col s12 m12 l12'><b>Classroom :</b></div>
                    <div class='col s12 m6 l6'>".$input_cl."</div>
                </div>
                <div class='modal-footer'>
                    <a class='modal-action waves-effect waves-green btn-flat' onclick=\"changeState('".$res_data['sch_id']."###1')\">Save</a>
                </div>
            </div>";  
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
        
        
        $strGetData=selectQueryDpd($dbname, "schedule_list", "*", $conn, "WHERE `sch_status` ".$sto." AND `sch_date` ".$date." AND `sch_teacher_id` = '".$_SESSION['core']['registration_number']."' AND"
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
                $active_state="<a onclick=\"setActive('".$res_data['sch_id']."')\" target='_blank' class='fa fa-toggle-on library-download-icon' title='Start class schedule No. ".$no."'></a>";
                $active_icon="<i class='fa fa-times'></i>";
                $status="Not started";
                $color="#000";
            }
            
            if($res_data['sch_status'] == '1'){
                $active_state="<a onclick=\"changeState('".$res_data['sch_id']."###2')\" class='fa fa-toggle-off library-download-icon' title='End class schedule No. ".$no."'></a>";
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
                $input_cl="<input type='text' class='browser-default' id='input_cl".$res_data['sch_id']."' placeholder='Fill your classroom!' />";
            }else{
                $classroom=$res_data['sch_classroom'];
                $input_cl="<label>You can change your classroom if it's in use</label>
                    <input type='text' class='browser-default' id='input_cl".$res_data['sch_id']."' value='".$res_data['sch_classroom']."' />";
            }
            
            
            
            $table.="<tr style='color: ".$color.";' class='".$td_style."' title='Schedule No.".$no." Faculty : ".$faculty_lib[$res_data['sch_faculty_id']]." - Status : ".$status."'>
            <td style='text-align: center;'>".$no."</td>
            <td class='library-td' style='text-align: center;'>".$res_data['sch_date']."</td>    
            <td class='library-td' style='text-align: center;'>".$teacher_name[$res_data['sch_teacher_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$subject_lib['short'][$res_data['sch_subject_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$session_start[$res_data['sch_session_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$session_end[$res_data['sch_session_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$active_icon."</td>
            <td class='library-td' style='text-align: center;'>".$classroom."</td>    
            <td class='library-td'>
                ".$active_state."
            </td> 
            </tr>
            
            <!-- Modal untuk input kelas -->
            <div id='modalActive".$res_data['sch_id']."' class='modal modal-fixed-footer'>
                <div class='modal-content'>
                    <h4>Detail Of Schedule</h4>
                    <div class='col s12 m12 l12'><b>Faculty :</b></div>
                    <div class='col s12 m12 l12'>".$faculty_lib[$res_data['sch_faculty_id']]."</div>
                    <div class='col s12 m12 l12'><b>Teacher Name :</b></div>
                    <div class='col s12 m12 l12'>".$teacher_name[$res_data['sch_teacher_id']]."</div>
                    <div class='col s12 m12 l12'><b>Date :</b></div>
                    <div class='col s12 m12 l12'>".$res_data['sch_date']."</div>
                    <div class='col s12 m12 l12'><b>Subject :</b></div>
                    <div class='col s12 m12 l12'>".$subject_lib['short'][$res_data['sch_subject_id']]." - ".$subject_lib['display'][$res_data['sch_subject_id']]."</div>
                    <div class='col s12 m12 l12'><b>Time :</b></div>
                    <div class='col s12 m12 l12'>".$session_start[$res_data['sch_session_id']]." - ".$session_end[$res_data['sch_session_id']]."</div>
                    <div class='col s12 m12 l12'><b>Classroom :</b></div>
                    <div class='col s12 m6 l6'>".$input_cl."</div>
                </div>
                <div class='modal-footer'>
                    <a class='modal-action waves-effect waves-green btn-flat' onclick=\"changeState('".$res_data['sch_id']."###1')\">Save</a>
                </div>
            </div>";  
        }
        
        $jml_pages=ceil($rowData/25);

        for($pages = 1; $pages <= $jml_pages; $pages++){
            $pagination.="<li class='waves-effect' onclick=\"openPage('".$pages."')\"><a>".$pages."</a></li>";
        }
        
        echo $table."####".$pagination;
    break;
    
    case 'loadEverything':
        $today=date("Y-m-d");

        $todayExp=  explode("-", $today);
        $todayFormat=sprintf("%d",$todayExp[2])." ".bulanEnglish($todayExp[1], "L").", ".$todayExp[0];
        
        $strCheckJadwal=selectQueryDpd($dbname, "schedule_list", "count(*) as jumlahData", $conn, "WHERE `sch_teacher_id` = '".$_SESSION['core']['registration_number']."' AND `sch_date` = '".$todayFormat."'");
        list($jadwal)=mysql_fetch_row($strCheckJadwal);

        if($jadwal > 0){
            $strCheckKehadiran=selectQueryDpd($dbname, "teacher_confirm_status", "count(*) as jumlahData", $conn, "WHERE `teacher_id` = '".$_SESSION['core']['registration_number']."' AND `date` = '".$todayFormat."' AND `status` = '0'");
            list($kehadiran)=mysql_fetch_row($strCheckKehadiran);
            if($kehadiran == 0){
                $strCheckNongol=selectQueryDpd($dbname, "teacher_confirm_status", "count(*) as jumlahData", $conn, "WHERE `teacher_id` = '".$_SESSION['core']['registration_number']."' AND `date` = '".$todayFormat."' AND `status` = '1' OR `status` = '2'");
                list($nongol)=mysql_fetch_row($strCheckNongol);
                if($nongol == 0){
                    $strInsertKehadiran=insertQueryDpd($dbname, "teacher_confirm_status", "`id`, `teacher_id`, `status`, `date`", $conn, "NULL, '".$_SESSION['core']['registration_number']."', '0', '".$todayFormat."'");
                    $return="You have teaching schedule today. Will you attend today? <b style='color: #76FF03;' class='hadir' title='Click if you will attend' onclick=\"confirmH('1')\">YES</b> or <b class='hadir' onclick=\"confirmH('2')\" style='color: #D50000;' title=\"Click if you cant't attend\">NO</b>";
                }else{
                    $return="";
                }
            }else{
                $return="You have teaching schedule today. Will you attend today? <b style='color: #76FF03;' class='hadir' title='Click if you will attend' onclick=\"confirmH('1')\">YES</b> or <b class='hadir' onclick=\"confirmH('2')\" style='color: #D50000;' title=\"Click if you cant't attend\">NO</b>";
            }
        }else{
            $return="";
        }
        
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
        
        $today=date("Y-m-d");

        $todayExp=  explode("-", $today);
        $todayFormat=sprintf("%d",$todayExp[2])." ".bulanEnglish($todayExp[1], "L").", ".$todayExp[0];
        
        $strGetData=selectQueryDpd($dbname, "schedule_list", "*", $conn, "WHERE `sch_teacher_id` = '".$_SESSION['core']['registration_number']."' AND `sch_date` = '".$todayFormat."' ORDER BY `sch_date`");
        $rowData=mysql_num_rows($strGetData);
        
        if($rowData < 1){
            $table.="<tr style='color: ".$color.";'>
            <td colspan=6 style='text-align: center;'><b style='color: red;'>You don't have any schedules today</b></td>
            </tr>";
        
            exit("####".$table);
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
                $active_state="<a onclick=\"changeState('".$res_data['sch_id']."###2')\" class='fa fa-toggle-off library-download-icon' title='End class schedule No. ".$no."'></a>";
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
                $input_cl="<input type='text' class='browser-default' id='input_cl".$res_data['sch_id']."' placeholder='Fill your classroom!' />";
            }else{
                $classroom=$res_data['sch_classroom'];
                $input_cl="<label>You can change your classroom if it's in use</label>
                    <input type='text' class='browser-default' id='input_cl".$res_data['sch_id']."' value='".$res_data['sch_classroom']."' />";
            }
            
            $table.="<tr style='color: ".$color.";' class='".$td_style."' title='Schedule No.".$no." Faculty : ".$faculty_lib[$res_data['sch_faculty_id']]." - Status : ".$status."'>
            <td style='text-align: center;'>".$no."</td>
            <td class='library-td' style='text-align: center;'>".$res_data['sch_date']."</td> 
            <td class='library-td' style='text-align: center;'>".$subject_lib['short'][$res_data['sch_subject_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$session_start[$res_data['sch_session_id']]." - ".$session_end[$res_data['sch_session_id']]."</td>
            <td class='library-td' style='text-align: center;'>".$active_icon."</td>
            <td class='library-td' style='text-align: center;'>".$classroom."</td>   
            </tr>";  
        }
            
        echo $return."####".$table;
    break;
    
    case 'confirmHadir':
        $update="UPDATE ".$dbname.".`teacher_confirm_status` SET `status` = '".$post['status']."' WHERE `teacher_confirm_status`.`teacher_id` = '".$_SESSION['core']['registration_number']."' AND `status` = '0'";
        if(mysql_query($update, $conn)){
            echo "1";
        }else{
            echo "0";
        }
    break;

}

    


?>