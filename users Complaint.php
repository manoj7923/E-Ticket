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
                            <i class="fas fa-headset text-warning"></i> Rail Madad Grievance Redressal
                        </h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Passenger Grievances & Feedback</h6>
                            <span class="badge badge-warning">Priority Action Desk</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Passenger</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Category</th>
                                            <th>Grievance Statement</th>
                                            <th>Status</th>
                                            <th>Logged Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `complaint` ORDER BY id DESC";
                                        $result = $conn->query($sql);
                                        $no = 0;
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $no++;
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td class="font-weight-bold"><?php echo htmlspecialchars($row['cname']); ?></td>
                                            <td><?php echo htmlspecialchars($row['cemail']); ?></td>
                                            <td style="font-family:var(--font-mono);"><?php echo htmlspecialchars($row['cmobile']); ?></td>
                                            <td><span class="badge badge-info"><?php echo htmlspecialchars($row['category'] ?? 'General'); ?></span></td>
                                            <td style="max-width: 300px;"><?php echo htmlspecialchars($row['ccomplaint']); ?></td>
                                            <td>
                                                <?php if (($row['status'] ?? '') === 'Resolved') { ?>
                                                    <span class="badge badge-success"><i class="fas fa-check"></i> Resolved</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-warning"><i class="fas fa-clock"></i> In Progress</span>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo date('d M Y', strtotime($row['created_at'] ?? 'now')); ?></td>
                                        </tr>
                                        <?php 
                                            }
                                        } else {
                                        ?>
                                        <tr><td colspan="8" class="text-center py-4 text-muted">No grievances logged.</td></tr>
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
