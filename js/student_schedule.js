/* global getById */

function loadData(){
    param="proc=loadData";
    
    tujuan="do_student_schedule.php";
    post_response_text(tujuan, param, respog);
    function respog()
    {
        if(cxr.readyState==4 && cxr.status == 200) {
            if (!isSaveResponse(cxr.responseText)) {
                alert('ERROR DETECTED,\n' + cxr.responseText);
            }
            else {
                res=cxr.responseText.split("####");
                
//                alert(res[0]);
                
                getById("schedules-table").innerHTML=res[0];
                getById("pageDisplay").innerHTML=res[1];
                document.body.style.cursor='default';
            }
        }
        else {
            error_catch(cxr.status);
        }
    }
}

function searchBy(){
    var date=getById("src_date").value;    
    var to=getById("src_teacher");
    var to=to.options[to.selectedIndex].value;
    var fak=getById("src_faculty");
    var fak=fak.options[fak.selectedIndex].value;
    var seso=getById("src_session");
    var seso=seso.options[seso.selectedIndex].value;
    var so=getById("src_subject");
    var so=so.options[so.selectedIndex].value;
    var sto=getById("src_status");
    var sto=sto.options[sto.selectedIndex].value;
    
   param="proc=openPage" + "&date=" + date + "&to=" + to + "&fak=" + fak + "&seso=" + seso + "&so=" + so + "&sto=" + sto;
   tujuan="do_student_schedule.php";
   
   post_response_text(tujuan, param, respog);
   function respog()
   {
       if(cxr.readyState==4 && cxr.status == 200) {
            if (!isSaveResponse(cxr.responseText)) {
                alert('ERROR DETECTED,\n' + cxr.responseText);
            }else{
                res=cxr.responseText.split("####");

                getById("schedules-table").innerHTML=res[0];
                getById("pageDisplay").innerHTML=res[1];

                document.body.style.cursor='default';
            }
        }
        else {
            error_catch(cxr.status);
        }
   }
}

function openPage(page){
    var date=getById("src_date").value;    
    var to=getById("src_teacher");
    var to=to.options[to.selectedIndex].value;
    var fak=getById("src_faculty");
    var fak=fak.options[fak.selectedIndex].value;
    var seso=getById("src_session");
    var seso=seso.options[seso.selectedIndex].value;
    var so=getById("src_subject");
    var so=so.options[so.selectedIndex].value;
    var sto=getById("src_status");
    var sto=sto.options[sto.selectedIndex].value;
    
   param="proc=openPage" + "&date=" + date + "&to=" + to + "&fak=" + fak + "&seso=" + seso + "&so=" + so + "&sto=" + sto + "&page=" + page;
   tujuan="do_setup_schedule.php";
   
   post_response_text(tujuan, param, respog);
   function respog()
   {
       if(cxr.readyState==4 && cxr.status == 200) {
            if (!isSaveResponse(cxr.responseText)) {
                alert('ERROR DETECTED,\n' + cxr.responseText);
            }else{
                res=cxr.responseText.split("####");

                getById("schedules-table").innerHTML=res[0];
                getById("pageDisplay").innerHTML=res[1];

                document.body.style.cursor='default';
            }
        }
        else {
            error_catch(cxr.status);
        }
   }
}

function deleteData(sesid){
    if(confirm('Are you sure to delete data? This can be undone!') === true){
        param="proc=deleteData" + "&ses_id=" + sesid;
        tujuan="do_setup_schedule.php";
        
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

                    if(res[0] === '2'){
                        alert('Error while deleting data!');
                    }
                    
                    if(res[0] === '3'){
                        $('#modalActive'+rP[0]).closeModal();
                        alert('Classroom already in use!');
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

function setActive(modalid){
    $('#modalActive'+modalid).openModal();
}

function changeState(receivedParam){
    rP = receivedParam.split("###");
    
    var classroom=getById("input_cl"+rP[0]).value;
    
    if(classroom === ''){
        alert("Classroom is required!");
        return;
    }
    
    param="proc=setStatus";
    if(rP[1] === '1'){
         param+="&id=" + rP[0] + "&state=" + rP[1] + "&classroom=" + classroom;
    }else{
        param+="&id=" + rP[0] + "&state=" + rP[1] + "&classroom=" + classroom;
    }
    
    tujuan="do_setup_schedule.php";
    post_response_text(tujuan, param, respog);
        function respog()
        {
            if(cxr.readyState==4 && cxr.status == 200) {
                if (!isSaveResponse(cxr.responseText)) {
                    alert('ERROR DETECTED,\n' + cxr.responseText);
                }
                else {
                    alert(cxr.responseText);
    
                    res=cxr.responseText.split("###");

                    if(res[0] === '1'){
                        alert('Status changed!');
                        $('#modalActive'+rP[0]).closeModal();
                        loadData();
                    }

                    if(res[0] === '0'){
                        $('#modalActive'+rP[0]).closeModal();
                        alert('Error while changing status!');
                    }

                    document.body.style.cursor='default';
                }
            }
            else {
                error_catch(cxr.status);
            }
        }
}