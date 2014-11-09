<?php
require_once("../../includes/config.php");
$con->update("UPDATE usermessages SET status=1 WHERE receiverId='".$_SESSION['userId']."' and  status=0")
?>