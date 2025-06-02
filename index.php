<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'db.php';
include 'header.php';

// Setup
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$start = ($page - 1) * $limit;
$userRole = $_SESSION['role'] ?? 'editor';

// Query with search + pagination
if ($search !== '') {
    $searchTerm = "%$search%";
    $stmt = $conn->prepare("SELECT * FROM posts WHERE title LIKE ? OR content LIKE ? ORDER BY created_at DESC LIMIT ?, ?");
    $stmt->bind_param("ssii", $searchTerm, $searchTerm, $start, $limit);
} else {
    $stmt = $conn->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT ?, ?");
    $stmt->bind_param("ii", $start, $limit);
}
$stmt->execute();
$result = $stmt->get_result();

// Count total for pagination
if ($search !== '') {
    $countStmt = $conn->prepare("SELECT COUNT(*) FROM posts WHERE title LIKE ? OR content LIKE ?");
    $countStmt->bind_param("ss", $searchTerm, $searchTerm);
} else {
    $countStmt = $conn->prepare("SELECT COUNT(*) FROM posts");
}
$countStmt->execute();
$countStmt->bind_result($total);
$countStmt->fetch();
$countStmt->close();

$totalPages = ceil($total / $limit);
?>

<h2 class="mb-4">Welcome to the Blog</h2>

<div class="d-flex justify-content-between mb-3">
  <a href="create_post.php" class="btn btn-success">+ Create New Post</a>
  <a href="logout.php" class="btn btn-danger">Logout</a>
</div>

<!-- Search form -->
<form method="GET" class="mb-4">
  <div class="input-group">
    <input type="text" name="search" class="form-control" placeholder="Search posts..." value="<?= htmlspecialchars($search) ?>">
    <button class="btn btn-primary" type="submit">Search</button>
  </div>
</form>

<?php if ($result->num_rows > 0): ?>
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="card mb-3">
      <div class="card-body">
        <h4 class="card-title"><?= htmlspecialchars($row['title']) ?></h4>
        <p class="card-text"><?= htmlspecialchars($row['content']) ?></p>
        <small class="text-muted">Posted on <?= $row['created_at'] ?></small><br>

        <!-- Role-based control -->
        <?php if ($userRole === 'admin'): ?>
          <a href="edit_post.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm mt-2">Edit</a>
          <a href="delete_post.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Delete this post?')">Delete</a>
        <?php elseif ($userRole === 'editor'): ?>
          <a href="edit_post.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm mt-2">Edit</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endwhile; ?>
<?php else: ?>
  <p>No posts found.</p>
<?php endif; ?>

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
  <nav>
    <ul class="pagination">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
<?php endif; ?>

<?php include 'footer.php'; ?>
