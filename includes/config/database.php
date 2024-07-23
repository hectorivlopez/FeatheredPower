<?php

$db = new mysqli('db-server:3306', 'root', '12', 'feathered_power');

if($db -> connect_errno) {
  die("Fail to connect" . $db -> connect_errno);
}

?>