<?php
session_start();
session_destroy();
$okmsg = base64_encode('Logout Successfully');
header("location: index.php?okmsg=$okmsg");
