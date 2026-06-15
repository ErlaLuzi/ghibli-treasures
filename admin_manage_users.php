<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Handle promotion or deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $userId = intval($_POST['id'] ?? 0);

    // Prevent admin from deleting themselves
    if ($userId == $_SESSION['user_id']) {
        $_SESSION['error'] = "You cannot modify or delete your own account.";
        header("Location: admin_manage_users.php");
        exit;
    }

    if ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $_SESSION['success'] = "User deleted.";
    }

    if ($action === 'promote') {
        $stmt = $conn->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $_SESSION['success'] = "User promoted to admin.";
    }

    if ($action === 'demote') {
        $stmt = $conn->prepare("UPDATE users SET role = 'user' WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $_SESSION['success'] = "Admin demoted to user.";
    }

    header("Location: admin_manage_users.php");
    exit;
}

// Fetch all users
$users = $conn->query("SELECT * FROM users ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);
?>

<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="css/admin_users.css">


<main class="admin-panel">
    <h1>Manage Users</h1>

    <?php if (!empty($_SESSION['success'])): ?>
        <p class="success-msg"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <p class="error-msg"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th><th>Username</th><th>Email</th><th>Phone</th><th>Role</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td><?= $user['role'] ?></td>
                    <td>
                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button type="submit" name="action" value="delete" onclick="return confirm('Delete this user?')">Delete</button>
                                <?php if ($user['role'] === 'user'): ?>
                                    <button type="submit" name="action" value="promote">Promote to Admin</button>
                                <?php elseif ($user['role'] === 'admin'): ?>
                                    <button type="submit" name="action" value="demote">Demote to User</button>
                                <?php endif; ?>
                            </form>
                        <?php else: ?>
                            <em>Current Admin</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php include 'includes/footer.php'; ?>
