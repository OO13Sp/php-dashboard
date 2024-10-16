

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #1E1E1E;">

<div class="container-fluid">
    <div class="row">
        <!-- Include the Navbar on the left -->
        <nav class="col-md-3 col-lg-2" style="background-color: #111111;">
            <?php include 'components/navbar.php'; ?>
        </nav>

        <!-- Main content on the right -->
        <div class="col-md-9 col-lg-10 text-white">
            <!-- Include the Header -->
            <?php include 'components/header.php'; ?>
            
            <!-- Dynamic Body Content -->
            <?php
            // Dynamically load body content based on 'page' query parameter, adding this as a layout for different pages on the navbar
            $page = $_GET['page'] ?? 'bodymiddle';
            
            switch ($page) {
                case 'users':
                    include 'usersdashboard.php';
                    break;
                case 'reports':
                    include 'reportsdashboard.php';
                    break;
                case 'settings':
                    include 'components/settings.php';
                    break;
                default:
                    include 'components/bodymiddle.php';
            }
            ?>
            
            <!-- Include the Footer -->
            <?php include 'components/footer.php'; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
