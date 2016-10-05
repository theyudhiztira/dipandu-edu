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
        $strGetData=selectQueryDpd($dbname, "setup_schedule_session", "*", $conn, "ORDER BY `ses_start` ASC");
        $no=0;
        while($res_data=mysql_fetch_assoc($strGetData)){
            $no+=1;
            
            if($no % 2 == 0){
                $td_style="library-td-genap";
            }else{
                $td_style="library-td-ganjil";
            }
            
            $table.="<tr class='".$td_style."' title='Session No.".$no." ( ".substr($res_data['ses_start'], 0, 5)." - ".substr($res_data['ses_end'], 0, 5)." )'>
            <td style='text-align: center;'>".$no."</td>
            <td class='library-td' style='text-align: center;'>".substr($res_data['ses_start'], 0, 5)."</td>
            <td class='library-td' style='text-align: center;'>".substr($res_data['ses_end'], 0, 5)."</td>
            <td class='library-td'>
                <a onclick=\"deleteData('".$res_data['ses_id']."')\" target='_blank' class='fa fa-trash library-download-icon' title='Delete session : ( ".substr($res_data['ses_start'], 0, 5)." - ".substr($res_data['ses_end'], 0, 5)." )'></a>
            </td> 
            </tr>";  
        }
        
        echo $table;
    break;
    
    case 'addData':
        $fieldsName="`ses_id`, `ses_start`, `ses_end`, `ses_last_update`, `ses_last_user`";
        $toInsert="NULL, '".$post['start'].":00', '".$post['finish'].":00', CURRENT_TIMESTAMP, '".$_SESSION['core']['registration_number']."'";
        $strInput=insertQueryDpd($dbname, "setup_schedule_session", $fieldsName, $conn, $toInsert);

        
        echo $strInput;
    break;

    case 'saveData':
        $strUpdate="UPDATE ".$dbname.".`setup_faculty_list` SET `fak_display_name` = '".$post['full_name']."', `fak_short_name` = '".$post['short_name']."'
        WHERE `setup_faculty_list`.`fak_id` = '".$post['fak_id']."'";
        
        if(mysql_query($strUpdate,$conn)){
            echo "1";
        }else{
            echo "2";
        }
    break;
    
    case 'deleteData':
        $strDelete="DELETE FROM ".$dbname.".`setup_schedule_session` WHERE `setup_schedule_session`.`ses_id` = '".$post['ses_id']."'";
        
        if(mysql_query($strDelete, $conn)){
            echo "1";
        }else{
            echo "2";
        }
    break;
}

    


?>