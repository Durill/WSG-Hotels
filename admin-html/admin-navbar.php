<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>BSG - Admin Panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" href="#">Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Rezerwacje</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin-rooms.php">Pokoje</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin-logout.php">Wyloguj</a>
      </li>
    </ul>
  </div>
</nav>

