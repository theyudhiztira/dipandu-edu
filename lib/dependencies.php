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
    echo "<link type='text/css' rel='stylesheet' href='css/materialize.min.css'>
      <link type='text/css' rel='stylesheet' href='css/font-awesome.min.css'>
      <link type='text/css' rel='stylesheet' href='css/dipandu.css'>
      <link type='text/css' rel='stylesheet' href='css/font-awesome-x.min.css'>
      <!-- Seo Meta -->
      <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
      <meta name='author' content='Pandu Yudhistira' />
      <meta name='title' content='DiPandu'>
      <meta name='description' content='My Personal Website'/>
      <meta name='keywords' content='programmer, php programmer, web programmer, php tutorial, php source codes, php apps'/>
      <meta name='robots' content='noindex,nofollow'>
      ";
}

function javaScriptCall(){
    echo "<script type='text/javascript' src='js/jquery.js'></script>
      <script type='text/javascript' src='js/materialize.js'></script>
      <script type='text/javascript' src='js/dipandu.js'></script>";
}