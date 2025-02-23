<nav class="navbar navbar-expand-sm navbar-light bg-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="image/favicon.jpg" width="30" height="30" class="rounded-circle">
            Blood Bank Management System
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <i class="fas fa-align-left"></i>
        </button>

        <div class="collapse navbar-collapse" id="collapsibleNavbar">

            <?php if (isset($_SESSION['hid'])) { ?>
                <!-- Hospital User Navigation Links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="hospitalpage.html">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            <?php } elseif (isset($_SESSION['rid'])) { ?>
                <!-- Regular User Navigation Links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="userpage.html">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            <?php } else { ?>
                <!-- Not Logged In -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="register.php">Register</a>
                    </li>
                </ul>
            <?php } ?>

        </div>
    </div>
</nav>
