<?php 
    if (!isset($_SESSION["uID"])){
        exit("<script>window.location = './';</script>");
    }
    if ($_SESSION["level"] == 1) {
         exit("<script>window.location = './';</script>");
     }
 ?>