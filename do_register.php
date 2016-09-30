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
    case 'checkData':
        $str_validation=selectQueryDpd($dbname, "core_user", "count(id) as user", $conn, "where ".$post['dataType']." = '".$post['data']."'");
        while ($username=mysql_fetch_assoc($str_validation)){
            if($username['user'] > 0){
                $result="1###Your ".$post['dataType']." already taken!";
            }else{
                $result="0###Ready";
            }
        }
        
        echo $result;
        
    break;
    
    case 'signUp':
        if($_SESSION['generated_captcha'] == $post['captcha']){
            $fieldsName="id, registration_number, fullname, username, password, email, level, register_date, verification_status, last_login";
            $toInsert="NULL, '".$post['registration_number']."', '".$post['fullname']."', '".$post['username']."', md5('".$post['password']."'), '".$post['email']."', '".$post['account_type']."','".date("Y-m-d")."', 0, '".date("Y-m-d H:i:s")."'";
            $insert_query=insertQueryDpd($dbname, "core_user", $fieldsName, $conn, $toInsert);
            $result="1###Registration success, verification email sent!";
        }else{
            $result="0###Your chaptcha is incorrect!";
        }
        
        echo $result;
        session_destroy();
    break;
}

?>