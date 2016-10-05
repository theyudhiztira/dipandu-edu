/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function uploadFile() {
    // membaca data file yg akan diupload, dari komponen 'fileku'
    var file = document.getElementById("upload_file").files[0];
    var display_name = document.getElementById("upload_display_name").value;
    var semester = document.getElementById("upload_semester_option");
    var semester = semester.options[semester.selectedIndex].value;
    var subject = document.getElementById("upload_subject_option");
    var subject = subject.options[subject.selectedIndex].value;
    
    var text_data = ["semester###" + semester, "subject###" + subject, "display_name###" + display_name];
    
    tujuan="do_e-library_uploader.php";
    post_response_file_text(tujuan, "file_data", file, text_data, respog);
    function respog()
    {
        if(cxr.readyState==4 && cxr.status == 200) {
                if (!isSaveResponse(cxr.responseText)) {
                    alert('ERROR DETECTED,\n' + cxr.responseText);
                }
                else {
                    var seplit = cxr.responseText;
                    var res = seplit.split("###");
                    
                    if(seplit === '0'){
                        alert('Error while uploading file!');
                    }
                    
                    if(seplit === '1'){
                        alert('Upload Success!');
                        loadData();
                    }
                    
                    if(seplit === '2'){
                        alert('File is duplicated!');
                    }
                   
                    if(seplit === '3'){
                        alert('File type should be PDF file!');
                    }
                   
                    document.body.style.cursor='default';
                }
            }
            else {
                error_catch(cxr.status);
            }
        
    }
}

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
    tujuan="do_e-library_uploader.php";
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
    tujuan="do_e-library_uploader.php";
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

function searchByTitle(pages){
    title = document.getElementById("titleName").value;
    teacher = document.getElementById("teacher_option");
    teacher = teacher.options[teacher.selectedIndex].value;
    subject = document.getElementById("subject_option");
    subject = subject.options[subject.selectedIndex].value;
    
    if(subject !== '' || teacher !== ''){
        advanceStatus = "&advanced=1"; 
    }else{
        advanceStatus = "&advanced=0";
    }
    
    param="proc=openPage" + "&page=" + pages + "&teacher=" + teacher + "&title=" + title + "&subject=" + subject + advanceStatus;
//    alert(param);
    tujuan="do_e-library_uploader.php";
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

function loadData(){
    param="proc=loadData";
    tujuan="do_e-library_uploader.php";
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

function deleteFile(fileid){
    param="proc=deleteFile" + "&file_id=" + fileid;
    tujuan="do_e-library_uploader.php";
    
    if(confirm("Are you sure to delete this file, this cannot be undone?") === true){
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

                        if(res[0] === '0'){
                            alert('Error while running delete query for : ' + res[1]);
                        }

                        if(res[0] === '1'){
                            alert('Deleted : ' + res[1]);
                            loadData();
                        }

                        if(res[0] === '2'){
                            alert('Unable to delete : ' + res[1]);
                        }

    //                    alert(cxr.responseText);

                        document.body.style.cursor='default';
                    }
                }
                else {
                    error_catch(cxr.status);
                }
        }
    }else{
        return;
    }
    
    
}

