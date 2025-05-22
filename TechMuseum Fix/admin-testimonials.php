<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-admin.php");
    exit();
}

include 'db.php';

// Handle testimonial actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $action = $_POST['action'];
    
    if (in_array($action, ['approve', 'reject', 'delete'])) {
        if ($action === 'delete') {
            // Delete the testimonial
            $stmt = $conn->prepare("DELETE FROM testimonials WHERE id = ?");
            $stmt->bind_param("i", $id);
        } else {
            // Approve or reject
            $status = $action === 'approve' ? 'approved' : 'rejected';
            $stmt = $conn->prepare("UPDATE testimonials SET status = ? WHERE id = ?");
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

// Get all testimonials
$sql = "SELECT id, name, image, review, rating, status FROM testimonials ORDER BY 
        FIELD(status, 'pending', 'approved', 'rejected'), id DESC";
$result = $conn->query($sql);
        
$testimonials = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $testimonials[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Testimonials - Admin</title>
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
        
        h1 {
            color: #333;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
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
        
        .testimonial {
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
        
        .testimonial-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .profile-img {
            width: 30px;  /* Made smaller */
            height: 30px; /* Made smaller */
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px; /* Adjusted spacing */
        }
        
        .author-info {
            flex-grow: 1;
        }
        
        .stars {
            color: gold;
            font-size: 16px;
        }
        
        .testimonial-text {
            font-style: italic;
            margin: 10px 0;
        }
        
        .testimonial-meta {
            font-size: 12px;
            color: #666;
        }
        
        .actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
        
        button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .approve-btn {
            background-color: #28a745;
            color: white;
        }
        
        .reject-btn {
            background-color: #dc3545;
            color: white;
        }
        
        .delete-btn {
            background-color: #6c757d;
            color: white;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
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
    </style>
</head>
<body>
    <div class="container">
        <a href="admin-dashboard.php" class="back-link">← Back to Dashboard</a>
        <h1>Manage Testimonials</h1>
        
        <?php if (isset($message)): ?>
            <div class="message <?= strpos($message, 'Error') === false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <div class="status-filter">
            <a href="?status=all" class="<?= !isset($_GET['status']) || $_GET['status'] === 'all' ? 'active' : '' ?>">All</a>
            <a href="?status=pending" class="<?= (isset($_GET['status']) && $_GET['status'] === 'pending') ? 'active' : '' ?>">Pending</a>
            <a href="?status=approved" class="<?= (isset($_GET['status']) && $_GET['status'] === 'approved') ? 'active' : '' ?>">Approved</a>
            <a href="?status=rejected" class="<?= (isset($_GET['status']) && $_GET['status'] === 'rejected') ? 'active' : '' ?>">Rejected</a>
        </div>
        
        <?php foreach ($testimonials as $t): 
            // Filter by status if set
            if (isset($_GET['status']) && $_GET['status'] !== 'all' && $t['status'] !== $_GET['status']) {
                continue;
            }
        ?>
            <div class="testimonial <?= $t['status'] ?>">
                <div class="testimonial-header">
                    <img src="<?= htmlspecialchars($t['image']) ?>" class="profile-img" alt="<?= htmlspecialchars($t['name']) ?>">
                    <div class="author-info">
                        <strong><?= htmlspecialchars($t['name']) ?></strong>
                        <div class="stars"><?= str_repeat('★', $t['rating']) . str_repeat('☆', 5 - $t['rating']) ?></div>
                    </div>
                </div>
                
                <div class="testimonial-text">
                    <?= htmlspecialchars($t['review']) ?>
                </div>
                
                <div class="testimonial-meta">
                    Status: <?= ucfirst($t['status']) ?>
                </div>
                
                <div class="actions">
                    <?php if ($t['status'] === 'pending'): ?>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $t['id'] ?>">
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="approve-btn">Approve</button>
                        </form>
                        
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $t['id'] ?>">
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="reject-btn">Reject</button>
                        </form>
                    <?php endif; ?>
                    
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $t['id'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this testimonial?')">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (empty($testimonials)): ?>
            <p>No testimonials found.</p>
        <?php endif; ?>
    </div>
</body>
</html>