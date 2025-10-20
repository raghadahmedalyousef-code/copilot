<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit();
}
include 'layout.php';
?>

<div class="main-content" style="max-width: 700px; margin: auto;">
  <h1 style="color: #005564; margin-top: 20px;">📢 Report Missing Luggage</h1>
  <p style="font-size: 16px;">Please fill out the form below to report a lost bag. We’ll follow up shortly.</p>

  <form action="submit_report.php" method="POST" style="margin-top: 30px;">
    <label for="fullName">Full Name:</label><br>
    <input type="text" id="fullName" name="fullName" required 
           style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;"><br>

    <label for="flightNo">Flight Number:</label><br>
    <input type="text" id="flightNo" name="flightNo" required 
           style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;"><br>

    <label for="tagId">Baggage Tag ID:</label><br>
    <input type="text" id="tagId" name="tagId" required 
           style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px;"><br>

    <label for="details">Details (Where did you lose it?):</label><br>
    <textarea id="details" name="details" rows="5" required
              style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 6px;"></textarea><br>

    <button type="submit" style="padding: 10px 20px; background-color: #005564; color: white; border: none; border-radius: 6px; cursor: pointer;">
      Submit Report
    </button>
  </form>
</div>

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