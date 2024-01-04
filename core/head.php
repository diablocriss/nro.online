<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ERROR);
    session_start();
    unset($_SESSION["errors"]);
    $_username = $_SESSION['logger']['username'];
      $sql = "SELECT id FROM account WHERE username = '$_username'";
      $result = $config->query($sql);
      
      if ($result->num_rows > 0) {
          // Lấy id từ kết quả truy vấn
          $row = $result->fetch_assoc();
          $accountId = $row["id"];
      
          // Truy vấn để lấy giá trị giới tính từ bảng Player
          $sql = "SELECT gender, vnd FROM player WHERE account_id = $accountId";
          $sqll = "SELECT id, vnd FROM account WHERE id = $accountId";
          $result = $config->query($sql);
          $resultt = $config->query($sqll);
      
          if ($result->num_rows > 0) {
              // In ra giá trị giới tính
              $row = $result->fetch_assoc();
          }
		   if ($resultt->num_rows > 0) {
              // In ra giá trị giới tính
              $roww = $resultt->fetch_assoc();
          }
      }
?> <html lang="en">
  <head>
    
  <link href="path_to_select2_css/select2.min.css" rel="stylesheet" />
    <script src="path_to_jquery/jquery.min.js"></script>
    <script src="path_to_select2_js/select2.min.js"></script>
    <style>
        .select2-icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-right: 5px;
        }
    </style>
    <script>
        $(document).ready(function() {
            function formatOption(option) {
                if (!option.id) {
                    return option.text;
                }

                var iconClass = $(option.element).data('icon');
                var iconAlt = $(option.element).data('icon-alt');

                var $option = $('<span><img src="' + iconClass + '" class="select2-icon" alt="' + iconAlt + '" /> ' + option.text + '</span>');

                return $option;
            }

            $('.my-select').select2({
                templateResult: formatOption
            });
        });
    </script>
    <!-- Import SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">

<!-- Import SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?=$tieude;?></title>
    <link rel="canonical" href="<?=$link_web;?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../public/images/logo/logo7.png">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <!-- mycss -->
    <link rel="stylesheet" href="../public/css/hoangvietdung.css?hoangvietdung=<?=rand(0,100000);?>">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <!-- Captcha Goole -->
    <script src='https://www.google.com/recaptcha/api.js' async defer ></script>
    <style type="text/css">
      #hoangvietdung {
        background-color: black;
        opacity: 0.9;
      }

      #hoangvietdung2{
           padding:30px;
           background-color:rgba(0,0,0,0.3);
        }
      #custom-hr {
        border: none;
        border-top: 1px solid #000;
        margin: 10px 0;
      }
      #custom-hr2 {
        border: none;
        border-top: 1px solid #000;
        margin: 10px 0;
      }
    </style>
  </head>
  <body class="girlkun-bg" id="hoangvietdung">
    <div class="container-md p-1 col-sm-12 col-lg-6" style="background:#faa42e; border-radius: 7px; border: 2px solid #f48124; box-shadow: 0 0 15px #faa42e;">
      <style>

        .btn-navbar{
            background-color: #5E17EB;
            border-color: black;
            text-shadow: 1px 1px 0 black;
        }
        .btn-navbar:hover,
        .btn-navbar:focus {
            background-color:#5500FF;
            border-color: 1px solid black;
            font-weight: bold;
        }
        .image-container {
          max-width: 500px;
          margin-left: auto;
          margin-right: auto;
        }
       
        .table-custom, .table-custom tr, .table-custom td, .table-custom th {
          border: none !important;
        }
        .table-custom th, .table-custom td:first-child {
          width: 150px;
        }
        .image-container img {
          width: 100%;
          height: auto;
        }
        #snow {
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          pointer-events: none;
          z-index: -70;
        }
        @keyframes blink {
          0% { color: black; }
          50% { color: red; }
          100% { color: black; }
        }
        @keyframes flashing {
          0% {
            border-color: black;
          }
          50% {
            border-color: yellow;
          }
          100% {
            border-color: black;
          }
        }
        @keyframes flashing1 {
          0% {
            border-color: black;
          }
          50% {
            border-color: red;
          }
          100% {
            border-color: black;
          }
        }
        @keyframes flashing2 {
          0% {
            border-color: black;
          }
          50% {
            border-color: #9CF100;
          }
          100% {
            border-color: black;
          }
        }
        @keyframes stretch {
          0% {
            transform: scale(1);
          }
          50% {
            transform: scale(1.2);
          }
          100% {
            transform: scale(1);
          }
        }
        .text-black1 {
          animation: blink 0.5s infinite;
        }

        @keyframes blinking {
          0% { color: #FF0000; }
          50% { color: #FFFFFF; }
          100% { color: #FF0000; }
        }

        .blinking-link {
          animation: blinking 0.5s infinite;
        }
      </style>
      <div id="snow"></div>
      <script>
    document.addEventListener('DOMContentLoaded', function () {
        var script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js';
        script.onload = function () {
            particlesJS("snow", {
                "particles": {
                    "number": {
                        "value": 75,
                        "density": {
                            "enable": true,
                            "value_area": 400
                        }
                    },
                    "color": {
                        "value": "#fec949"
                    },
                    "opacity": {
                        "value": 1,
                        "random": true,
                        "anim": {
                            "enable": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": true
                        }
                    },
                    "line_linked": {
                        "enable": true
                    },
                    "move": {
                        "enable": true,
                        "speed": 1,
                        "direction": "top",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": true,
                            "rotateX": 300,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "events": {
                        "onhover": {
                            "enable": false
                        },
                        "onclick": {
                            "enable": false
                        },
                        "resize": false
                    }
                },
                "retina_detect": true
            });
        }
        document.head.append(script);
    });

</script>

      <main>
        <!-- header -->
        <div style="background-color: rgba(57,57,57, 0.7); border-radius: 7px; box-shadow: 0px 2px 5px black;" class="pb-1 ">
          <!-- logo -->
          <style>
            .hovered img {
              transform: scale(1.1);
            }
            a img {
    transition: transform 0.3s ease;
  }
          </style>
          <div class="p-xs">
          <div class="image-container">
          <a href="/index.php" onmouseover="addHoverClass(this)" onmouseout="removeHoverClass(this)">
            <center><img style="width:80%;"src="<?=$logo;?>" alt="Logo"></center>
          </a>
          </div>
          </div>
          <script>
            function addHoverClass(element) {
              element.classList.add("hovered");
            }

            function removeHoverClass(element) {
              element.classList.remove("hovered");
            }
          </script>
              <!-- navbar -->
              <div class="row text-center p-3 pb-1 pt-1" style="border-radius: 10px; display: flex; justify-content: center;">
                  <a href="/index.php" class="btn btn-navbar text-white col-4" style="padding: 0.5rem 1rem; text-align: center; box-shadow: 0 0 7px #bbf9f1; border-color: #f48124; text-decoration: none; background-color: #000; color: #fff; font-size: 0.9rem; white-space: nowrap;" onmouseover="this.style.backgroundColor='#bbf9f1'" onmouseout="this.style.backgroundColor='#000'">
                      <i class="fa fa-home" style="display: inline-block; margin-right: 0.5rem;"></i> Trang chủ
                  </a>
                  <a href="https://ngocrongwind.online/pages/diendan.php" class="btn btn-navbar text-white col-4" style="padding: 0.5rem 1rem; text-align: center; box-shadow: 0 0 7px #bbf9f1; border-color: #f48124; text-decoration: none; background-color: #000; color: #fff; font-size: 0.9rem; white-space: nowrap;" onmouseover="this.style.backgroundColor='#bbf9f1'" onmouseout="this.style.backgroundColor='#000'">
                      <i class="fa fa-group" style="display: inline-block; margin-right: 0.5rem;"></i> Diễn Đàn
                  </a>
                  <a href="https://zalo.me/g/lznxfc137" target="_blank" class="btn btn-navbar text-white col-4" style="padding: 0.5rem 1rem; box-shadow: 0 0 7px #bbf9f1; border-color: #f48124; text-align: center; text-decoration: none; background-color: #000; color: #fff; font-size: 0.9rem; white-space: nowrap;" onmouseover="this.style.backgroundColor='#bbf9f1'" onmouseout="this.style.backgroundColor='#000'">
                      <i class="fa fa-comments" style="display: inline-block; margin-right: 0.5rem;"></i> Group Zalo
                  </a>
                  <a href="/pages/qrmomo.php" target="_blank" class="btn btn-navbar text-white col-4" style="padding: 0.5rem 1rem; box-shadow: 0 0 7px #bbf9f1; border-color: #f48124; text-align: center; text-decoration: none; background-color: #000; color: #fff; font-size: 0.9rem; white-space: nowrap;" onmouseover="this.style.backgroundColor='#bbf9f1'" onmouseout="this.style.backgroundColor='#000'">
                      <i class="fa fa-comments" style="display: inline-block; margin-right: 0.5rem;"></i> Nạp thẻ
                  </a>
                  
              </div>
                    
          <!-- download -->
          <div class="text-center mt-2">
            <a href="https://www.mediafire.com/file/0mu6bnutmiw7z46/NroWind.jar/file" target="_blank" class="btn btn-download text-white" style="border-radius: 10px; width: 100px;">
                <i class="fa fa-download"></i> JAR</a>
            <a href="https://www.mediafire.com/file/qegf716xcsdx8fl/NgocRongWind.zip/file" target="_blank" class="btn btn-download text-white" style="border-radius: 10px; width: 100px;">
                <i class="fa fa-windows"></i> PC</a>
			<a href="https://www.mediafire.com/file/bx3d37rtgltnwaz/NgocRongWind.apk/file" target="_blank" class="btn btn-download text-white" style="border-radius: 10px; width: 100px;">
                <i class="fa fa-android"></i> APK</a>
            <a href="https://testflight.apple.com/join/YjryUGR8" target="_blank" class="btn btn-download text-white" style="border-radius: 10px; width: 100px;">
                <i class="fa fa-apple"></i> IOS</a>
          </div>
		  
        </div>
        <!--body-->


        <div class="col text-center mt-2 " >
          <div class="user_name"> <?php if ($_SESSION['logger']['username']) { ?> <center>
            <?php
              if(!$row["gender"]){
                echo '<img src="../public/images/icon/3.png" />';
              } else {
                  echo '<img style="width: 150px;" src="../public/images/icon/'.$row["gender"].'.png" />';
              }
            ?>
              <br>
            </center>
            <label>
              <a style="color: black">Chào,</a>
            </label>
            <b style="color: #ff0000"> <?php echo $_SESSION['logger']['username']?> </b> - <i class="fa fa-money"></i>
            <b> <?=number_format($roww["vnd"]);?> VNĐ</b>
            <br>
             <?php } else { ?> <?php } ?>
          </div> 
          
          
          
          <?php if ($_SESSION['logger']['username']) { ?> 
          <a href="/napthe.php" class="btn btn-action m-1 text-black" style="border-radius: 10px;">
            <i class="fa fa-credit-card"></i> Nạp </a>
          <a href="/pages/doimatkhau.php" class="btn btn-action m-1 text-black" style="border-radius: 10px;">
            <i class="fa fa-address-card"></i> Đổi Mật Khẩu </a>
			
          <a href="/pages/kichhoat.php" class="btn btn-action m-1 text-black" style="border-radius: 10px;">
            <i class="fa fa-check-circle-o"></i> Kích Hoạt </a>
          <a href="" class="btn btn-action m-1 text-black" style="border-radius: 10px;">
            <i class="fa fa-group"></i> Group Zalo</a>
          <a href="/pages/dangxuat.php" class="btn btn-action m-1 text-black" style="border-radius: 10px;">
            <i class="fa fa-sign-in"></i> Đăng Xuất </a> <br>
            <?php } else { ?> 
          <a href="/pages/dangnhap.php" class="btn btn-action m-1 text-black" style="border-radius: 10px;">
            <i class="fa fa-sign-in"></i> Đăng nhập </a>
          <a href="/pages/dangky.php" class="btn btn-action m-1 text-black" style="border-radius: 10px;">
            <i class="fa fa-user-plus"></i> Đăng ký </a>
          <?php } ?>
			
        </div>
        


