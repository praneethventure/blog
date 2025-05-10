<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
}
?>

<h2>Create Post</h2>
<form method="POST">
  <input type="text" name="title" placeholder="Post Title" required><br><br>
  <textarea name="content" placeholder="Post Content" required></textarea><br><br>
  <button type="submit">Create</button>
</form>
