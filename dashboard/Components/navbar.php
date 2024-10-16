<div class="d-flex flex-column" style="background-color: #111111; min-height: 100vh;">
    <h4 class="text-white mt-3">Admin Dashboard</h4>
    <hr class="bg-light">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">

        <!-- Dynamically load body content based on 'page' query parameter, adding this as a layout for different pages on the navbar-->
            <a href="dashboard.php?page=dashboard" class="nav-link text-white <?php echo ($_GET['page'] ?? 'dashboard') == 'dashboard' ? 'active' : ''; ?>" style="<?php echo ($_GET['page'] ?? 'dashboard') == 'dashboard' ? 'background-color: #4D4D4D;' : ''; ?>">
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="dashboard.php?page=users" class="nav-link text-white <?php echo ($_GET['page'] ?? '') == 'users' ? 'active' : ''; ?>" style="<?php echo ($_GET['page'] ?? '') == 'users' ? 'background-color: #4D4D4D;' : ''; ?>">
                Users
            </a>
        </li>
        <li class="nav-item">
            <a href="dashboard.php?page=reports" class="nav-link text-white <?php echo ($_GET['page'] ?? '') == 'reports' ? 'active' : ''; ?>" style="<?php echo ($_GET['page'] ?? '') == 'reports' ? 'background-color: #4D4D4D;' : ''; ?>">
                Reports
            </a>
        </li>
        <li class="nav-item">
            <a href="dashboard.php?page=settings" class="nav-link text-white <?php echo ($_GET['page'] ?? '') == 'settings' ? 'active' : ''; ?>" style="<?php echo ($_GET['page'] ?? '') == 'settings' ? 'background-color: #4D4D4D;' : ''; ?>">
                Settings
            </a>
        </li>
    </ul>
</div>
