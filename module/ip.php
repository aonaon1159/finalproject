<?php
    @$ip = gethostbynamel($REMOTE_ADDR); 
    for ($i=0; $i<count($ip); $i++) 
    { 
        print $ip[$i]."<BR>"; 
    } 

?>
