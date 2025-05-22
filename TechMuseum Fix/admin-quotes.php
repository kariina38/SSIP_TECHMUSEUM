<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-admin.php");
    exit();
}

include 'db.php';

// Handle quote actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $action = $_POST['action'];
    
    if (in_array($action, ['approve', 'reject', 'delete'])) {
        if ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM quotes WHERE id = ?");
            $stmt->bind_param("i", $id);
        } else {
            $status = $action === 'approve' ? 'approved' : 'rejected';
            $stmt = $conn->prepare("UPDATE quotes SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $id);
        }
        
        if ($stmt->execute()) {
            $message = "Action completed successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
        
        $stmt->close();
    }
}

// Get all quotes
$sql = "SELECT id, quote, author, status, created_at FROM quotes ORDER BY 
        FIELD(status, 'pending', 'approved', 'rejected'), created_at DESC";
$result = $conn->query($sql);
        
$quotes = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $quotes[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Quotes - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .quote-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        
        .pending {
            background-color: #fff9e6;
            border-left: 4px solid #ffc107;
        }
        
        .approved {
            background-color: #e6ffe6;
            border-left: 4px solid #28a745;
        }
        
        .rejected {
            background-color: #ffe6e6;
            border-left: 4px solid #dc3545;
        }
        
        .quote-text {
            font-style: italic;
            margin: 10px 0;
        }
        
        .quote-author {
            font-weight: bold;
        }
        
        .quote-meta {
            font-size: 12px;
            color: #666;
        }
        
        .status-filter {
            margin: 20px 0;
        }
        
        .status-filter a {
            margin-right: 10px;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
        }
        
        .status-filter a.active {
            background-color: #007bff;
            color: white;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
        }
        
        .approve-btn {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .reject-btn {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .delete-btn {
            background-color: #6c757d;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin-dashboard.php" class="back-link">← Back to Dashboard</a>
        <h1>Manage Motivational Quotes</h1>
        
        <?php if (isset($message)): ?>
            <div class="message <?= strpos($message, 'Error') === false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <div class="status-filter">
    <a href="?status=all" class="<?= (!isset($_GET['status']) || $_GET['status'] === 'all') ? 'active' : '' ?>">All</a>
    <a href="?status=pending" class="<?= (isset($_GET['status']) && $_GET['status'] === 'pending') ? 'active' : '' ?>">Pending</a>
    <a href="?status=approved" class="<?= (isset($_GET['status']) && $_GET['status'] === 'approved') ? 'active' : '' ?>">Approved</a>
    <a href="?status=rejected" class="<?= (isset($_GET['status']) && $_GET['status'] === 'rejected') ? 'active' : '' ?>">Rejected</a>
</div>

        
        <?php foreach ($quotes as $q): 
            if (isset($_GET['status']) && $_GET['status'] !== 'all' && $q['status'] !== $_GET['status']) {
                continue;
            }
        ?>
            <div class="quote-item <?= $q['status'] ?>">
                <div class="quote-text">
                    "<?= htmlspecialchars($q['quote']) ?>"
                </div>
                
                <div class="quote-author">
                    — <?= htmlspecialchars($q['author']) ?>
                </div>
                
                <div class="quote-meta">
                    Status: <?= ucfirst($q['status']) ?> | 
                    Submitted: <?= date('M d, Y', strtotime($q['created_at'])) ?>
                </div>
                
                <div class="actions">
                    <?php if ($q['status'] === 'pending'): ?>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $q['id'] ?>">
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="approve-btn">Approve</button>
                        </form>
                        
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $q['id'] ?>">
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="reject-btn">Reject</button>
                        </form>
                    <?php endif; ?>
                    
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $q['id'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this quote?')">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (empty($quotes)): ?>
            <p>No quotes found.</p>
        <?php endif; ?>
    </div>
</body>
</html>