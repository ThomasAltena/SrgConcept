<?php
session_start();
session_unset();
session_destroy();
clearstatcache();
header('location:/SrgConcept/view/index.php');

?>