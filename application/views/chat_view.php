<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Chat Window</title>
  <style>
    #chatBox {
      width: 400px;
      height: 300px;
      border: 1px solid #ccc;
      overflow-y: scroll;
      padding: 10px;
      margin-bottom: 10px;
    }
    .message {
      margin-bottom: 5px;
    }
    .message .from {
      font-weight: bold;
    }
    .message .time {
      font-size: 0.8em;
      color: #999;
    }
    #messageInput {
      width: 300px;
    }
  </style>
</head>
<body>
  <h2>Chat Window</h2>
  <div id="chatBox" aria-live="polite" aria-label="Chat messages"></div>

  <input type="text" id="messageInput" placeholder="Type your message..." aria-label="Message input" />
  <button id="sendBtn">Send</button>

  <script>
    const otherUserId = <?= isset($otherUserId) ? $otherUserId : 'null'; ?>;

    function escapeHtml(unsafe) {
      return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }

    async function fetchMessages() {
      if (!otherUserId) return;

      try {
        const res = await fetch("<?= base_url('chat/fetch_messages'); ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `otherUserId=${encodeURIComponent(otherUserId)}`,
        });

        const messages = await res.json();
        const chatBox = document.getElementById("chatBox");
        chatBox.innerHTML = "";

        messages.forEach((msg) => {
          const from = msg.from_user_id == otherUserId ? "Them" : "Me";
          const safeText = escapeHtml(msg.message);
          const createdAt = escapeHtml(msg.created_at);

          const msgHtml = `
            <div class="message">
              <span class="from">${from}: </span>
              <span class="text">${safeText}</span>
              <span class="time">(${createdAt})</span>
            </div>`;
          chatBox.innerHTML += msgHtml;
        });

        chatBox.scrollTop = chatBox.scrollHeight;
      } catch (error) {
        console.error("Error fetching messages:", error);
      }
    }

    async function sendMessage() {
      const input = document.getElementById("messageInput");
      const message = input.value.trim();
      if (!message) return;

      try {
        await fetch("<?= base_url('chat/send_message'); ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `otherUserId=${encodeURIComponent(otherUserId)}&message=${encodeURIComponent(message)}`,
        });

        input.value = "";
        fetchMessages();
      } catch (error) {
        console.error("Error sending message:", error);
      }
    }

    document.getElementById("sendBtn").addEventListener("click", sendMessage);

    document.getElementById("messageInput").addEventListener("keydown", function (e) {
      if (e.key === "Enter") {
        sendMessage();
      }
    });

    document.addEventListener("DOMContentLoaded", () => {
      if (otherUserId) {
        fetchMessages();
        setInterval(fetchMessages, 5000);
      }
    });
  </script>
</body>
</html>
