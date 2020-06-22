<?php
session_unset();
session_destroy();
exit("<script>window.location = './';</script>");
?>
