<?php
session_start();
include("DB.php");
include("controller.php");

function checkUser()
{
  if (!isset($_SESSION['profile']) || !isset($_SESSION['profile']->user))
    return false;
  $DB = new DB();
  $userId = (int) $_SESSION['profile']->user; // กัน error/SQL injection
  $query = "SELECT 1 FROM clb_member WHERE perId = {$userId}";
  $rs = $DB->Query($query);
  return isset($rs);
}

$con = new controller();
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <title>CRM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&display=swap"
    rel="stylesheet">

  <!-- ChartJs -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <!-- Bootstrap Icons (คุณใช้ class bi-*) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      min-height: 100vh;
      min-height: -webkit-fill-available;
      font-family: 'IBM Plex Sans Thai', sans-serif;
    }

    html {
      height: -webkit-fill-available;
    }

    .main-container {
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 280px;
      flex-shrink: 0;
    }

    @media (max-width: 767.98px) {
      .main-container {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }
    }

    .sidebar .nav-link {
      font-size: 1.1rem;
      color: #333;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #e9ecef;
      color: #000;
    }
  </style>
</head>

<body>

  <div class="main-container">
    <!-- ========== START SIDEBAR ========== -->
    <nav class="sidebar d-flex flex-column p-3 bg-light">
      <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <span class="fs-4 fw-bold">CRM</span>
      </a>
      <hr>

      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php?case=calender">
            <i class="bi bi-calendar-week me-2"></i> Dashbroad
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?case=stock">
            <i class="bi bi-journal-plus me-2"></i> Stock
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?case=customer">
            <i class="bi bi-journal-plus me-2"></i> customer
          </a>
        </li>


      </ul>

      <hr>
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2"
          data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://via.placeholder.com/32" alt="" width="32" height="32" class="rounded-circle me-2">
          <strong><?= isset($_SESSION['profile']->name) ? htmlspecialchars($_SESSION['profile']->name) : 'ผู้ใช้'; ?></strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
          <li><a class="dropdown-item" href="#">โปรไฟล์</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="#">ออกจากระบบ</a></li>
        </ul>
      </div>
    </nav>
    <!-- ========== END SIDEBAR ========== -->

    <div class="container py-3">
      <div class="col-md-12">
        <?php
        // แสดงคอนเทนต์ตาม case
        $con->init();
        ?>
      </div>
    </div>
  </div>

  <script>
    // ฟังก์ชัน JS ของคุณ (ExportToExcel, printDiv, ฯลฯ) วางไว้ตรงนี้ได้
  </script>
</body>

</html>