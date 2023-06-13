<?php
require_once 'inc/func.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login']);
    $pass = trim($_POST['pass']);

    $errors = [];

    if (empty($login)) {
        $errors[] = "Поле логин не заполнено!";
    }
    if (empty($pass)) {
        $errors[] = "Поле пароль не заполнено!";
    }

    if (empty($errors)) {
        
        $s_user = R::findOne('users', 'login = ?', [$login]);
        
        if (count($s_user) != 0) {
            if (password_verify($pass, $s_user['pass'])) {
                
                $_SESSION['user_id'] = $s_user['id'];
                $_SESSION['user_login'] = $s_user['login'];
                header("Location: ads.php");
                exit();
                
            } else {
                $errors[] = "Неверный логин или пароль!";
            }
        } else {
            $errors[] = "Для начала надо зарегистрироваться!";
        }        

    }
}

require_once 'templates/header.php';
?>

<main style="min-height: 75vh;">
    <div class="container">
        <h1 class="text-center mt-4 mb-4" >Авторизация</h1>
        <form action="login.php" method="POST" style="width: 22rem; margin: 0 auto;">
            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="login" style="margin-left: 0px;">Логин</label>
                <input type="text" id="login" name="login" class="form-control">
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="pass" style="margin-left: 0px;">Пароль</label>
                <input type="password" id="pass" name="pass" class="form-control">
            </div>

            <!-- Submit button -->
            <button type="submit" value="Login" class="btn btn-primary btn-block mb-4" style="display: block; margin: 0 auto;">Войти</button>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Не зарегистрирован ? <a href="/reg.php">Регистрация</a></p>
            </div>
        </form>

        <?php
        // Display errors, if any
        if (!empty($errors)) {
            echo "<ul style='color: red; width: 400px; margin: 0 auto;'>";
            foreach ($errors as $error) {
                echo "<li>" . htmlspecialchars($error) . "</li>";
            }
            echo "</ul>";
        }
        ?>
    </div>
</main>

<?php require_once 'templates/footer.php'; ?>
