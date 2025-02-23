<?php 
require 'file/connection.php'; 
session_start();

// Check if user is logged in as hospital
if (!isset($_SESSION['hid'])) {
    header('location:login.php');
    exit();  // Ensure the script stops here after redirection
} else {
    $hid = $_SESSION['hid'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT blooddonate.*, receivers.* FROM blooddonate 
            INNER JOIN receivers ON blooddonate.rid = receivers.id 
            WHERE blooddonate.hid = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $hid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloodbank | Sent Requests</title>
    <?php require 'head.php'; ?>
    <style>
        body {
            background: url(image/p4.jpg) no-repeat center;
            background-size: cover;
            min-height: 100%;
            height: auto;
        }
        .login-form {
            width: calc(100% - 20px);
            max-height: 650px;
            max-width: 450px;
            background-color: white;
        }
    </style>
</head>
<body>
    <?php require 'header.php'; ?>
    <div class="container cont">

        <?php require 'message.php'; ?>

        <table class="table table-responsive table-striped rounded mb-5">
            <tr><th colspan="8" class="title">Sent Requests</th></tr>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>City</th>
                <th>Phone</th>
                <th>Blood Group</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
            // Check if there are results
            if (mysqli_num_rows($result) > 0) {
                // Loop through the results
                while ($row = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo htmlspecialchars($row['rname']); ?></td>
                    <td><?php echo htmlspecialchars($row['remail']); ?></td>
                    <td><?php echo htmlspecialchars($row['rcity']); ?></td>
                    <td><?php echo htmlspecialchars($row['rphone']); ?></td>
                    <td><?php echo htmlspecialchars($row['bg']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <?php if ($row['status'] == 'Accepted') { ?>
                            <!-- No action for accepted requests -->
                        <?php } else { ?>
                            <a href="file/canceld.php?donoid=<?php echo $row['donoid']; ?>" class="btn btn-danger">Cancel</a>
                        <?php } ?>
                    </td>
                </tr>
            <?php 
                }
            } else {
                echo '<tr><td colspan="8" style="color:white;background-color:red;padding:7px;border-radius: 15px 50px;">You have not requested yet.</td></tr>';
            }
            ?>
        </table>
    </div>

    <?php require 'footer.php'; ?>
</body>
</html>

<?php 
// Close the prepared statement
mysqli_stmt_close($stmt);
?>
