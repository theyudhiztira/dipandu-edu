/* global getById */
function emptyField(){
    getById("short_name").value="";
    getById("full_name").value="";
    getById("saveBtn").style.display="none";
    getById("cancelBtn").style.display="none";
    getById("addBtn").style.display="inline-block";
}

function loadData(){
    param="proc=loadData";
    
    tujuan="do_setup_faculty.php";
    post_response_text(tujuan, param, respog);
    function respog()
    {
        if(cxr.readyState==4 && cxr.status == 200) {
            if (!isSaveResponse(cxr.responseText)) {
                alert('ERROR DETECTED,\n' + cxr.responseText);
            }
            else {
                document.getElementById('faculty-table').innerHTML=cxr.responseText;
                document.body.style.cursor='default';
            }
        }
        else {
            error_catch(cxr.status);
        }
    }
}

function addData(){
    sName=getById("short_name").value;
    fName=getById("full_name").value;
    
    if(sName === ''){
        alert('Short name cannot be an empty value!');
        return;
    }
    
    if(fName === ''){
        alert('Full name cannot be an empty value');
        return;
    }
    
    param="proc=addData" + "&short_name=" +  sName + "&full_name=" + fName;
    tujuan="do_setup_faculty.php";
    
    post_response_text(tujuan, param, respog);
    function respog()
    {
        if(cxr.readyState==4 && cxr.status == 200) {
            if (!isSaveResponse(cxr.responseText)) {
                alert('ERROR DETECTED,\n' + cxr.responseText);
            }
            else {
                if(cxr.responseText === '1'){
                    alert(fName+' was added');
                    emptyField();
                    loadData();
                }
                
                if(cxr.responseText === '0'){
                    alert('Error while adding faculty');
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

function save(fakId){
    fName=getById("full_name").value;
    sName=getById("short_name").value;
    
    if(sName === ''){
        alert('Short name cannot be an empty value!');
        return;
    }
    
    if(fName === ''){
        alert('Full name cannot be an empty value');
        return;
    }
    
    param="proc=saveData" + "&full_name=" + fName + "&short_name=" + sName + "&fak_id=" + fakId;
    tujuan="do_setup_faculty.php";
    post_response_text(tujuan, param, respog);
    function respog()
    {
        if(cxr.readyState==4 && cxr.status == 200) {
            if (!isSaveResponse(cxr.responseText)) {
                alert('ERROR DETECTED,\n' + cxr.responseText);
            }
            else {
//                alert(cxr.responseText);
                
                if(cxr.responseText === '1'){
                    alert('Edit success');
                    emptyField();
                    loadData();
                }
                
                if(cxr.responseText === '0'){
                    alert('Error while edit faculty');
                }
                
                document.body.style.cursor='default';
            }
        }
        else {
            error_catch(cxr.status);
        }
    }
}

function deleteData(fakid){
    if(confirm('Are you sure to delete data? This can be undone!') === true){
        param="proc=deleteData" + "&fak_id=" + fakid;
        tujuan="do_setup_faculty.php";
        
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