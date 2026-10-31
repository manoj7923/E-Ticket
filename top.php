<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id']) || !isset($_SESSION['user_name'])) {
    header("Location: index1.php");
    exit();
}

$admin_display_name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Officer Admin';
?>
<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Division Title -->
    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-train"></i> Western Railway Mumbai Suburban Operations Console
        </h6>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Live Clock Indicator -->
        <li class="nav-item d-none d-md-flex align-items-center mr-3">
            <span class="badge badge-light p-2" style="font-family: var(--font-mono); font-size: 0.85rem; border: 1px solid #cbd5e1;">
                <span class="live-pulse-dot mr-1"></span> IST Live Operations
            </span>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-700 font-weight-bold small">
                    <?php echo $admin_display_name; ?>
                </span>
                <div class="user-avatar" style="width: 32px; height: 32px; background: var(--wr-navy-800); font-size: 0.85rem;">
                    <i class="fas fa-user-shield"></i>
                </div>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="home.php" target="_blank">
                    <i class="fas fa-ticket fa-sm fa-fw mr-2 text-gray-400"></i>
                    Passenger Portal
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger font-weight-bold" href="logout.php">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                    Logout Officer
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->
