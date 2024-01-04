<?php
// Hãy tôn trọng bản quyền của tác giả, không nên chỉnh sửa nguồn! Huỳnh <3: 
global $config;
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "bokin";

# Cấu hình
$tieude = "Ngọc Rồng Huỳnh";
$ten_server = "Ngọc Rồng Huỳnh";
$link_web = "https://ngocrongwind.online";
$logo = "../public/images/logo/logo7.png";
$id_npc = "6101";
$gia_mtv = 10000; //giá sẽ trừ vào số dư để mtv
# Đường dẫn tải phiên bản và box zalo
$java = "/taive/";
$pc = "/taive/NgocRongWind.zip";
$adr = "/taive/NgocRongWind.apk";
$ios = "/taive/";
$box_zalo = "https://zalo.me/g/lznxfc137";


$config = mysqli_connect($serverName, $userName, $password, $dbName);

if (mysqli_connect_errno()) {
    echo "Sai hoặc Chưa kết nối Database!";
    exit();
}

?>
