/* 
 * Author : Pandu Yudhistira
 * 14 Jan 2016
 * DiPandu ERP
 */

function open_menu(file,ev)
{
    frame=document.getElementById('subFrame').src=file;
}

function keyBind(e)//get key code e is event
{
        var key;
        if(window.event) {
               key = e.keyCode;
        }
        else if(e.which) {
               key = e.which;
        }
        else {
               return true;
        }
      return key;
}

function numberOnly(e){
    key=keyBind(e);
    if((key<48 || key>57) && (key!=8 && key!=46  && key!=127 && key!=true)){
        alert('Only number allowed!');
        return false;
    }
    else
    {
        return true;
    }
}


//function navigationBind(file){
//    file=document.getElementById
//}

function createXMLHttpRequest() {
   try { return new ActiveXObject("Msxml2.XMLHTTP"); } 
   catch (e) {}
   try { return new ActiveXObject("Microsoft.XMLHTTP"); } 
   catch (e) {}
   try { return new XMLHttpRequest(); } 
   catch(e) {}
   alert("XMLHttpRequest Is Not Supported On Your Browser");
   return null;
 }

var cxr=createXMLHttpRequest();

function post_response_text(tujuan,param,functiontoexecute)
{
    reload_on();
    cxr.open("POST", tujuan, true);
    cxr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    cxr.onreadystatechange = eval(functiontoexecute);
    cxr.send(param);
}

function post_data(tujuan, param)
{
    reload_on();
    cxr.open("POST", tujuan, true);
    cxr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    cxr.send(param);
}

function error_catch(x)
{
	switch (x){
          case 203:
	  alert('Dibutuhkan Authority');
	  break;
	  case 400:
	  alert('Error Server');
	  break;
	  case 403:
	  alert('Anda dilarang masuk');
	  break;
	  case 404:
	  alert('File tidak ditemukan');
	  break;
	  case 405:
	  alert('Method tidak diijinkan');
	  break;
	  case 407:
	  alert('Proxy Error');
	  break;
	  case 408:
	  alert('Permintaan terlalu lama');
	  break;
	  case 409:
	  alert('Query Conflict');
	  break;
	  case 414:
	  alert('ULI terlalu panjang');
	  break;
	  case 412:
	  alert('Variable terlalu banyak');
	  break;
	  case 415:
	  alert('Unsupported Media Type');
	  break;
	  case 500:
	  alert('Server busy, try submit later');
	  break;
	  case 502:
	  alert('Bad gateway');
	  break;
	  case 505:
	  alert('Browser anda terlalu tua');	    
      break;
}
}

function isSaveResponse(txt)
{
	txt=txt.toUpperCase();
	if (txt.lastIndexOf('GAGAL') > -1 || txt.lastIndexOf('ERROR') > -1 || txt.lastIndexOf('WARNING') > -1){
            return false
        }else{
	  return true;
        }
}

function notifError(display)
{
    if(display === 'show'){
        error = document.getElementById('infoError').style.display="block";   
    }
    
    if(display === 'hide'){
        error = document.getElementById('infoError').style.display="none";
    }
    
    return error;
}


function notifSuccess(display)
{
    if(display === 'show'){
        error = document.getElementById('infoSuccess').style.display="block";   
    }
    
    if(display === 'hide'){
        error = document.getElementById('infoSuccess').style.display="none";
    }
    
    return error;
}

function reload_on()//set busy on
{
	document.body.style.cursor='wait';
}

function reload_off()//set busy off
{
	document.body.style.cursor='default';
}

function getPage(elementid, targetid, filetarget, maxperpage, dbname, process)
{
    select=document.getElementById(elementid);
    select=select.options[select.selectedIndex].value;
    
    param=process + "&page=" + select + "&maxperpage=" + maxperpage + "&dbname=" + dbname;
    
    tujuan=filetarget;
    post_response_text(tujuan, param, respog);	
    function respog()
    {
        if(cxr.readyState==4)
        {
            if (cxr.status == 200) {
                reload_off();
                if (!isSaveResponse(cxr.responseText)) {
                    alert('ERROR TRANSACTION,\n' + cxr.responseText);
                }
                else {
                    document.getElementById(targetid).innerHTML=cxr.responseText;
                }
            }
            else {
                reload_off();
                error_catch(cxr.status);
            }
        }
    }
}

function busy_off(){
    document.body.style.cursor='default';
}