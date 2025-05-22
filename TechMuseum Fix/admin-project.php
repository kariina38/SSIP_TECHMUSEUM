<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-admin.php");
    exit();
}

include 'db.php';

// Handle POST actions: approve, reject, delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    if ($action === 'approve' || $action === 'reject') {
        $status = $action === 'approve' ? 'approved' : 'rejected';
        $stmt = $conn->prepare("UPDATE project_submissions SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM project_submissions WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: admin-project.php");
    exit();
}

// Ambil semua project dengan urutan status
$sql = "SELECT * FROM project_submissions ORDER BY FIELD(status, 'pending', 'approved', 'rejected'), id DESC";
$result = $conn->query($sql);
$projects = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Projects</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f3f3;
            padding: 20px;
        }
        .container {
            max-width: 960px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }
        .project {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            background-color: #fdfdfd;
        }
        .project h3 {
            margin: 0 0 10px 0;
        }
        .project .meta {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 10px;
        }
        .project .actions form {
            display: inline-block;
            margin-right: 5px;
        }
        .project .actions button {
            padding: 6px 10px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .approve-btn { background-color: #28a745; color: white; }
        .reject-btn { background-color: #ffc107; color: black; }
        .delete-btn { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin: Manage Project Submissions</h1>

        <?php if (empty($projects)): ?>
            <p>No submissions found.</p>
        <?php else: ?>
            <?php foreach ($projects as $p): ?>
                <div class="project">
                    <h3><?= htmlspecialchars($p['project_name']) ?></h3>
                    <div class="meta">
                        Submitted by <?= htmlspecialchars($p['name']) ?> (<?= htmlspecialchars($p['creator_type']) ?>) on <?= htmlspecialchars($p['submission_date']) ?><br>
                        Status: <strong><?= ucfirst($p['status']) ?></strong>
                    </div>
                    <p><?= nl2br(htmlspecialchars($p['project_description'])) ?></p>
                    <div class="actions">
                        <?php if ($p['status'] === 'pending'): ?>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <input type="hidden" name="action" value="approve">
                                <button class="approve-btn">Approve</button>
                            </form>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <input type="hidden" name="action" value="reject">
                                <button class="reject-btn">Reject</button>
                            </form>
                        <?php endif; ?>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this project?')">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <input type="hidden" name="action" value="delete">
                            <button class="delete-btn">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
