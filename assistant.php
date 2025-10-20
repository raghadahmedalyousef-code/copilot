<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit();
}
include 'layout.php';
?>

<!-- Assistant Content -->
<div style="text-align: center; padding-top: 100px;">
  <h1 style="color: #005564; font-size: 32px; margin-bottom: 10px;">🤖 Smart Assistant</h1>
  <p style="font-size: 16px; margin-bottom: 30px;">Ask me anything! I’ll try my best to help 💡</p>

  <div style="max-width: 600px; margin: auto;">
    <div id="chatbox" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1); min-height: 250px; text-align: left; overflow-y: auto; font-size: 14px;">
      <p><strong>Assistant:</strong> Hello <?php echo $_SESSION['username']; ?>! How can I help you today?</p>
    </div>

    <div style="display: flex; margin-top: 15px;">
      <input type="text" id="chatInput" placeholder="Type your message..." style="flex: 1; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
      <button onclick="sendMessage()" style="margin-left: 10px; padding: 10px 20px; background: #005564; color: white; border: none; border-radius: 6px;">Send</button>
    </div>

    <div style="margin-top: 20px;">
      <p style="font-size: 13px; color: #777;">Try one of these:</p>
      <div style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-bottom: 15px;">
        <button onclick="quickReply('Where is my gate?')">Where is my gate?</button>
        <button onclick="quickReply('Track my luggage')">Track my luggage</button>
        <button onclick="quickReply('Show boarding pass')">Show boarding pass</button>
        <button onclick="quickReply('Next flight time')">Next flight time</button>
      </div>
      <button onclick="clearChat()" style="background-color: #c0392b; color: white; padding: 6px 14px; border: none; border-radius: 6px;">🗑️ Clear Conversation</button>
    </div>
  </div>
</div>

<script>
  function sendMessage() {
    const input = document.getElementById("chatInput");
    const chatbox = document.getElementById("chatbox");
    const msg = input.value.trim();
    if (msg) {
      chatbox.innerHTML += `<p><strong>You:</strong> ${msg}</p>`;
      input.value = "";
      setTimeout(() => {
        chatbox.innerHTML += `<p><strong>Assistant:</strong> Sorry, I'm still learning. 😅</p>`;
        chatbox.scrollTop = chatbox.scrollHeight;
      }, 500);
    }
  }

  function quickReply(text) {
    document.getElementById("chatInput").value = text;
    sendMessage();
  }

  function clearChat() {
    document.getElementById("chatbox").innerHTML = `<p><strong>Assistant:</strong> Hello <?php echo $_SESSION['username']; ?>! How can I help you today?</p>`;
  }
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
  button {
    background-color: #eee;
    border: none;
    border-radius: 6px;
    padding: 8px 14px;
    cursor: pointer;
    font-size: 13px;
  }

  button:hover {
    background-color: #ddd;
  }

  .dark-mode #chatbox {
    background-color: #2e2e2e;
    color: #f0f0f0;
  }

  .dark-mode button {
    background-color: #3a3a3a;
    color: #fff;
  }

  .dark-mode input {
    background-color: #444;
    color: #fff;
    border: 1px solid #666;
  }
  <style>
  body {
    background-color: #f4f6f9;
    color: #333;
  }

  .dark-mode body {
    background-color: #1e1e1e;
    color: #f0f0f0;
  }

  #chatbox {
    background: white;
    color: #333;
  }

  .dark-mode #chatbox {
    background: #2c2c2c;
    color: #f0f0f0;
  }

  .dark-mode input,
  .dark-mode textarea {
    background-color: #3a3a3a;
    color: #f0f0f0;
    border: 1px solid #555;
  }

  .dark-mode button {
    background-color: #444 !important;
    color: #fff !important;
  }

  .dark-mode .chat-title {
    color: #fff !important;
  }

  .dark-mode .quick-buttons button {
    background-color: #444;
    color: white;
  }

  .dark-mode .quick-buttons button:hover {
    background-color: #555;
  }

  .dark-mode .clear-button {
    background-color: #a93226;
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


