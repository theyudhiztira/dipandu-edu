/* 
 * Pandu Yudhistira
 * Jakarta , 20 Sept 2016
 */

function openFile(filename){
    location.replace('./'+filename+'.php');
}

$(document).ready(function(){
    $(".button-collapse").sideNav({
        menuWidth: 200
    });
    $('select').material_select();
});

function logOut(){
    location.replace('logout.php');
}