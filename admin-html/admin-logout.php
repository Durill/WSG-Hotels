<?php
include_once __DIR__ . '/../src/Mapper/AdminMapper.php';
$adminMapper = new AdminMapper();
$adminMapper->logoutAdmin();
die();
?>