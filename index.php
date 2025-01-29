<?php
// Define the chat file
$chatFile = 'chat.txt';

// Initialize the error message
$errorMessage = '';

// Handle the form submission (when a user sends a message)
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['message'])) {
    $message = htmlspecialchars($_POST['message']); // Sanitize the input message
    $timestamp = date('Y-m-d H:i:s'); // Get the current timestamp

    // Append the new message to the chat file
    $chatMessage = "$timestamp: $message\n";
    file_put_contents($chatFile, $chatMessage, FILE_APPEND);

    // Redirect to refresh the page (to avoid resubmitting the form on refresh)
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Read the existing messages from the chat file
$chatHistory = '';
if (file_exists($chatFile)) {
    $chatHistory = file_get_contents($chatFile);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text-Based Chat System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .chat-box {
            height: 300px;
            overflow-y: scroll;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .chat-message {
            margin-bottom: 10px;
        }
        .chat-message strong {
            color: #007bff;
        }
        .input-area {
            display: flex;
            justify-content: space-between;
        }
        textarea {
            width: 80%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            width: 15%;
            padding: 10px;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Text-Based Chat System</h2>

    <div class="chat-box">
        <?php
        // Display existing chat messages
        if (!empty($chatHistory)) {
            echo nl2br($chatHistory);  // Convert newlines to <br> for HTML
        } else {
            echo "<p>No messages yet. Start chatting!</p>";
        }
        ?>
    </div>

    <form method="POST" class="input-area">
        <textarea name="message" placeholder="Type your message here..." rows="3" required></textarea>
        <button type="submit">Send</button>
    </form>
</div>

</body>
</html>
