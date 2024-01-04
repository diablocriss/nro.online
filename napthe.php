<?php
session_start();
require_once('core/config.php'); 
require_once('core/head.php'); 
include('set.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start(); //khởi động phiên làm việc
}

$_alert = null;
$_title = "NRO WIND - Thanh Toán";
if($_login == null) {header("location:/login.php");}
?> 

   <head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<link rel="stylesheet" href="https://cdn.rawgit.com/daneden/animate.css/v3.1.0/animate.min.css">
		<script src='https://cdn.rawgit.com/matthieua/WOW/1.0.1/dist/wow.min.js'></script>
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.6/css/mdb.min.css" /> -->
		<link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">
		<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"> -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>
<main>

	<script type="text/javascript"> new WOW().init(); </script>
	<div class="p-1 mt-1  " style="background-color: rgba(57,57,57, 0.7); border-radius: 7px; box-shadow: 0px 2px 5px black;">
            <div class="card-body" >
            <form method="POST" action="#" id="myform">
				     <tbody>
                      <center><h1 class="h3 mb-3 font-weight-normal text-white" style="padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Nạp Thẻ Tự Động</h1></center>
                     
						
						<label class="text-white">- Zalo ADMIN: 0866967792 </label>
						<br>
						<label class="text-white">- Nạp ATM/Momo qua Admin để không bị trừ chiết khấu ! </label>
						<div class="text-white">- Chụp lại ảnh sau sau khi Chuyển tiền để ADMIN check lại</div>
						<div class="text-white">- Nếu ADMIN chưa rep ngay thì vui lòng đợi ! </div>
						<div class="text-white">- Ibox Cho Admin Để Được Hỗ Trợ Nhanh Nhất!</div>

				</form>
            </div>
		</div>
		</div>
		
		<br>
		
			
	    <div id="status"></div>
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
        <!-- Code made in tui 127.0.0.1 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>	
</main> <?php require_once('core/end.php'); ?>