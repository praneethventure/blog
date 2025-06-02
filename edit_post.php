<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'db.php';
include 'header.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        echo "<div class='alert alert-danger'>Title and content cannot be empty.</div>";
    } else {
        $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
        $stmt->bind_param("ssi", $title, $content, $id);
        $stmt->execute();
        header("Location: index.php");
    }
}

$stmt = $conn->prepare("SELECT title, content FROM posts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($title, $content);
$stmt->fetch();
$stmt->close();
?>
<h2>Edit Post</h2>
<form method="POST">
  <div class="mb-3">
    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title) ?>" required>
  </div>
  <div class="mb-3">
    <textarea name="content" class="form-control" required><?= htmlspecialchars($content) ?></textarea>
  </div>
  <button type="submit" class="btn btn-warning">Update</button>
</form>
<?php include 'footer.php'; ?>
