<?php 
require 'file/connection.php'; 
session_start();

if (!isset($_SESSION['hid'])) {
    header('location:login.php');
} else {
    $hid = $_SESSION['hid'];

    // SQL query to fetch blood requests, receiver details, and stock info
    $sql = "SELECT bloodrequest.*, receivers.*, blooddinfo.stock 
            FROM bloodrequest
            JOIN receivers ON bloodrequest.rid = receivers.id
            JOIN blooddinfo ON bloodrequest.bg = blooddinfo.bg
            WHERE bloodrequest.hid = '$hid'";
    
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<?php $title="Bloodbank | Blood Requests"; ?>
<?php require 'head.php'; ?>
<style>
    body {
        background: url(image/p2.png) no-repeat center;
        background-size: cover;
        min-height: 0;
        height: 650px;
    }
    .login-form {
        width: calc(100% - 20px);
        max-height: 650px;
        max-width: 450px;
        background-color: white;
    }
</style>
<body>
    <?php require 'header.php'; ?>
    <div class="container cont">

        <?php require 'message.php'; ?>

        <table class="table table-responsive table-striped rounded mb-5">
            <tr><th colspan="10" class="title">Blood Requests</th></tr>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>City</th>
                <th>Phone</th>
                <th>Blood Group</th>
                <th>Stock Available</th>
                <th>Status</th>
                <th colspan="2">Action</th>
            </tr>

            <div>
                <?php
                if ($result) {
                    $row_count = mysqli_num_rows($result);
                    if ($row_count) {
                        // echo "<b> Total ".$row_count." </b>";
                    } else {
                        echo '<b style="color:white;background-color:red;padding:7px;border-radius: 15px 50px;">No one has requested yet. </b>';
                    }
                }
                ?>
            </div>

            <?php 
            $counter = 0;
            while ($row = mysqli_fetch_array($result)) { ?>

            <tr>
                <td><?php echo ++$counter; ?></td>
                <td><?php echo $row['rname']; ?></td>
                <td><?php echo $row['remail']; ?></td>
                <td><?php echo $row['rcity']; ?></td>
                <td><?php echo $row['rphone']; ?></td>
                <td><?php echo $row['bg']; ?></td>
                <td><?php echo $row['stock']; ?></td>
                <td><?php echo 'You have ' . $row['status']; ?></td>

                <!-- Accept Button -->
                <td>
                    <?php 
                    if ($row['status'] == 'Accepted' || $row['stock'] <= 0) { ?>
                        <a href="" class="btn btn-success disabled">
                            <?php echo $row['stock'] <= 0 ? 'Out of Stock' : 'Accepted'; ?>
                        </a>
                    <?php } else { ?>
                        <a href="file/accept.php?reqid=<?php echo $row['reqid']; ?>&bg=<?php echo $row['bg']; ?>&hid=<?php echo $row['hid']; ?>" class="btn btn-success">
                            Accept
                        </a>
                    <?php } ?>
                </td>

                <!-- Reject Button -->
                <td>
                    <?php if ($row['status'] == 'Rejected') { ?>
                        <a href="" class="btn btn-danger disabled">Rejected</a>
                    <?php } else { ?>
                        <a href="file/reject.php?reqid=<?php echo $row['reqid']; ?>" class="btn btn-danger">Reject</a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </table>

    </div>
    <?php require 'footer.php'; ?>
</body>
</html>
<?php } ?>
