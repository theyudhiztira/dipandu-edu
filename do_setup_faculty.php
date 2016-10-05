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
        $strGetData=selectQueryDpd($dbname, "setup_faculty_list", "*", $conn, "ORDER BY `fak_short_name` ASC");
        $no=0;
        while($res_data=mysql_fetch_assoc($strGetData)){
            $no+=1;
            
            if($no % 2 == 0){
                $td_style="library-td-genap";
            }else{
                $td_style="library-td-ganjil";
            }
            
            $table.="<tr class='".$td_style."' title='".$no.". ".$res_data['fak_short_name']." - ".$res_data['fak_display_name']."'>
            <td style='text-align: center;'>".$no."</td>
            <td id='sName".$res_data['fak_id']."' class='library-td'>".$res_data['fak_short_name']."</td>
            <td id='fName".$res_data['fak_id']."' class='library-td' style='text-align: center;'>".$res_data['fak_display_name']."</td>
            <td class='library-td'>
                <a onclick=\"edit('".$res_data['fak_id']."')\" class='fa fa-pencil library-download-icon' title='Edit : ".$res_data['fak_display_name']."'></a>
                <a onclick=\"deleteData('".$res_data['fak_id']."')\" target='_blank' class='fa fa-trash library-view-icon' title='Delete : ".$res_data['fak_display_name']."' style='margin-left: 15px;'></a>
            </td> 
            </tr>";  
        }
        
        echo $table;
    break;
    
    case 'addData':
        $fieldsName="`fak_id`, `fak_short_name`, `fak_display_name`, `fak_last_update`, `fak_last_user`";
        $toInsert="NULL, '".$post['short_name']."', '".$post['full_name']."', CURRENT_TIMESTAMP, '".$_SESSION['core']['registration_number']."'";
        $strInput=insertQueryDpd($dbname, "setup_faculty_list", $fieldsName, $conn, $toInsert);
        
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
        $strDelete="DELETE FROM ".$dbname.".`setup_faculty_list` WHERE `setup_faculty_list`.`fak_id` = '".$post['fak_id']."'";
        
        if(mysql_query($strDelete, $conn)){
            echo "1";
        }else{
            echo "2";
        }
    break;
}

    


?>