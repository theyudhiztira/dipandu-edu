/* global getById */

function loadData(){
    param="proc=loadData";
    
    tujuan="do_setup_session.php";
    post_response_text(tujuan, param, respog);
    function respog()
    {
        if(cxr.readyState==4 && cxr.status == 200) {
            if (!isSaveResponse(cxr.responseText)) {
                alert('ERROR DETECTED,\n' + cxr.responseText);
            }
            else {
                document.getElementById('session-table').innerHTML=cxr.responseText;
                document.body.style.cursor='default';
            }
        }
        else {
            error_catch(cxr.status);
        }
    }
}

function addData(){
    var sH=getById("start_hour");
    var sH=sH.options[sH.selectedIndex].value;
    var sM=getById("start_minutes");
    var sM=sM.options[sM.selectedIndex].value;
    var fH=getById("finish_hour");
    var fH=fH.options[fH.selectedIndex].value;
    var fM=getById("finish_minutes");
    var fM=fM.options[fM.selectedIndex].value;
    
    
    if(sH === ''){
        alert('Fill all field!');
        return;
    }
    
    if(sM === ''){
        alert('Fill all field!');
        return;
    }
    
    if(fH === ''){
        alert('Fill all field!');
        return;
    }
    
    if(fM === ''){
        alert('Fill all field!');
        return;
    }
    
    if(sH >= fH){
        alert('Start time must be lower than finish time!');
        return;
    }
    
    param="proc=addData" + "&start=" +  sH + ":" + sM + "&finish=" +  fH + ":" + fM;
    tujuan="do_setup_session.php";
    
    post_response_text(tujuan, param, respog);
    function respog()
    {
        if(cxr.readyState==4 && cxr.status == 200) {
            if (!isSaveResponse(cxr.responseText)) {
                alert('ERROR DETECTED,\n' + cxr.responseText);
            }
            else {
                if(cxr.responseText === '1'){
                    alert('New session added');
                    location.reload();
                }
                
                if(cxr.responseText === '0'){
                    alert('Error while adding new session!');
                }
                
                document.body.style.cursor='default';
            }
        }
        else {
            error_catch(cxr.status);
        }
    }
}

function edit(fakId){
    var fName=getById("fName"+fakId).innerHTML;
    var sName=getById("sName"+fakId).innerHTML;
    
    getById("short_name").value=sName;
    getById("full_name").value=fName;
    getById("full_name").focus();
    getById("short_name").focus();
    
    getById("saveBtn").onclick = function(){ save(fakId); };

    getById("saveBtn").style.display="inline-block";
    getById("addBtn").style.display="none";
    getById("cancelBtn").style.display="inline-block";
    
    

}

function deleteData(sesid){
    if(confirm('Are you sure to delete data? This can be undone!') === true){
        param="proc=deleteData" + "&ses_id=" + sesid;
        tujuan="do_setup_session.php";
        
        post_response_text(tujuan, param, respog);
        function respog()
        {
            if(cxr.readyState==4 && cxr.status == 200) {
                if (!isSaveResponse(cxr.responseText)) {
                    alert('ERROR DETECTED,\n' + cxr.responseText);
                }
                else {
    //                alert(cxr.responseText);
    
                    res=cxr.responseText.split("###");

                    if(res[0] === '1'){
                        alert('Delete success!');
                        loadData();
                    }

                    if(res[0] === '0'){
                        alert('Error while deleting data!');
                    }

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