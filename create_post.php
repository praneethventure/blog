<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        echo "<div class='alert alert-danger'>Both title and content are required.</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();
        header("Location: index.php");
    }
}
?>
<h2>Create Post</h2>
<form method="POST">
  <div class="mb-3">
    <input type="text" name="title" class="form-control" placeholder="Title" required>
  </div>
  <div class="mb-3">
    <textarea name="content" class="form-control" placeholder="Content" required></textarea>
  </div>
  <button type="submit" class="btn btn-success">Create</button>
</form>
<?php include 'footer.php'; ?>
