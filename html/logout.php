<?php
include_once __DIR__ . '/../src/UserMapper.php';
$userMapper = new UserMapper();
$userMapper->logoutUser();
die();
?>