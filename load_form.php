<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';

if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $load_amount = floatval($_POST['load_amount']);
    $debt_owner = trim($_POST['debt_owner']);
    $tax = $load_amount * 0.2;
    $total = $load_amount + $tax;

    $stmt = $conn->prepare("INSERT INTO load_transactions (debt_owner, load_amount, tax, total_amount, date_created) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("sddd", $debt_owner, $load_amount, $tax, $total);
    $stmt->execute();
    $message = "<div class='alert alert-success'>Transaction added successfully!</div>";

    $_SESSION['message'] = "<div class='alert alert-success'>Transaction added successfully!</div>";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $conn->query("DELETE FROM load_transactions WHERE id = $delete_id");
    $_SESSION['message'] = "<div class='alert alert-danger'>Transaction ID $delete_id has been deleted.</div>";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Load Transactions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Load Transaction</h2>

    <?php if (isset($message)) echo $message; ?>

    <form method="post" class="mb-5" oninput="calculateTotals()">
        <div class="mb-3">
            <label for="debt_owner" class="form-label">Debt Owner (Kinsa may utang)</label>
            <input type="text" name="debt_owner" id="debt_owner" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="load_amount" class="form-label">Load Amount (₱)</label>
            <input type="number" step="0.01" name="load_amount" id="load_amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tax" class="form-label">Tax (₱)</label>
            <input type="text" id="tax" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label for="total" class="form-label">Total Amount (₱)</label>
            <input type="text" id="total" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Add Transaction</button>
    </form>

    <h4>Transaction History</h4>
    <?php
    $result = $conn->query("SELECT * FROM load_transactions ORDER BY date_created DESC");
    if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Debt Owner</th>
                    <th>Load Amount (₱)</th>
                    <th>Tax (₱)</th>
                    <th>Total (₱)</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['debt_owner']) ?></td>
                        <td><?= number_format($row['load_amount'], 2) ?></td>
                        <td><?= number_format($row['tax'], 2) ?></td>
                        <td><?= number_format($row['total_amount'], 2) ?></td>
                        <td><?= $row['date_created'] ?></td>
                        <td>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this transaction?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-muted">No transactions yet.</p>
    <?php endif; ?>
</div>

<script>
function calculateTotals() {
    const loadInput = document.getElementById('load_amount');
    const taxField = document.getElementById('tax');
    const totalField = document.getElementById('total');

    const load = parseFloat(loadInput.value) || 0;
    const tax = load * 0.2;
    const total = load + tax;

    taxField.value = tax.toFixed(2);
    totalField.value = total.toFixed(2);
}
</script>
</body>
</html>