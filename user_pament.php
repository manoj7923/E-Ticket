<?php 
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index1.php");
    exit();
}
require_once "db_conn.php";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'Header.php'; ?>
<body id="page-top">

    <div id="wrapper">
        <?php include 'sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'top.php'; ?>

                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                            <i class="fas fa-credit-card text-success"></i> Payment Transactions Registry
                        </h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Settled Transactions</h6>
                            <span class="badge badge-success"><i class="fas fa-shield"></i> 100% Verified</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Transaction Ref</th>
                                            <th>Amount (INR)</th>
                                            <th>Passenger</th>
                                            <th>Method</th>
                                            <th>Status</th>
                                            <th>Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `payment` ORDER BY id DESC";
                                        $result = $conn->query($sql);
                                        $no = 0;
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $no++;
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td style="font-family:var(--font-mono); font-weight:700; color:var(--wr-blue-600);">
                                                <?php echo htmlspecialchars($row['transaction_id'] ?? $row['pptext']); ?>
                                            </td>
                                            <td class="font-weight-bold text-success" style="font-family:var(--font-mono); font-size:1.05rem;">
                                                ₹<?php echo number_format((float)$row['ppayment'], 2); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                                            <td><span class="badge badge-light border font-weight-bold"><?php echo htmlspecialchars($row['payment_method'] ?? 'UPI / Online'); ?></span></td>
                                            <td><span class="badge badge-success"><i class="fas fa-check-circle"></i> SUCCESS</span></td>
                                            <td><?php echo date('d M Y, h:i A', strtotime($row['payment_date'] ?? 'now')); ?></td>
                                        </tr>
                                        <?php 
                                            }
                                        } else {
                                        ?>
                                        <tr><td colspan="7" class="text-center py-4 text-muted">No payment records found.</td></tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white border-top">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Western Railway Mumbai Suburban Division • E-Ticket Operations System &copy; <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <?php include 'footor.php'; ?>
</body>
</html>
