<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard");
    exit();
}

require_once('../inc/db.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($userId, $hashedPassword);
            $stmt->fetch();
            
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $userId;
                
                header("Location: dashboard");
                exit();
            } else {
                $error = 'Invalid email or password.';
            }
        } else {
            $error = 'Invalid email or password.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Libas e Khas</title>
    <link rel="icon" type="image/png" href="../assets/images/logo.webp">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-radius: 12px;
        }
        .login-card .card-header {
            background-color: #111;
            color: #fff;
            text-align: center;
            padding: 2rem 1rem;
            border-radius: 12px 12px 0 0;
            border-bottom: 2px solid #C5A059;
        }
        .login-card .card-body {
            padding: 2.5rem;
            background: #fff;
            border-radius: 0 0 12px 12px;
        }
        .form-control:focus {
            border-color: #C5A059;
            box-shadow: 0 0 0 0.25rem rgba(197, 160, 89, 0.25);
        }
        .btn-gold {
            background-color: #C5A059;
            color: #fff;
            border: none;
        }
        .btn-gold:hover {
            background-color: #b08d4b;
            color: #fff;
        }

        /* Mobile Restriction Overlay */
        .mobile-restricted-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: var(--color-ivory, #fffaf0);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 991px) {
            .mobile-restricted-overlay {
                display: flex;
            }
            body > :not(.mobile-restricted-overlay) {
                display: none !important;
            }
            body {
                background-color: var(--color-ivory, #fffaf0);
                overflow: hidden;
            }
        }
    </style>
</head>
<body>

<div class="mobile-restricted-overlay">
    <div class="text-center p-4">
        <i class="fas fa-desktop fs-1 mb-3" style="color: #C5A059;"></i>
        <h4 class="font-heading fw-bold mb-2 text-dark">Desktop Recommended</h4>
        <p class="font-body text-muted small">For the best experience and to access all administrative features, please use a laptop or desktop computer.</p>
    </div>
</div>

<div class="login-card">
    <div class="card-header">
        <h3 class="font-heading mb-0 text-white">Libas e Khas</h3>
        <p class="mb-0 text-white-50 small mt-1 font-body">Admin Portal</p>
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <div class="mb-4">
                <label for="email" class="form-label font-body fw-medium">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                    <input type="email" class="form-control border-start-0 ps-0 bg-light" id="email" name="email" required autofocus>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label font-body fw-medium">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                    <input type="password" class="form-control border-start-0 ps-0 bg-light" id="password" name="password" required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-gold w-100 py-2 font-body fw-bold text-uppercase mt-2">Sign In</button>
        </form>
    </div>
</div>

<?php if (!empty($error)): ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'error',
            title: 'Authentication Failed',
            text: '<?php echo addslashes($error); ?>',
            confirmButtonColor: '#C5A059'
        });
    });
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
