<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit();
}
include 'layout.php';
?>

<div class="main-content" style="max-width: 1000px; margin: auto;">
  <h1 style="color: #005564; margin-top: 20px;">🧳 Luggage Tracker</h1>
  <p style="font-size: 16px;">Track your luggage using your baggage tag or reference number.</p>

  <!-- Search -->
  <form id="luggageForm" style="margin-top: 20px; display: flex; gap: 10px; max-width: 400px;">
    <input type="text" id="luggageId" placeholder="Enter baggage tag..." 
           style="flex: 1; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;" required>
    <button type="submit" 
            style="padding: 8px 16px; background: #005564; color: white; border: none; border-radius: 6px; cursor: pointer;">
      Track
    </button>
  </form>

  <!-- Result -->
  <div id="luggageResult" style="margin-top: 30px;"></div>
  <audio id="statusSound"></audio>

  <!-- Table -->
  <h2 style="margin-top: 50px; color: #005564;">📦 Active Luggage</h2>
  <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <thead style="background: #005564; color: white;">
      <tr>
        <th>Tag ID</th><th>Passenger</th><th>Flight</th><th>Status</th><th>QR Code</th>
      </tr>
    </thead>
    <tbody style="background: white; text-align: center;">
      <?php
      $bags = [
        ["BG001", $_SESSION['username'], "SV1234", "Arrived"],
        ["BG002", $_SESSION['username'], "QR567", "In Transit"],
        ["BG003", $_SESSION['username'], "EY891", "Missing"],
      ];
      foreach ($bags as $b) {
        echo "<tr>
                <td>{$b[0]}</td><td>{$b[1]}</td><td>{$b[2]}</td><td>{$b[3]}</td>
                <td><img src='https://api.qrserver.com/v1/create-qr-code/?size=60x60&data={$b[0]}'></td>
              </tr>";
      }
      ?>
    </tbody>
  </table>

  <!-- Airport Map (Dummy) -->
  <div style="margin-top: 50px;">
    <h2 style="color: #005564;">📍 Baggage Claim Map</h2>
    <div style="width: 100%; height: 400px; border-radius: 12px; overflow: hidden; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
      <iframe
        src="https://maps.google.com/maps?q=king%20khalid%20airport&t=&z=15&ie=UTF8&iwloc=&output=embed"
        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
      </iframe>
    </div>
  </div>

  <!-- Report Missing Luggage -->
  <div style="margin-top: 40px;">
    <a href="report_luggage.php" style="padding: 12px 20px; background-color: #c0392b; color: white; border-radius: 8px; text-decoration: none;">
      Report Missing Luggage
    </a>
  </div>
</div>

<script>
  document.getElementById("luggageForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const tag = document.getElementById("luggageId").value.trim().toUpperCase();
    const resultBox = document.getElementById("luggageResult");
    const sound = document.getElementById("statusSound");

    const data = {
      "BG001": "Arrived at RUH - Carousel B",
      "BG002": "In Transit - Expected 19:40",
      "BG003": "⚠️ Tag Not Found. Please contact baggage services."
    };

    const message = data[tag] || `No luggage found with tag: ${tag}`;
    resultBox.innerHTML = `<p><strong>Status:</strong> ${message}</p>`;

    // Voice feedback
    const speak = new SpeechSynthesisUtterance(message);
    window.speechSynthesis.speak(speak);
  });
</script>

<body>


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

</style>