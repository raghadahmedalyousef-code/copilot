<?php
session_start();
if (!isset($_SESSION['username'])) {
  echo "<h2 style='font-family: Arial; text-align: center; margin-top: 100px;'>You are not logged in. <a href='login.html'>Login here</a></h2>";
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home | CoPilot</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #eef2f5;
      color: #333;
      transition: background-color 0.3s, color 0.3s;
    }
    .dark-mode {
      background-color: #1e1e1e;
      color: #f0f0f0;
    }
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #005564;
      padding: 15px 30px;
      color: white;
      position: relative;
      z-index: 1001;
    }
    .navbar .logo {
      font-weight: bold;
      font-size: 20px;
    }
    .navbar .menu {
      display: flex;
      align-items: center;
    }
    .navbar .menu a {
      margin-left: 20px;
      color: white;
      text-decoration: none;
      font-weight: 500;
    }
    .navbar .menu a[href="logout.php"] {
      background-color: #c0392b;
      padding: 8px 16px;
      border-radius: 5px;
      color: white;
    }
    .navbar .menu a[href="logout.php"]:hover {
      background-color: #e74c3c;
    }
    .navbar .menu a:hover {
      text-decoration: underline;
    }
    .sidebar-toggle, .darkmode-toggle {
      background-color: #ffffff33;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      margin-right: 10px;
    }
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 220px;
      background-color: #005564;
      padding: 80px 20px 20px;
      display: flex;
      flex-direction: column;
      transition: transform 0.3s ease;
      transform: translateX(-100%);
      z-index: 1000;
    }
    .sidebar.active {
      transform: translateX(0);
    }
    .sidebar a {
      color: white;
      padding: 10px;
      margin: 8px 0;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      transition: background-color 0.2s ease;
    }
    .sidebar a:hover {
      background-color: #ffffff;
      color: #005564;
    }
    .main {
      padding: 40px 20px;
      text-align: center;
      margin-left: 0;
    }
    .main h1 {
      color: #005564;
    }
    .widgets {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin-top: 40px;
    }
    .widget {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 250px;
      text-align: left;
      transition: transform 0.3s ease;
    }
    .dark-mode .widget {
      background: #2d2d2d;
      color: #f0f0f0;
    }
    .widget:hover {
      transform: translateY(-5px);
    }
    .widget h3 {
      color: #005564;
      margin-bottom: 10px;
    }
    .dark-mode .widget h3 {
      color: #7fdbff;
    }
    .widget p {
      font-size: 14px;
    }
    .map-container {
      margin: 40px auto;
      max-width: 800px;
      height: 400px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .chatbot-icon {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #005564;
      color: white;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      font-size: 22px;
      z-index: 1000;
    }
    .chatbot-box {
      position: fixed;
      bottom: 80px;
      right: 20px;
      width: 300px;
      max-height: 400px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
      display: none;
      flex-direction: column;
      overflow: hidden;
    }
    .chatbot-header {
      background: #005564;
      color: white;
      padding: 10px;
      text-align: center;
    }
    .chatbot-messages {
      flex: 1;
      padding: 10px;
      overflow-y: auto;
      font-size: 14px;
    }
    .chatbot-input {
      display: flex;
      border-top: 1px solid #ccc;
    }
    .chatbot-input input {
      flex: 1;
      border: none;
      padding: 10px;
    }
    .chatbot-input button {
      padding: 10px;
      border: none;
      background: #005564;
      color: white;
      cursor: pointer;
    }
  </style>
  <script>
    function toggleSidebar() {
      document.querySelector('.sidebar').classList.toggle('active');
    }
    function toggleChatbot() {
      const box = document.getElementById("chatbotBox");
      box.style.display = box.style.display === "flex" ? "none" : "flex";
    }
    function sendMessage() {
      const input = document.getElementById("chatInput");
      const messages = document.getElementById("chatbotMessages");
      const text = input.value.trim();
      if (text) {
        const userMsg = document.createElement("p");
        userMsg.innerHTML = `<strong>You:</strong> ${text}`;
        messages.appendChild(userMsg);
        input.value = "";
        setTimeout(() => {
          const botMsg = document.createElement("p");
          botMsg.innerHTML = `<strong>Bot:</strong> I'm just a dummy bot for now ✨`;
          messages.appendChild(botMsg);
          messages.scrollTop = messages.scrollHeight;
        }, 500);
      }
    }
    function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
    }
  </script>
</head>
<body>
  <div class="navbar">
    <div>
      <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
      <button class="darkmode-toggle" onclick="toggleDarkMode()">🌓</button>
    </div>
    <div class="logo">CoPilot</div>
    <div class="menu">
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="sidebar">
    <a href="homepage.php">Home</a>
    <a href="flights.php">Flight Tracker</a>
    <a href="luggage.php">Luggage Tracker</a>
    <a href="assistant.php">Smart Assistant</a>
    <a href="boarding.php">Boarding Pass</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="main">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h1>

    <div class="widgets">
      <div class="widget">
        <h3>Flight Tracker</h3>
        <p>Track your flight status and gate info in real-time. <a href="flights.php">Open</a></p>
      </div>
      <div class="widget">
        <h3>Luggage Tracker</h3>
        <p>Monitor your baggage location and get updates. <a href="luggage.php">Open</a></p>
      </div>
      <div class="widget">
        <h3>Smart Assistant</h3>
        <p>Ask anything — from gate changes to airport services. <a href="assistant.php">Open</a></p>
      </div>
      <div class="widget">
        <h3>Boarding Pass</h3>
        <p>View your active and past tickets. <a href="boarding.php">Open</a></p>
      </div>
    </div>

    <div class="map-container">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3623.215191387199!2d46.72545507533641!3d24.774265948096295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f03d95e89c9d5%3A0x9e4f3c5e24a4625e!2sKing%20Khalid%20International%20Airport!5e0!3m2!1sen!2ssa!4v1713600000000!5m2!1sen!2ssa" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>

  <div class="chatbot-icon" onclick="toggleChatbot()">💬</div>
  <div class="chatbot-box" id="chatbotBox">
    <div class="chatbot-header">Smart Assistant</div>
    <div class="chatbot-messages" id="chatbotMessages">
      <p><strong>Bot:</strong> Hi! How can I help you today?</p>
    </div>
    <div class="chatbot-input">
      <input type="text" id="chatInput" placeholder="Type a message...">
      <button onclick="sendMessage()">Send</button>
    </div>
  </div>
</body>
</html>
