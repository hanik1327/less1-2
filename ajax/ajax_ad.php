<?php
require_once dirname(__FILE__) . '/../inc/func.php';

header("Content-Type: application/json");

if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(["success" => false, "error" => "Ошибка данных!"]);
    exit();
}

$name_header = trim($_POST['name_header']);
$desc = trim($_POST['desc']);
$user_id = $_SESSION['user_id'];

$m_ad = R::xdispense('ads');
$m_ad->name_header = $name_header;
$m_ad->desc = $desc;
$m_ad->users_id = $user_id;
R::store($m_ad);

echo json_encode([
    "success" => true,
    "ad" => [
        "name_header" => $name_header,
        "desc" => mb_strimwidth($desc, 0, 50, "..."),
        "user" => $_SESSION['user_login']
    ]
]);
