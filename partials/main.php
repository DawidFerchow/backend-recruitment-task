<?php
// Please add your logic here
echo "<h1 class='starting-title'>Nice to see you! &#128075;</h1>";

include_once("controller/UserController.php");

$controller = new UserController();
$controller->invoke();
