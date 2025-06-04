<?php
// Start session to store user preference
session_start();

// Check if theme toggle was clicked
if (isset($_POST['toggle_theme'])) {
    $_SESSION['dark_mode'] = !isset($_SESSION['dark_mode']) || !$_SESSION['dark_mode'];
}

// Check current theme mode
$dark_mode = isset($_SESSION['dark_mode']) && $_SESSION['dark_mode'];
?>

<!DOCTYPE html>
<html lang="zh-TW" class="<?php echo $dark_mode ? 'dark-mode' : 'light-mode'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>高雄大學創意競賽管理系統</title>
    <link rel="stylesheet" href="main2.css">
    <style>
        /* Dark Mode Toggle Styles */
        .theme-toggle-container {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1001;
        }
        
        .theme-toggle {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100px;
            height: 40px;
            padding: 5px;
            border-radius: 50px;
            cursor: pointer;
            background: linear-gradient(135deg,hsl(51, 100.00%, 52.90%) 0%,rgb(255, 239, 168) 100%);
            box-shadow: 0 4px 15px rgba(245, 190, 17, 0.4);
            border: none;
            outline: none;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .dark-mode .theme-toggle {
            background: linear-gradient(135deg, #3a3a3a 0%, #1a1a1a 100%);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }
        
        .theme-toggle:before {
            content: '';
            position: absolute;
            top: 5px;
            left: 5px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: white;
            transition: all 0.3s ease;
            transform: translateX(0);
        }
        
        .dark-mode .theme-toggle:before {
            transform: translateX(60px);
            background-color: #333;
        }
        
        .theme-toggle i {
            font-size: 18px;
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .theme-toggle .sun {
            color: #FFD700;
            opacity: 1;
        }
        
        .dark-mode .theme-toggle .sun {
            opacity: 0;
            transform: translateY(20px);
        }
        
        .theme-toggle .moon {
            color: #f0f0f0;
            opacity: 0;
            transform: translateY(-20px);
        }
        
        .dark-mode .theme-toggle .moon {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Pulse animation for first-time users */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .theme-toggle.pulse {
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body>
    <header>
    <div class="navbar">
        <a href="main.php" alt="Logo" class="logo">
                <img src="images/logo.png" alt="Logo" class="logo">
        </a>
        <h1>高雄大學激發學生創意競賽管理系統</h1>
        
        <!-- Dark Mode Toggle Button -->
        <div class="theme-toggle-container">
            <form method="post" action="" class="theme-toggle-form">
                <button type="submit" name="toggle_theme" class="theme-toggle <?php echo !isset($_SESSION['dark_mode']) ? 'pulse' : ''; ?>">
                    <i class="sun">☀️</i>
                    <i class="moon">🌙</i>
                </button>
            </form>
        </div>
    </div>
    </header>
    <main id="content">
        <h2>歡迎進入創意競賽管理系統</h2>
        <div class="rounded-box">
            <div class="button-container">
                <a href="admin.php" class="system-button">管理員系統</a>
                <a href="student.php" class="system-button">學生系統</a>
                <a href="teacher.php" class="system-button">指導老師系統</a>
                <a href="judge.php" class="system-button">評審系統</a>
            </div>
        </div>
        
        <table>
                <thead>
                    <tr>
                        <th>公告內容</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            include 'conn.php';
                            $sql = "SELECT * FROM 創意競賽 where 屆數 = '第13屆'";
                            $result = mysqli_query($link, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<td>" . $row['公告內容'] . "</td>";
                            }
                        ?>
                    </tr>
        </table>
        <table>
                <thead>
                    <tr>
                        <th>比賽規則</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            include 'conn.php';
                            $sql = "SELECT * FROM 創意競賽 where 屆數 = '第13屆'";
                            $result = mysqli_query($link, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<td>" . $row['比賽規則'] . "</td>";
                            }
                        ?>
                    </tr>
        </table>
        <?php
            include 'conn.php';
            $sql = "SELECT * FROM 創意競賽 where 屆數 = '第13屆'";
            $result = mysqli_query($link, $sql);
            while ($row = mysqli_fetch_array($result)) {
                $blob = base64_encode($row['宣傳海報']);
                echo "<a href='data:application/pdf;base64," . $blob . "' download>宣傳海報.pdf</a>";
            }
        ?>
    </main>
</body>
<footer class="site-footer">
  <div class="footer-content">
    <p>&copy; Copyright © 2025 XC Lee Tiger Lin  How Ho. All rights reserved.</p>
    <div class="footer-row">
    <div class="footer-container">
        <p>聯絡我們 : <a href="mailto:wylin@nuk.edu.tw">wylin@nuk.edu.tw</a></p>
    </div>
      <ul class="footer-links">
        <li><a href="https://github.com/Tiger0124/db_project.git">關於我們</a></li>
      </ul>
    </div>
  </div>
</footer>

<script>
// Enhanced theme toggle with immediate feedback
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.querySelector('.theme-toggle');
    const html = document.documentElement;
    
    // Remove pulse animation after first interaction
    themeToggle.addEventListener('click', function() {
        this.classList.remove('pulse');
    }, { once: true });
    
    // Add smooth transition for theme switch
    themeToggle.addEventListener('click', function(e) {
        // Prevent form submission if JavaScript is working
        e.preventDefault();
        
        // Toggle the theme class immediately
        html.classList.toggle('dark-mode');
        html.classList.toggle('light-mode');
        
        // Send AJAX request to save preference
        fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'toggle_theme=1'
        });
    });
});
</script>

</html>