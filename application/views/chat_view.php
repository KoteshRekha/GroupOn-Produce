<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
    <div id="chatBox"></div>

    <input type="text" id="messageInput" placeholder="Type your message..." />
    <button id="sendBtn">Send</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    var otherUserId = <?= isset($otherUserId) ? $otherUserId : 'null'; ?>;

    // Fetch messages periodically
    function fetchMessages() {
        $.ajax({
            url: "<?= base_url('chat/fetch_messages'); ?>",
            type: "POST",
            dataType: "json",
            data: { otherUserId: otherUserId },
            success: function(response) {
                // Clear chatBox
                $("#chatBox").empty();

                // Build message HTML
                $.each(response, function(index, msg) {
                    let fromId = msg.from_user_id;
                    let messageText = msg.message;
                    let createdAt = msg.created_at;

                    let msgHtml = '<div class="message">';
                    msgHtml += '<span class="from">' + (fromId == otherUserId ? 'Them' : 'Me') + ': </span>';
                    msgHtml += '<span class="text">' + messageText + '</span>';
                    msgHtml += ' <span class="time">(' + createdAt + ')</span>';
                    msgHtml += '</div>';

                    $("#chatBox").append(msgHtml);
                });

                // Auto-scroll to bottom
                $("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);
            }
        });
    }

    // Send message
    function sendMessage() {
        let message = $("#messageInput").val();
        if (message.trim() === "") return;

        $.ajax({
            url: "<?= base_url('chat/send_message'); ?>",
            type: "POST",
            dataType: "json",
            data: {
                otherUserId: otherUserId,
                message: message
            },
            success: function(res) {
                // After sending, fetch messages again
                fetchMessages();
                $("#messageInput").val("");
            }
        });
    }

    $(document).ready(function() {
        // Initial fetch
        if (otherUserId) {
            fetchMessages();
        }

        // Set up "Send" button
        $("#sendBtn").click(function() {
            sendMessage();
        });

        // Poll for new messages every 5 seconds
        setInterval(fetchMessages, 5000);
    });
    </script>
</body>
</html>
