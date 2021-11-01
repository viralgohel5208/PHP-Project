<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_SESSION["cu_login"]) && $_SESSION["cu_login"] == "YES")
{
    
}
else
{
    header("Location:login.php");
}