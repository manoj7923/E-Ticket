<!DOCTYPE html>
<html lang="en">
<?php include 'Header.php';?>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    <?php include 'sidebar.php'?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

              <?php include 'top.php'?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

                    <div class="row">

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-12 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Registrated Users</div>
                                        <?php
                                        include 'Conn.php';
                                        $sql="SELECT count(*) as Users FROM `users`";
                                        $result=$conn->query($sql);
                                        $row = $result->fetch_assoc();
                                      ?>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$row['Users'];?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Earnings (Annual) Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        User Complaint</div>
					
                                        <?php
                                        include 'Conn.php';
                                        $sql="SELECT count(*) as Users FROM `complaint`";
                                        $result=$conn->query($sql);
                                        $row = $result->fetch_assoc();
                                      ?>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$row['Users'];?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tasks Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requests Card Example -->
<div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Pending Requests</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="col-xl-12 col-md-12 mb-12"> 

                        <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Registrated Users</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Name</th>
                                       
                                            <th>User Name</th>
											<th>Password</th>
											

                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      include 'Conn.php';
                                        $sql="SELECT * FROM `users` order by id desc";
                                        $result=$conn->query($sql);
                                       
                                          $no=0;
                                            while($row = $result->fetch_assoc())
                                            {
                                                $no++;


                                      ?>
                                      <tr>
                                          <td><?=$no;?></td>
                                          <td><?=$row['name'];?></td>
                                       
                                          <td><?=$row['user_name'];?></td>
										  <td><?=$row['password'];?></td>
                                          
                                         
                                      </tr>
                                      <?php          
                                            }
                                    
                                      ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
</div>


  <div class="card shadow mb-4">
                                            <div class="card-header py-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">Users Complaint</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sr.No</th>
                                                                    <th>Name</th>
                                                                    <th>Email</th>
                                                                    <th>Contact No</th>
                                                                    <th>complaint</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            include 'Conn.php';
                                                                $sql="SELECT * FROM `complaint` order by id desc";
                                                                $result=$conn->query($sql);
                                                            
                                                                $no=0;
                                                                    while($row = $result->fetch_assoc())
                                                                    {
                                                                        $no++;


                                                            ?>
                                                            <tr>
                                                                <td><?=$no;?></td>
                                                                <td><?=$row['cname'];?></td>
                                                                <td><?=$row['cemail'];?></td>
                                                                <td><?=$row['cmobile'];?></td>
                                                                <td><?=$row['ccomplaint'];?></td>
                                                            </tr>
                                                            <?php          
                                                                    }
                                                            
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>







                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



<?php include 'footor.php';?>
</body>
</html>