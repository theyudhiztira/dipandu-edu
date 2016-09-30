/* 
 * Pandu Yudhistira, Jakarta 21 Sepetember 2016 4:45 AM
 */

function checkDouble(id){
    data = document.getElementById(id).value;
    
    param="proc=checkData" + "&data=" + data + "&dataType=" + id;
    tujuan="do_register.php";
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
                    
                    if(res[0] === '1'){
                        alert(res[1]);
                        document.getElementById(id).value='';
                        document.getElementById(id).focus();
                    }
                        
                    document.body.style.cursor='default';
                }
            }
            else {
                error_catch(cxr.status);
            }
        
    }
}

function passwordCheck(){
    password = document.getElementById('password').value;
    
    if(password.length < 8){
        alert("Password must be 8 characters or above!");
        document.getElementById('password').focus();
        document.getElementById('passwordAlert').style.display='block';
    }else{
        document.getElementById('passwordAlert').style.display='none';
    }
}

function passwordValidation(){
    password1 = document.getElementById('password');
    password2 = document.getElementById('passwordValidation');
    
    if(password2.value === password1.value){
        document.getElementById('passwordValidationAlert').style.display="none";
        return false;
    }else{
        password2.focus();
        document.getElementById('passwordValidationAlert').style.display="block";
    }
}

function runSignUp(){
    registration_number = document.getElementById('registration_number').value;
    fullname = document.getElementById('fullname').value;
    username = document.getElementById('username').value;
    password = document.getElementById('password').value;
    email = document.getElementById('email').value;
    captcha = document.getElementById('captcha').value;
    accountType = document.getElementById("accountType");
    accountType = accountType.options[accountType.selectedIndex].value;
    
    if(accountType === ''){
        alert("Account type is required");
        return;
    }
    
    if(fullname === ''){
        alert("Your name is required");
        return;
    }
    
    if(registration_number === ''){
        alert("Registration number is required");
        return;
    }
    
    if(username === ''){
        alert("Username is required");
        return;
    }
    
    if(password === ''){
        alert("Password is required");
        return;
    }
    
    if(email === ''){
        alert("NIM is required");
        return;
    }
    
    if(captcha === ''){
        alert("NIM is required");
        return;
    }
    
    
    var atpos = email.indexOf("@");
    var dotpos = email.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
        alert("Not a valid e-mail address!");
        document.getElementById('email').focus();
        document.getElementById('email').value='';
        return false;
    }
    
    param="proc=signUp" + "&registration_number=" + registration_number + "&fullname=" + fullname + "&username=" + username;
    param+="&password=" + password + "&email=" + email + "&account_type=" + accountType + "&captcha=" + captcha;
    
    tujuan="do_register.php";
    
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
                    
                    // Kalau salah
                    if(res[0] === 0){
                        alert(res[1]);
                        document.getElementById('captcha-img').src='captcha_generator.php';
                        location.reload();
                    }else{
                        alert(res[1]);
                        location.reload();
                    }
                    
                    
                    document.body.style.cursor='default';
                }
            }
            else {
                error_catch(cxr.status);
            }
        
    }
}

function doLogin(){
    username = document.getElementById('username');
    password = document.getElementById('password');
    accountType = document.getElementById("accountType");
    accountType = accountType.options[accountType.selectedIndex].value;
    
    if(accountType === ''){
        alert("Account type is required");
        document.getElementById("accountType").focus();
        return false;
    }
    
    if(username.value === ''){
        alert("Username is required");
        username.focus();
        return false;
    }
    
    param="proc=doLogin" + "&username=" + username.value + "&password=" + password.value + "&account_type=" + accountType;
    tujuan="do_login.php";
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
                    
                    if(res[2] === '1'){
                        nextPage='administrator.php';
                    }
                    
                    if(res[2] === '2'){
                        nextPage='student.php';
                    }
                    
                    if(res[2] === '3'){
                        nextPage='teacher.php';
                    }
                    
                    if(res[0] === '1'){
                        alert(res[1]);
                        location.replace(nextPage);
                    }
                    
                    if(res[0] === '0'){
                        alert(res[1]);
                        location.reload();
                    }
                        
                        
                    document.body.style.cursor='default';
                }
            }
            else {
                error_catch(cxr.status);
            }
        
    }
}
