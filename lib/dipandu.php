<?php
/* Jakarta , 20 Okt 2015 */
//ini_set('display_errors', '1');
@include_once 'config/connection.php';

//Anti SQL Injection Module
function anti_injection_login($str){
    $safe_str=stripslashes($str);
    $safe_str=mysql_real_escape_string($safe_str);
    if(!strpos($safe_str, '%')){
        $str=$safe_str;
    }
    else 
    {
        $str="Detected";
    }
    
    return $str;
}

function dipandu_password($str){
    $str='dpd218'.$str.'96';
    
    return $str;
}

function get_client_ip_env() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}

//Jkt, 17 Nov 2015
function selectQueryDpd($dbname, $tableName, $fieldName, $conn, $additionalClause){
    if(!empty($additionalClause)){
        $str="select ".$fieldName." from ".$dbname.".".$tableName." ".$additionalClause."";
    }else{
        $str="select ".$fieldName." from ".$dbname.".".$tableName."";
    }
    
    $selectRes=  mysql_query($str,$conn) or die($conn);
    
    return $selectRes;
}

function selectQueryTest($dbname, $tableName, $fieldName, $conn, $additionalClause){
    if(!empty($additionalClause)){
        $str="select ".$fieldName." from ".$dbname.".".$tableName." ".$additionalClause."";
    }else{
        $str="select ".$fieldName." from ".$dbname.".".$tableName."";
    }
    
//    $selectRes=  mysql_query($str,$conn);
    
    return $str;
}

//Jkt, 25 Nov 2015
function insertQueryDpd($dbname, $tableName, $fieldsName, $conn, $toInsert){
    if(!isset($toInsert)){
        echo "<script>"
            ."alert('Error Detected : Insert function script was error! Call your develeoper.')"
            ."</script>";
    }else{
        if(!empty($fieldsName)){
            $str="INSERT INTO ".$dbname.".".$tableName." (".$fieldsName.") VALUES (".$toInsert.");";
        }else{
            $str="INSERT INTO ".$dbname.".".$tableName." VALUES (".$toInsert.");";
        }
        
        if(empty($toInsert)){
            $insertRes=  "0";
        }else{
            $insertRes=  mysql_query($str,$conn) or die($conn);
            if($insertRes){
                $insertRes=  "1";
            }else{
                $insertRes=  "0";
            }
        }
        
        return $insertRes;
    }
    
    return $insertRes;
}

function insertQueryTest($dbname, $tableName, $fieldsName, $conn, $toInsert){
    if(!isset($toInsert)){
        echo "<script>"
            ."alert('Error Detected : Insert function script was error! Call your develeoper.')"
            ."</script>";
    }else{
        if(!empty($fieldsName)){
            $str="INSERT INTO ".$dbname.".".$tableName." (".$fieldsName.") VALUES (".$toInsert.");";
        }else{
            $str="INSERT INTO ".$dbname.".".$tableName." VALUES (".$toInsert.");";
        }
        
        if(empty($toInsert)){
            $insertRes=  "FAILED";
        }else{
            return $str;
        }
        
    }
    
    return $insertRes;
}

function deleteQueryDpd($dbname, $tableName, $conn, $whereClause){
    if(!isset($tableName) or !isset($dbname)){
        echo "<script>"
            ."alert('Error Detected : Insert function script was error! Call your develeoper.')"
            ."</script>";
    }else{
        $str="DELETE FROM ".$dbname.".".$tableName." where ".$whereClause.";";
        
        $deleteRes=  mysql_query($str,$conn) or die($conn);
        if($deleteRes){
            $deleteRes=  "SUKSES";
        }else{
            $deleteRes=  "ERROR : TRANSACTION FAILED!";
        }
    }
    return $deleteRes;
}

function antiSqlError($string){
    $firstStep= str_replace("'", "", $string);
    $secondStep= str_replace('"', "", $firstStep);
    $replaced= str_replace(";", "", $secondStep);
    
    return $replaced;
}

function connect_other_server($target_dbname,$current_dbname,$current_connection,$test='boolean 0 or 1'){
    $str="select ip,username,password,port,dbname from ".$current_dbname.".setup_remotetimbangan
          where lokasi='".$target_dbname."'";
    
    if($test=='1'){
        return $str;
    }
    
    if($test=='0'){
        $res=mysql_query($str,$current_connection);
        $idAdd='';
        while($bar=mysql_fetch_object($res))
        {
            $idAdd=$bar->ip;
            $prt=$bar->port;
            $usrName=$bar->username;
            $pswrd=$bar->password;
            $dbminanga=$bar->dbname;
        }
        if($idAdd==''){
            echo "Error: Koneksi ".$target_dbname." gagal"; exit;
        }else{
            $cominanga=mysql_connect($idAdd.":".$prt,$usrName,$pswrd) or die($cominanga);
        }

        return array('target_con' => $cominanga, 'target_db' => $dbminanga);
    }
}

//14 Maret 2016, Pandu Yudhistira Wicaksono
function fillEmpty($value, $replacementCharacter){
    if(empty($value)){
        $result=$replacementCharacter;
    }else{
        $result=$value;
    }
    
    return $result;
}

function dates_inbetween($date1, $date2){

    $day = 60*60*24;

    $date1 = strtotime($date1);
    $date2 = strtotime($date2);

    $days_diff = round(($date2 - $date1)/$day); // Unix time difference devided by 1 day to get total days in between

    $dates_array = array();
    $dates_array[] = date('Y-m-d',$date1);

    for($x = 1; $x < $days_diff; $x++){
        $dates_array[] = date('Y-m-d',($date1+($day*$x)));
    }

    $dates_array[] = date('Y-m-d',$date2);
    if($date1==$date2){
        $dates_array = array();
        $dates_array[] = date('Y-m-d',$date1);        
    }
    return $dates_array;
}

function sqlDateCharIndonesia($date) { // fungsi atau method untuk mengubah tanggal ke format indonesia
   // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
    $BulanIndo = array("Januari", "Februari", "Maret",
                       "April", "Mei", "Juni",
                       "Juli", "Agustus", "September",
                       "Oktober", "November", "Desember");

    $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
    $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
    $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring

    $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
    return($result);
}

function bulanIndonesia($bulan, $length="'S' for short format, 'L' for long format"){
    if($length == 'S'){
      $dpArr=array("Jan", "Feb", "Mar",
                       "Apr", "Mei", "Jun",
                       "Jul", "Agu", "Sep",
                       "Okt", "Nov", "Des");  
    }elseif ($length == 'L'){
        $dpArr=array("Januari", "Februari", "Maret",
                       "April", "Mei", "Juni",
                       "Juli", "Agustus", "September",
                       "Oktober", "November", "Desember");  
    }else{
        echo "<script type='javascript'>
        alert('Errot Length Format!');
        </script>";
    }
    
    $bulanMentah=$bulan - 1;
    $bulanJadi=$dpArr[$bulanMentah];
    
    return $bulanJadi;
}


//Pandu Yudhistira, Jakarta 21 September 2016 
//11:32 PM Semangat untuk INDONESIA
//Germany I'M COMING TO YOU!!!!!

function secured_session_start() {
    $session_name = 'dipandu_session';   // Set a custom session name
    /*Sets the session name. 
     *This must come before session_set_cookie_params due to an undocumented bug/feature in PHP. 
     */
    session_name($session_name);
 
    $secure = true;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
 
    session_start();            // Start the PHP session 
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
}

function session_check($accountType){
    session_start();
    
    if(empty($_SESSION['core'])){
        echo "<script>
        alert('You need to login first!');
        location.replace('./');
        </script>";
        session_destroy();
    }
    
    if($accountType != 0){
        if($_SESSION['core']['account_type'] != $accountType){
            echo "<script>
            alert('You have no permission to access this page! We will redirect you to login page!');
            location.replace('./');
            </script>";
            session_destroy();
        }
    }        
}
