<?php
session_start();
session_destroy();
header("Location:../index.php?msg=logout");
exit(); // It's created by Er. Hrisheekesh Kumar
?>
