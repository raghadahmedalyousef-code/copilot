<?php
if (!isset($_SESSION)) session_start();
?>

<style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    font-family: 'Segoe UI', sans-serif;
    transition: background-color 0.3s, color 0.3s;
    background-color: #eef2f5;
    color: #333;
  }

  .dark-mode {
    background-color: #1e1e1e;
    color: #f0f0f0;
  }

  .topbar {
    height: 60px;
    background-color: #005564;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 30px;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
  }

  .logo {
    font-weight: bold;
    font-size: 20px;
  }

  .sidebar-toggle {
    font-size: 24px;
    cursor: pointer;
    margin-right: 20px;
    background: none;
    border: none;
    color: white;
  }

  .dark-toggle {
    background: #fff;
    border: none;
    border-radius: 6px;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 14px;
  }

  .sidebar {
    position: fixed;
    top: 60px;
    left: 0;
    width: 250px;
    height: calc(100vh - 60px);
    background-color: #005564;
    color: white;
    padding: 20px;
    transition: transform 0.3s ease;
    z-index: 999;
  }

  .sidebar.closed {
    transform: translateX(-100%);
  }

  .sidebar a {
    display: block;
    margin-bottom: 15px;
    text-decoration: none;
    color: white;
    padding: 10px 12px;
    border-radius: 6px;
    transition: background 0.3s ease;
  }

  .sidebar a:hover {
    background-color: white;
    color: #005564;
  }

  .sidebar a.logout {
    background-color: #c0392b;
    color: white;
  }

  .sidebar a.logout:hover {
    background-color: #e74c3c;
  }

  .main-content {
    margin-top: 60px;
    margin-left: 250px;
    padding: 40px 30px;
    transition: margin-left 0.3s ease;
  }

  .sidebar.closed + .main-content {
    margin-left: 0;
  }
</style>

<div class="topbar">
  <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
  <div class="logo">CoPilot</div>
  <button class="dark-toggle" onclick="toggleDark()">🌓</button>
</div>

<div class="sidebar closed" id="sidebar">
  <a href="homepage.php">Home</a>
  <a href="flights.php">Flight Tracker</a>
  <a href="luggage.php">Luggage Tracker</a>
  <a href="assistant.php">Smart Assistant</a>
  <a href="boarding.php">Boarding Pass</a>
  <a class="logout" href="logout.php">Logout</a>
</div>

<script>
  function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("closed");
    document.querySelector(".main-content").classList.toggle("full");
  }

  function toggleDark() {
    document.body.classList.toggle("dark-mode");
    localStorage.setItem("copilotMode", document.body.classList.contains("dark-mode") ? "dark" : "light");
  }

  window.onload = function () {
    if (localStorage.getItem("copilotMode") === "dark") {
      document.body.classList.add("dark-mode");
    }
  };
</script>
