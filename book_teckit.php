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
                    <h1 class="h3 mb-4 text-gray-800">Teckit Booking</h1>

                    

                 

                                                <!-- DataTales Example -->
                                        <div class="card shadow mb-4">
                                            <div class="card-header py-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">No.of.Booking</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sr.No</th>
                                                                    <th>Train NO</th>
																	<th>Ticket NO</th>
                                                                    <th>Dastinaton</th>
                                                                    <th>Status</th>
																	<th>Teckit Price</th>
																	 <th>User Name</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                            include 'Conn.php';
                                                                $sql="SELECT * FROM `booking` order by id desc";
                                                                $result=$conn->query($sql);
                                                            
                                                                $no=0;
                                                                    while($row = $result->fetch_assoc())
                                                                    {
                                                                        $no++;


                                                            ?>
                                                            <tr>
                                                                <td><?=$no;?></td>
                                                                <td><?=$row['tnom'];?></td>
																<td><?=$row['trnNo'];?></td>
                                                                <td><?=$row['tdastinaton'];?></td>
                                                                <td><?=$row['tstatus'];?></td>
																<td><?=$row['tvalue'];?></td>
																<td><?=$row['username'];?></td>
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
                        <span>Copyright &copy; Your Website 2020</span>
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