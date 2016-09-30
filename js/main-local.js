/* 
 * Pandu Yudhistira
 * Jakarta , 20 Sept 2016
 */

function openFile(filename){
    location.replace('http://dipandu.net/'+filename+'.php');
}

$(document).ready(function(){
    $(".button-collapse").sideNav({
        menuWidth: 200
    });
    $('select').material_select();
});


function openPage(pages){
    teacher = document.getElementById("teacher_option");
    teacher = teacher.options[teacher.selectedIndex].value;
    subject = document.getElementById("subject_option");
    subject = subject.options[subject.selectedIndex].value;
    
    if(subject !== '' || teacher !== ''){
        advanceStatus = "&advanced=1"; 
    }else{
        advanceStatus = "&advanced=0";
    }
    
    param="proc=openPage" + "&page=" + pages + "&teacher=" + teacher + "&subject=" + subject + advanceStatus;
//    alert(param);
    tujuan="slave_e-library.php";
    post_response_text(tujuan, param, respog);
    function respog()
    {
        if(cxr.readyState==4 && cxr.status == 200) {
                if (!isSaveResponse(cxr.responseText)) {
                    alert('ERROR DETECTED,\n' + cxr.responseText);
                }
                else {
                    var seplit = cxr.responseText;
                    var res = seplit.split("###");
                    
//                    alert(cxr.responseText);
                    
                    document.getElementById('e-library-table').innerHTML=res[0];
                    document.getElementById('pageDisplay').innerHTML=res[1];
                        
                    document.body.style.cursor='default';
                }
            }
            else {
                error_catch(cxr.status);
            }
        
    }
}

function sortBy(pages){
    teacher = document.getElementById("teacher_option");
    teacher = teacher.options[teacher.selectedIndex].value;
    subject = document.getElementById("subject_option");
    subject = subject.options[subject.selectedIndex].value;
    
    if(subject !== '' || teacher !== ''){
        advanceStatus = "&advanced=1"; 
    }else{
        advanceStatus = "&advanced=0";
    }
    
    param="proc=openPage" + "&page=" + pages + "&teacher=" + teacher + "&subject=" + subject + advanceStatus;
//    alert(param);
    tujuan="slave_e-library.php";
    post_response_text(tujuan, param, respog);
    function respog()
    {
        if(cxr.readyState==4 && cxr.status == 200) {
                if (!isSaveResponse(cxr.responseText)) {
                    alert('ERROR DETECTED,\n' + cxr.responseText);
                }
                else {
                    var seplit = cxr.responseText;
                    var res = seplit.split("###");
                    
//                    alert(cxr.responseText);
                    
                    document.getElementById('e-library-table').innerHTML=res[0];
                    document.getElementById('pageDisplay').innerHTML=res[1];
                        
                    document.body.style.cursor='default';
                }
            }
            else {
                error_catch(cxr.status);
            }
        
    }
}

function logOut(){
    location.replace('logout.php');
}