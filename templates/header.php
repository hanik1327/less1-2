<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой сайт объявлений</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</head>

<body>
    <header>
        <div class="container">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                    <span class="fs-4">Сайт объявлений</span>
                </a>

                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="/index.php" class="nav-link">Главная</a></li>
                    <li class="nav-item"><a href="/ads.php" class="nav-link">Обьявления</a></li>
                    <li>
                        <?php if (isset($_SESSION['user_login'])){ ?>
                    <li class="nav-item"><a href="/logout.php" title="Нажмите что бы выйти профиля." class="nav-link"><?php echo $_SESSION['user_login']; ?></a></li>
                    <?php } else { ?>
                    <li class="nav-item"><a href="/login.php" class="nav-link">Вход</a></li>
                    <li class="nav-item"><a href="/reg.php" class="nav-link">Регистрация</a></li>
                    <?php } ?>
                    </li>
                </ul>
            </header>
        </div>
    </header>
