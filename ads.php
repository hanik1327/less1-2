<?php
require_once 'inc/func.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$array_user = [];
$users = R::findAll('users');
foreach ($users as $user){
    $array_user_login[ $user['id'] ] = $user['login'];
}
unset($users);

$ads = R::findAll('ads', 'ORDER BY id DESC');

require_once 'templates/header.php';
?>

<main style="min-height: 75vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h3 class="text-center">Создание объявления</h3>
                <form id="ad_form" action="login.php" method="POST" style="width: 22rem; margin: 0 auto;">
                    <div class="form-outline mb-4">
                        <label class="form-label" for="name_header" style="margin-left: 0px;">Заголовок</label>
                        <input type="text" id="name_header" name="name_header" class="form-control" required>
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="desc" style="margin-left: 0px;">Описание</label>
                        <textarea type="textarea" id="desc" name="desc" class="form-control" required></textarea>
                    </div>
                    <button type="submit" value="Login" class="btn btn-primary btn-block mb-4" style="display: block; margin: 0 auto;">Разместить</button>
                </form>
            </div>
            <div class="col-lg-8">
                <h3 class="text-center">Список объявлений</h3>
                <table class="table ads_table">
                    <thead>
                        <tr>
                            <th scope="col">Заголовок</th>
                            <th scope="col">Описание</th>
                            <th scope="col">Пользователь</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ads as $ad): ?>
                        <tr>
                            <td><?php echo $ad['name_header']; ?></td>
                            <td><?php echo mb_strimwidth($ad['desc'], 0, 50, "..."); ?></td>
                            <td><?php echo $array_user_login[ $ad['users_id'] ]; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<script>

    document.getElementById("ad_form").addEventListener("submit", function(event) {
        
        event.preventDefault();
        const formData = new FormData(event.target);

        fetch("/ajax/ajax_ad.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const adRow = `
                    <tr>
                        <td>${data.ad.name_header}</td>
                        <td>${data.ad.desc}</td>
                        <td>${data.ad.user}</td>
                    </tr>
                `;
                    document.querySelector(".ads_table tbody").insertAdjacentHTML("afterbegin", adRow);
                } else {
                    alert(data.error);
                }
            });
    });

</script>

<?php require_once 'templates/footer.php'; ?>
