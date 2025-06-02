<?php
session_start();
require 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userId, $hashedPassword, $role);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['role'] = $role;
        header("Location: index.php");
    } else {
        echo "<div class='alert alert-danger'>Invalid login</div>";
    }
}
?>
<h2>Login</h2>
<form method="POST">
  <div class="mb-3">
    <input type="text" name="username" class="form-control" placeholder="Username" required>
  </div>
  <div class="mb-3">
    <input type="password" name="password" class="form-control" placeholder="Password" required>
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
  <a href="register.php" class="btn btn-secondary">Register</a>
</form>
<?php include 'footer.php'; ?>

