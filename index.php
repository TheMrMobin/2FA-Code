<?php

require 'vendor/autoload.php';

use OTPHP\TOTP;

function validateHash($hash)
{
    if (strlen($hash) < 16 || strlen($hash) > 32) {
        return false;
    }

    if (!preg_match('/^[A-Z2-7]+$/', $hash)) {
        return false;
    }

    return true;
}

$hash = $_GET['hash'];
if (validateHash($hash)) {
    $hash_valid = $_GET['hash'];
} else {
    die("Invalid hash!");
}
if (empty($hash)) {
    http_response_code(400);
    echo "هش ارسال نشده است.";
    exit;
}

$totp = TOTP::create($hash_valid);

$code = $totp->now();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کد 2FA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Yekan Font -->
    <link href="https://cdn.jsdelivr.net/npm/yekan-font@1.0.0/css/yekan-font.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'yekan', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
        }

        .timer {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .footer {
            background-color: rgba(255, 255, 255, 0.1);
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
            backdrop-filter: blur(5px);
        }

        .code-display {
            cursor: pointer;
            transition: transform 0.2s;
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
        }

        .code-display:hover {
            transform: scale(1.1);
        }

        .fa-shield-alt {
            color: #667eea;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .btn-primary {
            background-color: #667eea;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #764ba2;
        }

        .modal-content {
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .modal-header, .modal-footer {
            border: none;
        }

        .modal-title {
            color: #333;
        }

        .modal-body {
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center flex-grow-1">
        <div class="card text-center p-4" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <!-- آیکون -->
                <i class="fas fa-shield-alt fa-4x mb-4"></i>
                <!-- کد 2FA -->
                <h1 class="card-title code-display" id="code" onclick="copyCode()"><?php echo $code; ?></h1>
                <p class="text-muted">برای کپی کردن کد، روی آن کلیک کنید.</p>
                <!-- تایمر -->
                <div class="timer mt-3">
                    <i class="fas fa-clock me-2"></i>
                    <span id="timer">زمان باقی‌مانده: 10 ثانیه</span>
                </div>
            </div>
        </div>
    </div>

    <!-- فوتر -->
    <footer class="footer">
    <div class="container">
        <span class="text-muted">تمامی حقوق محفوظ میباشد © 2025</span>
        <br>
        <!--<a href="https://t.me/HoleshCloud" target="_blank" style="color: #fff; text-decoration: none;">-->
        <!--    <i class="fab fa-telegram-plane"></i> HoleshCloud-->
        <!--</a>-->
    </div>
    </footer>

    <!-- مدال Bootstrap -->
    <div class="modal fade" id="copyModal" tabindex="-1" aria-labelledby="copyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="copyModalLabel">تأیید</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    کد با موفقیت کپی شد!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">باشه</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS و وابستگی‌ها -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        // زمان تایمر (ثانیه)
        let timeLeft = 10;

        // عنصر تایمر
        const timerElement = document.getElementById('timer');

        // تابع به‌روزرسانی تایمر
        function updateTimer() {
            timerElement.textContent = `زمان باقی‌مانده: ${timeLeft} ثانیه`;
            timeLeft--;

            // اگر زمان به پایان رسید، صفحه را رفرش کن
            if (timeLeft < 0) {
                window.location.reload();
            }
        }

        // هر ثانیه تایمر را به‌روزرسانی کن
        setInterval(updateTimer, 1000);

        // تابع کپی کردن کد
        function copyCode() {
            const codeElement = document.getElementById('code');
            const codeText = codeElement.innerText;

            // کپی کردن کد به کلیپ‌بورد
            navigator.clipboard.writeText(codeText).then(() => {
                // نمایش مدال
                const copyModal = new bootstrap.Modal(document.getElementById('copyModal'));
                copyModal.show();
            }).catch(err => {
                console.error('خطا در کپی کردن کد: ', err);
            });
        }
    </script>
</body>

</html>