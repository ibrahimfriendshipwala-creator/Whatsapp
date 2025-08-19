<?php
session_start();
if (!isset($_SESSION['userid'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
include "db.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>WhatsApp Clone</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      display: flex;
      background: #ddd;
    }

    .sidebar {
      width: 25%;
      background: #f0f0f0;
      border-right: 2px solid #ccc;
      overflow-y: auto;
      padding: 15px;
    }

    .sidebar h3 {
      margin-bottom: 10px;
      color: #075e54;
    }

    .user {
      background: white;
      margin: 8px 0;
      padding: 12px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      color: #333;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      transition: all 0.2s ease;
    }

    .user:hover {
      background: #dcf8c6;
      transform: translateX(5px);
    }

    .chat-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      background: #e5ddd5;
    }

    .header {
      background: #075e54;
      color: white;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 16px;
      font-weight: bold;
    }

    .header a {
      color: #fff;
      text-decoration: none;
      font-size: 14px;
      font-weight: normal;
      background: #128C7E;
      padding: 5px 10px;
      border-radius: 5px;
    }

    .chat-box {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
      background: #fff;
      display: flex;
      flex-direction: column;
    }

    .message {
      max-width: 70%;
      padding: 10px 15px;
      margin-bottom: 10px;
      border-radius: 10px;
      font-size: 14px;
      line-height: 1.4;
      word-wrap: break-word;
    }

    .outgoing {
      background: #dcf8c6;
      align-self: flex-end;
      border-bottom-right-radius: 0;
    }

    .incoming {
      background: #e6e6e6;
      align-self: flex-start;
      border-bottom-left-radius: 0;
    }

    .chat-input {
      display: flex;
      padding: 15px;
      background: #f0f0f0;
      border-top: 2px solid #ccc;
    }

    .chat-input input {
      flex: 1;
      padding: 12px 15px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 25px;
      outline: none;
    }

    .chat-input button {
      background: #25D366;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 25px;
      margin-left: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.2s ease;
    }

    .chat-input button:hover {
      background: #128C7E;
    }

    .chat-box small {
      display: block;
      margin-top: 5px;
      font-size: 10px;
      color: gray;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 100px;
        padding: 10px;
      }
      .user {
        font-size: 12px;
        padding: 8px;
      }
      .chat-input input {
        font-size: 12px;
      }
      .chat-input button {
        padding: 10px;
        font-size: 12px;
      }
    }
  </style>
</head>
<body>

  <div class="sidebar" id="users">
    <h3>Contacts</h3>
  </div>

  <div class="chat-container">
    <div class="header">
      <span>Welcome, <?= $_SESSION['username'] ?></span>
      <a href="logout.php">Logout</a>
    </div>

    <div class="chat-box" id="messages">
      <p>Select a contact to start chatting.</p>
    </div>

    <div class="chat-input">
      <input type="text" id="msg" placeholder="Type a message">
      <button onclick="sendMessage()">Send</button>
    </div>
  </div>

  <script>
    let selectedUser = null;

    function loadUsers() {
      fetch('get_users.php')
        .then(res => res.text())
        .then(data => {
          document.getElementById('users').innerHTML += data;
        });
    }

    function selectUser(id, name) {
      selectedUser = id;
      document.getElementById('messages').innerHTML = '<p>Loading chat with <b>' + name + '</b>...</p>';
      loadMessages();
    }

    function loadMessages() {
      if (!selectedUser) return;
      fetch('get_messages.php?to=' + selectedUser)
        .then(res => res.text())
        .then(data => {
          document.getElementById('messages').innerHTML = data;
          document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
        });
    }

    function sendMessage() {
      let msg = document.getElementById('msg').value.trim();
      if (!msg || !selectedUser) return;

      fetch('insert_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'to=' + selectedUser + '&message=' + encodeURIComponent(msg)
      }).then(() => {
        document.getElementById('msg').value = '';
        loadMessages();
      });
    }

    setInterval(() => {
      if (selectedUser) loadMessages();
    }, 2000);

    loadUsers();
  </script>

</body>
</html>
