<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login-admin.php");
    exit();
}

include 'db.php';

// Count testimonials by status
$counts = [
    'pending' => 0,
    'approved' => 0,
    'rejected' => 0
];

$result = $conn->query("SELECT status, COUNT(*) as count FROM testimonials GROUP BY status");
while ($row = $result->fetch_assoc()) {
    $counts[$row['status']] = $row['count'];
}

// Count quotes by status
$quote_counts = [
    'pending' => 0,
    'approved' => 0,
    'rejected' => 0
];

$quote_result = $conn->query("SELECT status, COUNT(*) as count FROM quotes GROUP BY status");
while ($row = $quote_result->fetch_assoc()) {
    $quote_counts[$row['status']] = $row['count'];
}

// Count projects by status
$project_counts = [
    'pending' => 0,
    'approved' => 0,
    'rejected' => 0
];

$project_result = $conn->query("SELECT status, COUNT(*) as count FROM project_submissions GROUP BY status");
while ($row = $project_result->fetch_assoc()) {
    $project_counts[$row['status']] = $row['count'];
}

// Tutup koneksi database setelah semua query selesai
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Tech Museum</title>
    <style>
        /* ...style tetap seperti yang kamu punya... */
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
        
        h1, h2 {
            color: #333;
        }
        
        .dashboard-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 20px 0;
        }
        
        .stat-card {
            flex: 1;
            min-width: 200px;
            padding: 15px;
            border-radius: 5px;
            color: white;
            text-align: center;
        }
        
        .stat-pending {
            background-color: #ffc107;
        }
        
        .stat-approved {
            background-color: #28a745;
        }
        
        .stat-rejected {
            background-color: #dc3545;
        }
        
        .stat-quotes {
            background-color: #6f42c1;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="password"] {
            padding: 8px;
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .success {
            color: green;
            margin: 10px 0;
        }
        
        .error {
            color: red;
            margin: 10px 0;
        }
        
        .nav-links {
            margin: 20px 0;
        }
        
        .nav-links a {
            display: inline-block;
            margin-right: 15px;
            padding: 8px 15px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        
        .nav-links a:hover {
            background-color: #5a6268;
        }
        
        .stat-group {
            width: 100%;
            margin-bottom: 20px;
        }
        
        .stat-group h3 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            color: #444;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome Admin, <?= htmlspecialchars($_SESSION['username']) ?></h1>
        
        <div class="stat-group">
            <h3>Testimonials</h3>
            <div class="dashboard-stats">
                <div class="stat-card stat-pending">
                    <div class="stat-number"><?= $counts['pending'] ?></div>
                    <div>Pending Testimonials</div>
                </div>
                <div class="stat-card stat-approved">
                    <div class="stat-number"><?= $counts['approved'] ?></div>
                    <div>Approved Testimonials</div>
                </div>
                <div class="stat-card stat-rejected">
                    <div class="stat-number"><?= $counts['rejected'] ?></div>
                    <div>Rejected Testimonials</div>
                </div>
            </div>
        </div>
        
        <div class="stat-group">
            <h3>Motivational Quotes</h3>
            <div class="dashboard-stats">
                <div class="stat-card stat-pending">
                    <div class="stat-number"><?= $quote_counts['pending'] ?></div>
                    <div>Pending Quotes</div>
                </div>
                <div class="stat-card stat-approved">
                    <div class="stat-number"><?= $quote_counts['approved'] ?></div>
                    <div>Approved Quotes</div>
                </div>
                <div class="stat-card stat-rejected">
                    <div class="stat-number"><?= $quote_counts['rejected'] ?></div>
                    <div>Rejected Quotes</div>
                </div>
            </div>
        </div>

        <div class="stat-group">
            <h3>Projects</h3>
            <div class="dashboard-stats">
                <div class="stat-card stat-pending" style="background-color:#17a2b8;">
                    <div class="stat-number"><?= $project_counts['pending'] ?></div>
                    <div>Pending Projects</div>
                </div>
                <div class="stat-card stat-approved" style="background-color:#007bff;">
                    <div class="stat-number"><?= $project_counts['approved'] ?></div>
                    <div>Approved Projects</div>
                </div>
                <div class="stat-card stat-rejected" style="background-color:#6c757d;">
                    <div class="stat-number"><?= $project_counts['rejected'] ?></div>
                    <div>Rejected Projects</div>
                </div>
            </div>

            <div class="nav-links">
                <a href="admin-testimonials.php">Manage Testimonials</a>
                <a href="admin-quotes.php">Manage Quotes</a>
                <a href="admin-project.php">Manage Projects</a> <!-- Link baru -->
                <a href="logout.php">Logout</a>
            </div>

            <!-- Form Tambah Admin -->
            <h2>Add New Admin</h2>
            <?php if (isset($_GET['status'])): ?>
                <p class="<?= $_GET['status'] === 'success' ? 'success' : 'error' ?>">
                    <?= $_GET['status'] === 'success' 
                        ? 'Admin successfully added!' 
                        : 'Error: ' . htmlspecialchars($_GET['message']) ?>
                </p>
            <?php endif; ?>
            
            <form action="add-admin-action.php" method="POST">
                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </div>
                <input type="submit" value="Add Admin">
            </form>
        </div>
    </div>
</body>
</html>
