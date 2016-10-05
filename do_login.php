<?php

/* 
 * Pandu Yudhistira Wicaksono, 
 * Jakarta 21 September 2016 4:56AM
 */

ini_set("display_errors", 1);

include_once 'lib/dipandu.php';


session_start();

$post=$_POST;

switch ($post['proc']){
    case 'doLogin':
        $read_str=selectQueryDpd($dbname, "core_user", "count(id) as user", $conn, "where username = '".$post['username']."' and password = md5('".$post['password']."') and level = '".$post['account_type']."'");
        while ($run=mysql_fetch_assoc($read_str)){
            if($run['user'] == 0){
                $exist_status=0;
            }else{
                $exist_status=1;
            }
        }
        
        //GET DATA USER IF SUCCESS
        if($exist_status == 1){
            $get_user=selectQueryDpd($dbname, "core_user", "*", $conn, "where username = '".$post['username']."' and password = md5('".$post['password']."')");
            while ($res_user=mysql_fetch_assoc($get_user)){
                $fullname=$res_user['fullname'];
                $username=$res_user['username'];
                $registration_number=$res_user['registration_number'];
                $email=$res_user['email'];
                $faculty=$res_user['faculty_id'];
            }
            
            $update="UPDATE `".$dbname."`.`core_user` SET `last_login` = '".date("Y-m-d H:i:s")."' WHERE `core_user`.`registration_number` = '".$registration_number."'";
            $runUpdate=mysql_query($update);
            
            if($runUpdate){
                $result="1###Logged in###".$post['account_type'];
            }
            
            $_SESSION['core']['fullname']=$username;
            $_SESSION['core']['username']=$username;
            $_SESSION['core']['registration_number']=$registration_number;
            $_SESSION['core']['email']=$email;
            $_SESSION['core']['account_type']=$post['account_type'];
            if($_SESSION['core']['account_type'] == '2'){
                $_SESSION['core']['faculty']=$faculty;
            }
        }else{
            $result="0###Login failed check your login data!";
        }
        
        echo $result;
    break;
}

?>