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
                            <i class="fas fa-users text-primary"></i> Registered Passengers Management
                        </h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Registered Passenger Directory</h6>
                            <span class="badge badge-primary">Suburban Commuters</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Joined Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM `users` ORDER BY id DESC";
                                        $result = $conn->query($sql);
                                        $no = 0;
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $no++;
                                        ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td class="font-weight-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><span class="badge badge-light p-2 font-weight-bold"><?php echo htmlspecialchars($row['user_name']); ?></span></td>
                                            <td><?php echo !empty($row['email']) ? htmlspecialchars($row['email']) : '<span class="text-muted">N/A</span>'; ?></td>
                                            <td><?php echo !empty($row['mobile']) ? htmlspecialchars($row['mobile']) : '<span class="text-muted">N/A</span>'; ?></td>
                                            <td><span class="badge badge-success"><i class="fas fa-check"></i> Verified</span></td>
                                            <td><?php echo date('d M Y', strtotime($row['created_at'] ?? 'now')); ?></td>
                                        </tr>
                                        <?php 
                                            }
                                        }
                                        ?>
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
