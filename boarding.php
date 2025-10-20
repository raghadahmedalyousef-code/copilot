<?php
session_start();
if (!isset($_SESSION['username'])) {
  echo "<h2 style='font-family: Arial; text-align: center; margin-top: 100px;'>You are not logged in. <a href='login.html'>Login here</a></h2>";
  exit();
}
include 'layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Boarding Pass | CoPilot</title>
  <style>




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
  z-index: 1000;
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

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #eef2f5;
      color: #333;
    }
    .main {
      padding: 40px 20px;
      text-align: center;
    }
    h1 {
      color: #005564;
    }
    .section {
      margin-top: 40px;
    }
    .section h2 {
      color: #00778A;
      border-bottom: 2px solid #ccc;
      padding-bottom: 10px;
    }
    .ticket {
      background-color: white;
      padding: 20px;
      margin: 20px auto;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      max-width: 550px;
      text-align: left;
      position: relative;
      transition: all 0.3s ease;
    }
    .ticket-details {
      display: none;
      margin-top: 10px;
    }
    .qr-code {
      position: absolute;
      top: 20px;
      right: 20px;
      width: 80px;
      height: 80px;
    }
    .status-active {
      color: green;
      font-weight: bold;
    }
    .status-past {
      color: gray;
      font-style: italic;
    }
    .download-btn {
      display: inline-block;
      margin-top: 10px;
      padding: 8px 16px;
      background-color: #005564;
      color: white;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      font-size: 14px;
    }
    .download-btn:hover {
      background-color: #00778A;
    }
    .toggle-btn {
      margin-top: 15px;
      background: #ccc;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      cursor: pointer;
    }
    .map {
      margin-top: 20px;
      height: 250px;
      border-radius: 10px;
      overflow: hidden;
    }
    @media (max-width: 600px) {
      .qr-code {
        position: static;
        display: block;
        margin: 10px auto;
      }
    }
    .dark-mode {
      background-color: #1e1e1e;
      color: #eee;
    }
    .dark-mode .ticket {
      background-color: #2d2d2d;
      color: #eee;
    }
    .dark-mode .download-btn {
      background-color: #444;
    }
  </style>
</head>
<body>

  <div class="main" style="padding-top: 80px;">
  <h1 style="margin-bottom: 30px;">🎫 My Boarding Passes</h1>


    <div class="section">
      <h2>🟢 Active Ticket</h2>
      <div class="ticket">
        <img class="qr-code" src="qrcodes_boarding/QR3030_qr.png" alt="QR">
        <p><strong>Flight:</strong> SV1234</p>
        <p><strong>Status:</strong> <span class="status-active">Active</span></p>
        <p id="countdown"></p>
        <button class="toggle-btn" onclick="toggleDetails(this)">Show Details</button>

        <div class="ticket-details">
          <p><strong>Name:</strong> <?php echo $_SESSION['username']; ?></p>
          <p><strong>From:</strong> JED</p>
          <p><strong>To:</strong> RUH</p>
          <p><strong>Seat:</strong> 12A</p>
          <p><strong>Gate:</strong> B3</p>
          <p><strong>Date:</strong> April 25, 2025</p>
          <a class="download-btn" href="#">📄 Download PDF</a>
          <div class="map">
            <iframe src="https://maps.google.com/maps?q=King Khalid International Airport&t=&z=15&ie=UTF8&iwloc=&output=embed"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
        </div>
      </div>
    </div>

    <div class="section">
      <h2>🕘 Past Ticket</h2>
      <div class="ticket">
        <img class="qr-code" src="qrcodes_boarding/SV2024_qr.png" alt="QR">
        <p><strong>Flight:</strong> EY5678</p>
        <p><strong>Status:</strong> <span class="status-past">Completed</span></p>
        <button class="toggle-btn" onclick="toggleDetails(this)">Show Details</button>

        <div class="ticket-details">
          <p><strong>Name:</strong> <?php echo $_SESSION['username']; ?></p>
          <p><strong>From:</strong> DMM</p>
          <p><strong>To:</strong> AUH</p>
          <p><strong>Seat:</strong> 8C</p>
          <p><strong>Gate:</strong> A1</p>
          <p><strong>Date:</strong> March 15, 2025</p>
          <a class="download-btn" href="#">📄 Download PDF</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    function toggleDetails(btn) {
      const details = btn.nextElementSibling;
      const isVisible = details.style.display === "block";
      details.style.display = isVisible ? "none" : "block";
      btn.textContent = isVisible ? "Show Details" : "Hide Details";
    }

    // Countdown
    const countdownElement = document.getElementById("countdown");
    const flightTime = new Date("2025-04-25T14:30:00").getTime();

    function updateCountdown() {
      const now = new Date().getTime();
      const diff = flightTime - now;

      if (diff <= 0) {
        countdownElement.innerHTML = "Boarding closed.";
        return;
      }

      const h = Math.floor(diff / (1000 * 60 * 60));
      const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const s = Math.floor((diff % (1000 * 60)) / 1000);

      countdownElement.innerHTML = `<strong>Boarding in:</strong> ${h}h ${m}m ${s}s`;
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
  </script>





  <!-- Chatbot Trigger -->
  <div class="chatbot-icon" onclick="toggleChatbot()">💬</div>

<!-- Chatbot Box -->
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
<script>
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
</script>

</body>
</html>
