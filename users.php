<?php
require_once __DIR__ . '/../functions.php';
require_admin();

// suppression simple (via GET ?delete=ID)
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $conn->prepare('DELETE FROM users WHERE id = ? AND username <> ?');
    $adminName = 'admin'; // protège l'utilisateur 'admin' par défaut
    $stmt->bind_param('is', $id, $adminName);
    $stmt->execute();
    header('Location: /admin/users.php');
    exit;
}

// list users
$result = $conn->query('SELECT id, username, role, created_at FROM users ORDER BY id DESC');
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Gérer les utilisateurs</title></head>
<body>
<h1>Utilisateurs</h1>
<p><a href="/admin/index.php">← Retour</a></p>
<table border="1" cellpadding="6" cellspacing="0">
<thead><tr><th>ID</th><th>Username</th><th>Role</th><th>Créé</th><th>Actions</th></tr></thead>
<tbody>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo (int)$row['id']; ?></td>
    <td><?php echo htmlspecialchars($row['username']); ?></td>
    <td><?php echo htmlspecialchars($row['role']); ?></td>
    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
    <td>
        <?php if ($row['username'] !== 'admin'): ?>
            <a href="/admin/users.php?delete=<?php echo (int)$row['id']; ?>" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
        <?php else: ?>
            (protégé)
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</body>
</html>
