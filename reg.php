<?php
require_once 'inc/func.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $login = trim($_POST['login']);
    $pass = trim($_POST['pass']);
    $pass_confirm = trim($_POST['pass_confirm']); 
    
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $errors = [];
    
    
    if (empty($login)) {
        $errors[] = "Поле логин пустое!";
    }
    if (empty($pass)) {
        $errors[] = "Поле пароль пустое!";
    } elseif (strlen($pass) < 8) {
        $errors[] = "Минимальная длина пароля 8 символов!";
    }
    if ($pass != $pass_confirm) {
        $errors[] = "Пароли не совпадают!";
    }
    $s_user = R::count('users', 'login = ?', [$login]);
    if ($s_user != 0) {
        $errors[] = "Данный логин уже занят.";
    }
    
    
    if (empty($errors)) {
        
        $m_user = R::xdispense('users');
        $m_user->login = $login;
        $m_user->pass = $pass_hash;
        R::store($m_user);
        
        header("Location: login.php");
        exit();

    }
}
require_once 'templates/header.php';
?>

<main style="min-height: 75vh;">
    <div class="container">
        <h1 class="text-center mt-4 mb-4">Регистрация</h1>
        <form action="reg.php" method="POST" style="width: 22rem; margin: 0 auto;">
            
            <div class="form-outline mb-4">
                <label class="form-label" for="login" style="margin-left: 0px;">Логин</label>
                <input type="text" id="login" name="login" class="form-control">
            </div>            
            <div class="form-outline mb-4">
                <label class="form-label" for="pass" style="margin-left: 0px;">Пароль</label>
                <input type="password" id="pass" name="pass" class="form-control">
            </div>            
            <div class="form-outline mb-4">
                <label class="form-label" for="pass_confirm" style="margin-left: 0px;">Повтор пароля</label>
                <input type="password" id="pass_confirm" name="pass_confirm" class="form-control">
            </div>
            
            <button type="submit" class="btn btn-primary btn-block mb-4" style="display: block; margin: 0 auto;">Регистрация</button>

            <!-- Register buttons -->
            <div class="text-center">
                <p>Зарегистрирован ? <a href="/login.php">Вход</a></p>
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
