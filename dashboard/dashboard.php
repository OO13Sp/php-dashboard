<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="mt-1.5">Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #1E1E1E;">

<div class="container-fluid">
    <div class="row">
        <!-- Include the Navbar on the left -->
        <nav class="col-md-3 col-lg-2" style="background-color: #111111 ;">
            <?php include 'components/navbar.php'; ?>
        </nav>

        <!-- Main content on the right -->
        <div class="col-md-9 col-lg-10 text-white">
            <!-- Include the Header, BodyMiddle, and Footer -->
            <?php include 'components/header.php'; ?>
            <?php include 'components/bodymiddle.php'; ?>
            <?php include 'components/footer.php'; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
