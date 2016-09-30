<?php

/* 
 * Pandu Yudhistira Wicaksono, 
 * Jakarta 21 September 2016 4:56AM
 */

ini_set("display_errors", 1);

include_once 'lib/dipandu.php';

session_check(0);

$get=$_GET;

$get_file_detail=selectQueryDpd($dbname, "media_ebook", "file_id, file_name, file_display_name", $conn, "where file_id = '".$get['file_id']."'");
while($file_name=mysql_fetch_assoc($get_file_detail)){
    $filename=$file_name['file_name'];
    $displayname=$file_name['file_display_name'];
}

$file_type=strtolower(end(explode('.', $filename)));

$file = "media/library/".$filename;
header('Content-Description: File Transfer');
header('Content-Type: application/force-download');
header("Content-Disposition: attachment; filename=\"".$displayname.".".$file_type."\";");
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
ob_clean();
flush();
readfile("media/library/".$filename);
exit;
        
        
?>