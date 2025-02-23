<?php
session_start();
include('Includes2/header.php');
include('Includes2/navbar.php');

$connect = mysqli_connect("localhost", "root", "", "kmn (pvt) ltd");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add Customer
if (isset($_POST['add_btn'])) {
    $cust_id = $_POST['cust_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $referral = $_POST['referral'];
    $user_id = $_POST['user_id'];

    $insert_query = "INSERT INTO customer (Cust_Id,FirstName,LastName,Address,Phone,Email,Referral,User_Id) 
                     VALUES ('$cust_id','$first_name', '$last_name', '$address', '$phone', '$email', '$referral', '$user_id')";
    mysqli_query($connect,$insert_query);
}

// Display Customers
$query = "SELECT * FROM customer";
$query_run = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/style.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
   <!-- // <link rel="stylesheet" href="tables.css"> -->
    <style>
        #customers thead th {
            background-color:#9999ff; 
            color: black;
        }
    </style>   
</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                        <a href="logout.php" class="btn btn-danger">Log Out</a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Customer Details</h1>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addCustomerModal">Add Customer</a>
                    <br><br>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                if ($query_run) {
                                    if (mysqli_num_rows($query_run) > 0) {
                                        echo '<table id="customers" class="table table-bordered" width="100%" cellspacing="0">';
                                        echo '<thead>';
                                        echo '<tr>';
                                        echo '<th>CUST_ID</th>';
                                        echo '<th>FIRST NAME</th>';
                                        echo '<th>LAST NAME</th>';
                                        echo '<th>ADDRESS</th>';
                                        echo '<th>PHONE</th>';
                                        echo '<th>EMAIL</th>';
                                        echo '<th>REFERRAL</th>';
                                        echo '<th>USER_ID</th>';
                                        echo '<th>EDIT</th>';
                                        echo '<th>DELETE</th>';
                                        echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';

                                        while ($row = mysqli_fetch_assoc($query_run)) {
                                            echo '<tr>';
                                            echo '<td>' . $row['Cust_Id'] . '</td>';
                                            echo '<td>' . $row['FirstName'] . '</td>';
                                            echo '<td>' . $row['LastName'] . '</td>';
                                            echo '<td>' . $row['Address'] . '</td>';
                                            echo '<td>' . $row['Phone'] . '</td>';
                                            echo '<td>' . $row['Email'] . '</td>';
                                            echo '<td>' . $row['Referral'] . '</td>';
                                            echo '<td>' . $row['User_Id'] . '</td>';
                                            echo '<td>
                                                    <form action="customer_edit.php" method="post">
                                                        <input type="hidden" name="edit_id" value="' . $row['Cust_Id'] . '">
                                                        <button type="submit" name="edit_btn" class="btn btn-success">EDIT</button>
                                                    </form>
                                                </td>';

                                            echo '<td>
                                                    <form action="delete_customer.php" method="post">
                                                        <input type="hidden" name="delete_id" value="' . $row['Cust_Id'] . '">
                                                        <button type="submit" name="delete_btn" class="btn btn-danger">DELETE</button>
                                                    </form>
                                                </td>';
                                            echo '</tr>';
                                        }

                                        echo '</table>';
                                    } else {
                                        echo 'No records found';
                                    }
                                } else {
                                    echo 'Error in the query: ' . mysqli_error($connect);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

                <!-- Add Customer Modal -->
                <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Add Customer Form -->
                                <form action="" method="post">
                                <div class="form-group">
                                        <label for="cust_id">Cust Id:</label>
                                        <input type="text" class="form-control" id="cust_id" name="cust_id" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="first_name">First Name:</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name:</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <input type="text" class="form-control" id="address" name="address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone:</label>
                                        <input type="text" class="form-control" id="phone" name="phone" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="referral">Referral:</label>
                                        <input type="text" class="form-control" id="referral" name="referral">
                                    </div>
                                    <div class="form-group">
                                        <label for="user_id">User ID:</label>
                                        <input type="text" class="form-control" id="user_id" name="user_id" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="add_btn">Add Customer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>

                <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-primary" href="login.html">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bootstrap core JavaScript-->
                <script src="vendor/jquery/jquery.min.js"></script>
                <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                <script src="vendor/datatables/jquery.dataTables.min.js"></script>
                <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
                <script src="js/demo/datatables-demo.js"></script>
                <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
                <script src="js/sb-admin-2.min.js"></script>
</body>

</html>

<?php
include('Includes2/footer.php');
mysqli_close($connect);
?>
