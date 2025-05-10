<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db.php';
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<h2>Welcome to the Blog</h2>
<a href="create_post.php">+ Create New Post</a> | 
<a href="logout.php">Logout</a>
<hr>

<?php while($row = $result->fetch_assoc()): ?>
  <div>
    <h3><?= $row['title'] ?></h3>
    <p><?= $row['content'] ?></p>
    <small>Posted on <?= $row['created_at'] ?></small><br>
    <a href="edit_post.php?id=<?= $row['id'] ?>">Edit</a> | 
    <a href="delete_post.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this post?')">Delete</a>
    <hr>
  </div>
<?php endwhile; ?>
