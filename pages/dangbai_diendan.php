<?php
    require_once('../core/config.php'); 
    require_once('../core/head.php');
    $thongbao = null;
    session_start();
    if (!isset($_SESSION['logger']['username'])) {
        die("Bạn chưa đăng nhập.");
    }
    $sql_admin = "SELECT id FROM account WHERE username = '$_username'";
    $result = $config->query($sql_admin);

    if ($result && $result->num_rows > 0) {
        $row_admin = $result->fetch_assoc();
    }
    $sql_active = "SELECT active FROM account WHERE username = '$_username'";
    $result = $config->query($sql_active);

    if ($result && $result->num_rows > 0) {
        $row_active = $result->fetch_assoc();
    }
    $sql = "SELECT id FROM account WHERE username = '$_username'";
      $result = $config->query($sql);
      
      if ($result->num_rows > 0) {
          // Lấy id từ kết quả truy vấn
          $row_hvd = $result->fetch_assoc();
          $accountId = $row_hvd["id"];
          // Kiểm tra sự tồn tại của account_id trong player
          $sql_check_player = "SELECT COUNT(*) as player_count FROM player WHERE account_id = '$accountId'";
          $result_check_player = $config->query($sql_check_player);

          if ($result_check_player && $result_check_player->num_rows > 0) {
              $row_check_player = $result_check_player->fetch_assoc();
              $player_exists = $row_check_player['player_count'] > 0;
          } else {
              $player_exists = false;
          }

      
          // Truy vấn để lấy giá trị giới tính từ bảng Player
          $sql = "SELECT gender FROM player WHERE id = $accountId";
          $result = $config->query($sql);
      
          if ($result->num_rows > 0) {
              // In ra giá trị giới tính
              $row_hvd = $result->fetch_assoc();
          }
      }
    if (isset($_POST['submit']) && isset($_POST['tieude']) && isset($_POST['noidung'])) {
        $tieude = $_POST['tieude'];
        $noidung = $_POST['noidung'];
        $account_id = $accountId; // Lấy id của người dùng từ câu truy vấn ban đầu
        $captcha = $_POST['g-recaptcha-response'];
        // if(!$captcha){
        //     $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Hãy xác minh captcha!</span>';
        // } else {
            // Kiểm tra nội dung bình luận không được bỏ trống
            if (empty($noidung)) {
                  $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Vui lòng nhập nội dung bài đăng!</span>';
              } else {
            if($row_admin['id'] == 1){
                $new = $_POST['new'];
                $new_avt = $_POST['new_avt'];
                $top_baiviet = $_POST['top_baiviet'];

                // Thực hiện truy vấn để lưu bình luận vào cơ sở dữ liệu
                $sql = "INSERT INTO baiviet_hoangvietdung (account_id, top_baiviet, new,avta, tieude, noidung, time) 
                VALUES ('$account_id', '$top_baiviet', '$new','$new_avt', '$tieude', '$noidung', NOW())";
            } else {
                $sql = "INSERT INTO baiviet_hoangvietdung (account_id, top_baiviet, new,avta, tieude, noidung, time) 
                VALUES ('$account_id', 0, 0, 0, '$tieude', '$noidung', NOW())";
            }
            $result = $config->query($sql);
            $baiviet_id_new = $config->insert_id;
            // Thực hiện kiểm tra và thông báo kết quả lưu bình luận
            if ($result) {
                $thongbao = '<span style="color: green; font-size: 12px; font-weight: bold;">Đăng bài thành công!</span>';
                echo '<script>window.location.href = "/pages/diendan.php?id='.$baiviet_id_new.'";</script>';
            } else {
                $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Đã xảy ra lỗi!</span>';
            }
            
            // Kiểm tra sự tồn tại của account_id trong player
            if (!$player_exists) {
                $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Hãy tạo nhân vật trước khi đăng bài!</span>';
            }
            }
        // }
    }
?>
<div class="p-1 mt-1 pb-1" style="background: #ffe8d1;border-radius: 7px; box-shadow: 0px 0px 5px black;">
                <div class="pb-1" style="border-radius: 7px;padding: 20px;margin:auto;">
                    <center><?=$thongbao;?></center>
                    <form method="POST" action="">
                        
                        <h1 class="h3 mb-3 font-weight-normal" style="padding-top:3px; font-weight:bold; text-align:center;">Đăng Bài Viết</h1>
                        <b>Tiêu đề</b>
                        <input type="text" class=" form-control" style="border-radius: 7px;" placeholder="Tiêu đề (không quá 75 ký tự)" required="" autofocus="" name="tieude">
                        <br>
                        <b>Nội dung</b>
                        <textarea class="form-control" style="border-radius: 7px;" name="noidung" id="" cols="30" rows="10" placeholder="Nội dung (không được quá 256 ký tự)"></textarea>
                        <?php if($row_admin['id'] == 1){ ?>
                        <br>
                        <b>Top bài viết</b>
                        <select class="form-control" style="border-radius: 7px;" name="top_baiviet">
                            <option value="0">Không</option>
                            <option value="1">Có</option>
                            <option value="1"><?php echo $row_admin['id'] ?></option>
                        </select>
                        <br>
                        <b>Icon bài viết</b>
                        <select class="form-control" style="border-radius: 7px;" name="new">
                            <option value="0">Không</option>
                            <option value="1">Icon New</option>
                            <option value="2">Icon Hot</option>
                            <option value="3">Icon Danger</option>
                        </select>
                        <br>
                        <b>Avata Admin:</b>
                        <select class="form-control" style="border-radius: 7px;" name="new_avt" onchange="displayImage(this)">
                            <option value="0">Không</option>
                            <option value="1">Avata 1</option>
                            <option value="2">Avata 2</option>
                            <option value="3">Avata 3</option>
                            <option value="4">Avata 4</option>
                            <option value="5">Avata 5</option>
                            <option value="6">Avata 6</option>
                            <option value="7">Avata 7</option>
                            <option value="8">Avata 8</option>
                            <option value="9">Avata 9</option>
                            <option value="10">Avata 10</option>

                        </select>
                        <br><?php } ?><br>
                        <div id="imageContainer"></div>

                        <script>
                            // Khai báo sự kiện onchange và liên kết với hàm displayImage
                            function displayImage(selectElement) {
                                var value = selectElement.value;
                                var imageContainer = document.getElementById("imageContainer");

                                // Xóa hình ảnh hiện tại (nếu có)
                                imageContainer.innerHTML = "";

                                if (value === "1") {
                                    // Tạo và thêm hình ảnh Icon New
                                    var image = document.createElement("img");
                                    image.src = "../public/images/logo/a1.png";
                                    imageContainer.appendChild(image);
                                } else if (value === "2") {
                                    // Tạo và thêm hình ảnh Icon Hot
                                    var image = document.createElement("img");
                                    image.src = "../public/images/logo/a2.png";
                                    imageContainer.appendChild(image);
                                } else if (value === "3") {
                                    // Tạo và thêm hình ảnh Icon Hot
                                    var image = document.createElement("img");
                                    image.src = "../public/images/logo/a3.png";
                                    imageContainer.appendChild(image);
                                } else if (value === "4") {
                                    // Tạo và thêm hình ảnh Icon Hot
                                    var image = document.createElement("img");
                                    image.src = "../public/images/logo/a4.png";
                                    imageContainer.appendChild(image);
                                } else if (value === "5") {
                                    // Tạo và thêm hình ảnh Icon Hot
                                    var image = document.createElement("img");
                                    image.src = "../public/images/logo/a5.png";
                                    imageContainer.appendChild(image);
                                } else if (value === "6") {
                                    // Tạo và thêm hình ảnh Icon Hot
                                    var image = document.createElement("img");
                                    image.src = "../public/images/logo/a6.png";
                                    imageContainer.appendChild(image);
                                } else if (value === "7") {
                                    // Tạo và thêm hình ảnh Icon Hot
                                    var image = document.createElement("img");
                                    image.src = "../public/images/logo/a7.png";
                                    imageContainer.appendChild(image);
                                } else if (value === "8") {
                                    // Tạo và thêm hình ảnh Icon Hot
                                    var image = document.createElement("img");
                                    image.src = "../public/images/logo/a8.png";
                                    imageContainer.appendChild(image);
                                } else if (value === "9") {
                                    // Tạo và thêm hình ảnh Icon Hot
                                    var image = document.createElement("img");
                                    image.src = "../public/images/logo/a9.png";
                                    imageContainer.appendChild(image);
                                } else if (value === "10") {
                                    // Tạo và thêm hình ảnh Icon Hot
                                    var image = document.createElement("img");
                                    image.src = "../public/images/logo/a10.png";
                                    imageContainer.appendChild(image);
                                }
                            }
                        </script>
                        
                        <?php if ($player_exists) { ?>
                            
                            <div class="g-recaptcha" data-sitekey="<?=$site_key;?>"></div>

                            <div style="text-align: center;">
                                <button class="btn btn-action text-black m-1" name="submit" type="submit" style="border-radius: 7px;"><i class="fa fa-comment"></i>  Đăng bài</button>
                                <a class="btn btn-action text-black m-1" style="border-radius: 7px;" href="/pages/diendan.php"><i class="fa fa-sign-in"></i> Quay lại</a>
                            </div>
                        <?php } else { ?>
                            <span style="color: red; font-size: 12px; font-weight: bold;"><b><i>Hãy tạo nhân vật hoặc kích hoạt trước khi <u>đăng bài</u>!</i></b></span>
                        <?php } ?>
                    </form>
                </div>
</div>

<?php require_once('../core/end.php'); ?>