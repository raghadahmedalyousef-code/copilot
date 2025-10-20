<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit();
}
include 'layout.php';
?>
<div class="main-content" style="max-width: 1000px; margin: auto;">
  <h1 style="color: #005564; margin-top: 20px;">🛫 Flight Tracker</h1>
  <p style="font-size: 16px;">Search for your flight and see live updates, countdowns, weather, and gate info.</p>

  <!-- Smart Search -->
  <form id="smartSearchForm" style="margin-top: 20px; display: flex; gap: 10px; max-width: 400px;">
    <input list="flights" id="flightInput" placeholder="Type flight number..." 
           style="flex: 1; padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px;" required>
    <button type="submit" 
            style="padding: 8px 16px; background: #005564; color: white; border: none; border-radius: 6px; cursor: pointer;">
      Search
    </button>
  </form>

  <datalist id="flights">
    <?php
    $flightNumbers = ["SV1234","QR567","EY891","SV300","QR905","EK712","RJ456","SV001","BA222","AF600","LH301","KU998","AI120","QR118","TK789","SV777","QR320","BA200","ME010","AZ450"];
    foreach ($flightNumbers as $flight) {
      echo "<option value='$flight'>";
    }
    ?>
  </datalist>

  <div id="flightResult" style="margin-top: 30px;"></div>

  <!-- Dummy Weather -->
  <div style="margin-top: 30px;">
    <h3 style="color: #005564;">🌤 Airport Weather</h3>
    <p>JED → 32°C Sunny | RUH → 34°C Cloudy</p>
  </div>

  <!-- Upcoming Flights -->
  <h2 style="margin-top: 50px; color: #005564;">📋 Upcoming Flights</h2>
  <div style="overflow-x:auto;">
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
      <thead style="background: #005564; color: white;">
        <tr>
          <th>Flight</th><th>From</th><th>To</th><th>Gate</th><th>Time</th><th>Status</th><th>QR</th><th>Countdown</th>
        </tr>
      </thead>
      <tbody style="background: white; text-align: center;">
        <?php
        $flights = [
          ["SV1234", "JED", "RUH", "B3", "18:30", "On Time"],
          ["QR567", "DOH", "JED", "A2", "19:15", "Delayed"],
          ["EY891", "AUH", "DMM", "C1", "20:00", "Boarding"],
          ["SV300", "JED", "DMM", "B5", "21:00", "On Time"],
          ["QR905", "DOH", "MED", "A1", "22:15", "On Time"],
          ["EK712", "DXB", "JED", "C2", "23:45", "Boarding"],
          ["RJ456", "AMM", "RUH", "D3", "00:30", "Delayed"],
          ["SV001", "JED", "CAI", "E1", "01:15", "On Time"],
          ["BA222", "LHR", "JED", "B2", "02:10", "On Time"],
          ["AF600", "CDG", "RUH", "A4", "03:00", "Delayed"],
          ["LH301", "FRA", "DMM", "C4", "03:45", "On Time"],
          ["KU998", "KWI", "MED", "D2", "04:30", "Boarding"],
          ["AI120", "DEL", "RUH", "A6", "05:20", "On Time"],
          ["QR118", "DOH", "JED", "B1", "06:15", "On Time"],
          ["TK789", "IST", "DMM", "B7", "07:05", "Delayed"],
          ["SV777", "JED", "DXB", "C6", "08:00", "On Time"],
          ["QR320", "DOH", "MED", "D1", "08:50", "Boarding"],
          ["BA200", "LHR", "RUH", "E3", "09:40", "On Time"],
          ["ME010", "BEY", "JED", "A3", "10:25", "On Time"],
          ["AZ450", "FCO", "DMM", "B8", "11:15", "Delayed"]
        ];
        foreach ($flights as $f) {
          echo "<tr>
                  <td>{$f[0]}</td><td>{$f[1]}</td><td>{$f[2]}</td><td>{$f[3]}</td><td>{$f[4]}</td>
                  <td>{$f[5]}</td>
                  <td><img src='https://api.qrserver.com/v1/create-qr-code/?size=40x40&data={$f[0]}'></td>
                  <td><span class='countdown' data-time='{$f[4]}'></span></td>
                </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Dummy Airport Map -->
  <div style="margin-top: 50px;">
    <h2 style="color: #005564;">📍 Airport Map</h2>
    <div style="width: 100%; height: 400px; border-radius: 12px; overflow: hidden; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3623.215191387199!2d46.72545507533641!3d24.774265948096295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f03d95e89c9d5%3A0x9e4f3c5e24a4625e!2sKing%20Khalid%20International%20Airport!5e0!3m2!1sen!2ssa!4v1713600000000!5m2!1sen!2ssa"
        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
      </iframe>
    </div>
  </div>
</div>

<script>
  // Search form logic
  document.getElementById("smartSearchForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const value = document.getElementById("flightInput").value.trim().toUpperCase();
    const box = document.getElementById("flightResult");

    if (value === "SV1234") {
      box.innerHTML = `
        <div style="background: #eef2f5; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-top: 20px;">
          <h3 style="color: #005564;">Flight ${value} Info</h3>
          <p><strong>From:</strong> JED</p>
          <p><strong>To:</strong> RUH</p>
          <p><strong>Status:</strong> On Time</p>
          <p><strong>Boarding:</strong> 18:10</p>
        </div>`;
    } else {
      box.innerHTML = `<p style="color: red;">Flight "${value}" not found.</p>`;
    }
  });

  // Countdown timer logic
  function updateCountdowns() {
    const spans = document.querySelectorAll('.countdown');
    spans.forEach(span => {
      const timeStr = span.getAttribute('data-time');
      if (!timeStr) return;

      const now = new Date();
      const [hrs, mins] = timeStr.split(':');
      const target = new Date(now);
      target.setHours(parseInt(hrs), parseInt(mins), 0, 0);

      const diff = target - now;
      if (diff < 0) {
        span.innerText = "Departed";
      } else {
        const h = Math.floor(diff / (1000 * 60 * 60));
        const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const s = Math.floor((diff % (1000 * 60)) / 1000);
        span.innerText = `${h}h ${m}m ${s}s`;
      }
    });
  }
  setInterval(updateCountdowns, 1000);
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