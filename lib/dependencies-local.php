<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function sidebar_open(){
    echo "<div id='sidebar'>";
}

function mainDivOpen(){
    echo "<div class='main-div' id='main'>";
}


function divOpen($id="fill with id or fill it blank",$class="fill with id or fill it blank"){
   $div = "<div id='".$id."' class='".$class."'>";
   
   return $div;
}

function divClose(){
    echo "</div>";
}

function dependencies(){
    echo "<link rel='icon' href='./img/ico.png'>
      <link type='text/css' rel='stylesheet' href='css/materialize.min.css'>
      <link type='text/css' rel='stylesheet' href='css/font-awesome.min.css'>
      <link type='text/css' rel='stylesheet' href='css/dipandu.css'>
      <link type='text/css' rel='stylesheet' href='css/font-awesome-x.min.css'>
      <link rel='stylesheet' type='text/css' href='css/sweetalert.css'>
      <!-- Seo Meta -->
      <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
      <meta name='author' content='Pandu Yudhistira' />
      <meta name='title' content='DiPandu'>
      <meta name='description' content='DiPandu Smart'/>
      <meta name='keywords' content='programmer, php programmer, web programmer, php tutorial, php source codes, php apps'/>
      <meta name='robots' content='noindex,nofollow'>
      ";
}

function javaScriptCall(){
    echo "<script type='text/javascript' src='js/jquery.js'></script>
      <script type='text/javascript' src='js/materialize.js'></script>
      <script type='text/javascript' src='js/dipandu.js'></script>
      <script type='text/javascript' src='js/sweetalert.min.js'></script>";
}

function navigation_bar(){
    echo "<div class='row' style='margin-bottom: 50px;'>
            <nav class='navigation-bar'>
                <div class='nav-wrapper'>
                    <a class='brand-logo home-title'>DiPandu</a>
                    <a data-activates='mobile-demo' class='button-collapse'><i class='fa fa-caret-right' style='margin-left: 10px;'></i></a>
                    <ul class='right hide-on-med-and-down'>
                        <li><a>".$_SESSION['core']['username']." <i class='fa fa-cogs'></i></a></li>
                        <li onclick='openFile(\"development\")'><a><i class='fa fa-bell'></i> <span class='new badge red'>4</span></a></li>
                        <li onclick='logOut()'><a>Logout <i class='fa fa-lock'></i></a></li>
                    </ul>
                    <ul class='side-nav' id='mobile-demo'>
                        <li><a>User Settings</a></li>
                        <li onclick='openFile(\"development\")'><a>Notifications <span class='new badge red'>4</span></a></li>
                        <li onclick='logOut()'><a>Logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>";
}