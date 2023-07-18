<?php

$db = new mysqli('localhost', 'root', '', 'feathered_power');

if($db -> connect_errno) {
  die("Fail to connect" . $db -> connect_errno);
}

?>