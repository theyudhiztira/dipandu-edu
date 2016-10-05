
function loadEverything(){
    param="proc=loadEverything";
    tujuan="do_teacher_schedule.php";
    post_response_text(tujuan, param, respog);
        function respog()
        {
            if(cxr.readyState==4 && cxr.status == 200) {
                if (!isSaveResponse(cxr.responseText)) {
                    alert('ERROR DETECTED,\n' + cxr.responseText);
                }
                else {                        
                    res=cxr.responseText.split("####");
                    
                    getById("kehadiran").innerHTML=res[0];
                    getById("schedules-table").innerHTML=res[1];
                    document.body.style.cursor='default';
                }
            }
            else {
                error_catch(cxr.status);
            }
        }
}

function confirmH(status){
    param="proc=confirmHadir" + "&status=" + status;
    tujuan="do_teacher_schedule.php";
    post_response_text(tujuan, param, respog);
        function respog()
        {
            if(cxr.readyState==4 && cxr.status == 200) {
                if (!isSaveResponse(cxr.responseText)) {
                    alert('ERROR DETECTED,\n' + cxr.responseText);
                }
                else {                        
                    alert(cxr.responseText);

                    document.body.style.cursor='default';
                }
            }
            else {
                error_catch(cxr.status);
            }
        }
}

function loadData(){
    param="proc=loadData2";
    
    aleert
    
    tujuan="do_teacher_schedule.php";
    post_response_text(tujuan, param, respog);
    function respog()
    {
        if(cxr.readyState==4 && cxr.status == 200) {
            if (!isSaveResponse(cxr.responseText)) {
                alert('ERROR DETECTED,\n' + cxr.responseText);
            }
            else {
                getById("schedules-table").innerHTML=cxr.responseText;
                document.body.style.cursor='default';
            }
        }
        else {
            error_catch(cxr.status);
        }
    }
}