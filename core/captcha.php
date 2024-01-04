<?php
session_start();

// Tạo một câu trả lời captcha ngẫu nhiên
$chars = '123456789qwertyuiopasdfghjklzxcvbnm';
$captchaLength = 3;
$captchaAnswer = '';
for ($i = 0; $i < $captchaLength; $i++) {
    $captchaAnswer .= $chars[rand(0, strlen($chars) - 1)];
}

// Lưu câu trả lời captcha vào session
$_SESSION['captcha'] = $captchaAnswer;

// Tạo hình ảnh captcha
$width = 100;
$height = 40;
$image = imagecreate($width, $height);

if (!$image) {
    die('Lỗi tạo hình ảnh'); // Thêm xử lý lỗi
}

// Đặt màu nền
$bgColor = imagecolorallocate($image, 255, 255, 255);

// Đặt màu chữ
$textColor = imagecolorallocate($image, 0, 0, 0);

// Vẽ chữ lên hình ảnh captcha
if (!imagettftext($image, 20, 0, 10, 28, $textColor, '../hoangvietdung_public/font/1.ttf', $captchaAnswer)) {
    die('Lỗi vẽ chữ'); // Thêm xử lý lỗi
}

// Đặt header để hiển thị hình ảnh captcha
header('Content-Type: image/png');

// Xuất hình ảnh captcha
imagepng($image);

// Giải phóng bộ nhớ
imagedestroy($image);
?>
