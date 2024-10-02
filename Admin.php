<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #1E1E1E;
    }
  </style>
</head>
<body>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-2 bg-dark sidebar d-flex flex-column p-3" style="min-height: 100vh; width: auto;">
      
        <h4 class="text-white mb-4">eccomi</h4>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link text-light" href="#">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="#">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="#">Category</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="#">Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="#">Customers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="#">Coupons</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="#">Settings</a>
          </li>
        </ul>
      </nav>

      <!-- Main Content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        
        <!-- Topbar -->
        <div class="d-flex justify-content-between py-3 border-bottom text-white bg-dark">
          <h2>Dashboard</h2>
          <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="Profile Picture">
            <span>Jhon</span>
            <i class="bi bi-bell text-light fs-4 ms-3"></i>
          </div>
        </div>

        <!-- Stat Boxes -->
        <div class="row my-4">
          <div class="col-md-3">
            <div class="card bg-secondary text-white text-center">
              <div class="card-body">
                <h5 class="card-title">Weekly Targets</h5>
                <p class="card-text">$2,359</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card bg-secondary text-white text-center">
              <div class="card-body">
                <h5 class="card-title">Monthly Targets</h5>
                <p class="card-text">$6,438</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card bg-secondary text-white text-center">
              <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <p class="card-text">$811.55</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card bg-secondary text-white text-center">
              <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <p class="card-text">66,556</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Chart Section -->
     

        <!-- Another Section (Optional for more graphs or data) -->
        <div class="row mb-4">
          <div class="col-md-6">
            <div class="card bg-secondary text-white">
              <div class="card-body">
                <h5 class="card-title">New Customers</h5>
                <p class="card-text">4,565</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card bg-secondary text-white">
              <div class="card-body">
                <h5 class="card-title">Total Deliveries</h5>
                <p class="card-text">72,000</p>
              </div>
            </div>
          </div>
        </div>

      </main>
    </div>
  </div>

  <!-- Bootstrap JS and Chart.js (for Charts) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('userHitChart').getContext('2d');
    const userHitChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [{
          label: 'Monthly Visitors',
          data: [100, 200, 300, 400, 500, 600],
          borderColor: 'rgba(75, 192, 192, 1)',
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderWidth: 2
        }]
      }
    });
  </script>
</body>
</html>
