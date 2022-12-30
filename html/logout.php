<?php
include_once __DIR__ . '/../src/Mapper/UserMapper.php';
$userMapper = new UserMapper();
$userMapper->logoutUser();
die();
?>