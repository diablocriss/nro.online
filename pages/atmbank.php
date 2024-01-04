<?php
  require_once('../core/config.php'); 
  require_once('../core/head.php');
  session_start();
  if (!isset($_SESSION['logger']['username'])) {
      die("Bạn chưa đăng nhập.");
  }
  if (isset($_POST['submit'])) {
    $maGiaoDich = $_POST['magiaodich'];
    $soTien = $_POST['sotien'];

    // Xử lý truy vấn để tìm từ khoá trong cột 'description'
    $query = "SELECT * FROM atm_bank WHERE description LIKE '%$maGiaoDich%'";
    $result = mysqli_query($config, $query);

    if ($result) {
        $numRows = mysqli_num_rows($result);

        if ($numRows > 0) {
            $row = mysqli_fetch_assoc($result);
            $status = $row['status'];
            $creditAmount = $row['creditAmount'];
            $username = $_SESSION['logger']['username'];
            $userCaptcha = $_POST['captcha']; // Lấy câu trả lời captcha nhập từ người dùng

            // Lấy câu trả lời captcha lưu trong session
            $captchaAnswer = $_SESSION['captcha'];

            // Kiểm tra xem câu trả lời captcha có đúng không
            if ($userCaptcha != $captchaAnswer) {
                $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Captcha không đúng. Vui lòng thử lại.</span>';
            } else {
                if ($status == 1) {
                    $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Đã cộng tiền trước đó rồi!</span>';
                } else {
                    // Kiểm tra số tiền có khớp không
                    if ($soTien != $creditAmount) {
                        $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Đừng gian lận số tiền!</span>';
                    } else {
                        // Lấy thông tin người dùng từ bảng 'account'
                        $userQuery = "SELECT id, coin, vnd FROM account WHERE username='$username'";
                        $userResult = mysqli_query($config, $userQuery);

                        if ($userResult) {
                            $userRow = mysqli_fetch_assoc($userResult);
                            $currentCoin = $userRow['coin'];
                            $currentVND = $userRow['vnd'];
                            $userId = $userRow['id'];

                            // Cộng 'creditAmount' vào 'coin' và 'vnd' của 'username' đó
                            $newCoin = $currentCoin + $creditAmount;
                            $newVND = $currentVND + $creditAmount;

                            // Cập nhật giá trị mới vào bảng 'account'
                            $updateQuery = "UPDATE account SET coin=$newCoin, vnd=$newVND WHERE username='$username'";
                            $updateResult = mysqli_query($config, $updateQuery);

                            if ($updateResult) {
                                // Cập nhật 'status' thành 1
                                $updateStatusQuery = "UPDATE atm_bank SET status=1 WHERE description LIKE '%$maGiaoDich%'";
                                $updateStatusResult = mysqli_query($config, $updateStatusQuery);

                                if ($updateStatusResult) {
                                    // Thêm dữ liệu vào bảng 'atm_lichsu' khi cộng tiền thành công
                                    $insertHistoryQuery = "INSERT INTO atm_lichsu (user_nap, thoigian, magiaodich, sotien, status) 
                                                        VALUES ($userId, NOW(), '$maGiaoDich', $soTien, 1)";
                                    $insertHistoryResult = mysqli_query($config, $insertHistoryQuery);

                                    if ($insertHistoryResult) {
                                        $thongbao = '<span style="color: green; font-size: 12px; font-weight: bold;">Cộng tiền thành công!</span>';
                                    } else {
                                        $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Lỗi thêm dữ liệu vào lịch sử!</span>';
                                    }
                                } else {
                                    $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Lỗi cập nhật trạng thái!</span>';
                                }
                            } else {
                                $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Đã xảy ra lỗi khi cộng tiền!</span>';
                            }
                        } else {
                            $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Người dùng không tồn tại!</span>';
                        }
                    }
                }
            }
        } else {
            // Nếu không tìm thấy kết quả từ truy vấn đầu tiên, thử tìm trong cột 'refNo'
            $refNoQuery = "SELECT * FROM atm_bank WHERE refNo LIKE '%$maGiaoDich%'";
            $refNoResult = mysqli_query($config, $refNoQuery);
            $refNoRows = mysqli_num_rows($refNoResult);

            if ($refNoRows > 0) {
                $row = mysqli_fetch_assoc($refNoResult);
                $status = $row['status'];
                $creditAmount = $row['creditAmount'];
                $username = $_SESSION['logger']['username'];
                $userCaptcha = $_POST['captcha']; // Lấy câu trả lời captcha nhập từ người dùng

                // Lấy câu trả lời captcha lưu trong session
                $captchaAnswer = $_SESSION['captcha'];

                // Kiểm tra xem câu trả lời captcha có đúng không
                if ($userCaptcha != $captchaAnswer) {
                    $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Captcha không đúng. Vui lòng thử lại.</span>';
                } else {
                    if ($status == 1) {
                        $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Đã cộng tiền trước đó rồi!</span>';
                    } else {
                        // Kiểm tra số tiền có khớp không
                        if ($soTien != $creditAmount) {
                            $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Đừng gian lận số tiền!</span>';
                        } else {
                            // Lấy thông tin người dùng từ bảng 'account'
                            $userQuery = "SELECT id, coin, vnd FROM account WHERE username='$username'";
                            $userResult = mysqli_query($config, $userQuery);

                            if ($userResult) {
                                $userRow = mysqli_fetch_assoc($userResult);
                                $currentCoin = $userRow['coin'];
                                $currentVND = $userRow['vnd'];
                                $userId = $userRow['id'];

                                // Cộng 'creditAmount' vào 'coin' và 'vnd' của 'username' đó
                                $newCoin = $currentCoin + $creditAmount;
                                $newVND = $currentVND + $creditAmount;

                                // Cập nhật giá trị mới vào bảng 'account'
                                $updateQuery = "UPDATE account SET coin=$newCoin, vnd=$newVND WHERE username='$username'";
                                $updateResult = mysqli_query($config, $updateQuery);

                                if ($updateResult) {
                                    // Cập nhật 'status' thành 1
                                    $updateStatusQuery = "UPDATE atm_bank SET status=1 WHERE refNo LIKE '%$maGiaoDich%'";
                                    $updateStatusResult = mysqli_query($config, $updateStatusQuery);

                                    if ($updateStatusResult) {
                                        // Thêm dữ liệu vào bảng 'atm_lichsu' khi cộng tiền thành công
                                        $insertHistoryQuery = "INSERT INTO atm_lichsu (user_nap, thoigian, magiaodich, sotien, status) 
                                                            VALUES ($userId, NOW(), '$maGiaoDich', $soTien, 1)";
                                        $insertHistoryResult = mysqli_query($config, $insertHistoryQuery);

                                        if ($insertHistoryResult) {
                                            $thongbao = '<span style="color: green; font-size: 12px; font-weight: bold;">Cộng tiền thành công!</span>';
                                        } else {
                                            $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Lỗi thêm dữ liệu vào lịch sử!</span>';
                                        }
                                    } else {
                                        $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Lỗi cập nhật trạng thái!</span>';
                                    }
                                } else {
                                    $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Đã xảy ra lỗi khi cộng tiền!</span>';
                                }
                            } else {
                                $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Người dùng không tồn tại!</span>';
                            }
                        }
                    }
                }
            } else {
                $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Không tìm thấy mã giao dịch nào!</span>';
            }
        }
    } else {
        $thongbao = '<span style="color: red; font-size: 12px; font-weight: bold;">Lỗi truy cập cơ sở dữ liệu!</span>';
    }
}

?>
<main>
      
      <div class="p-1 mt-1 ibox-content" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
                <div class="card">
                  <div class="card-header">
                    <b>Nạp tiền (ATM)</b>
                    <br>
                    <b class="badge" style="background-color: rgb(243, 146, 101);">Tỉ giá quy đổi: 10.000đ = 10.000đ</b>
                    <a href="/napthe"><b class="badge" style="background-color: rgb(243, 101, 106);">Nạp Qua Thẻ Cào (<b>AUTO</b>)</b></a>
                  </div>
                  <div class="card-body">
                    <center><img src="<?=$urlQRmb_config;?>" width="150" /></center>
                    <div class="container">
                      <div class="row">
                          <div class="col-lg-6 col-md-6 mx-auto">
                              <div class="text-center">
                                  <div class="form-group mt-2">
                                      <label><b>Chủ Tài Khoản:</b></label>
                                      <input class="form-control mt-1" type="text" placeholder="<?=$chutaikhoan;?>" style="border-radius: 7px; box-shadow: red 0px 0px 5px; text-align: center;" disabled>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-6 col-md-6 mx-auto">
                              <div class="text-center">
                                  <div class="form-group mt-2">
                                      <label><b>Ngân Hàng: </b><img src="<?=$urllogonganhang_config;?>" width="32" /></label>
                                      <input id="stkInput" class="form-control mt-1" type="text" placeholder="MB Bank" style="border-radius: 7px; box-shadow: red 0px 0px 5px; text-align: center;" disabled>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group mt-2">
                            <label><b>Số Tài Khoản:</b></label>
                            <input id="stkInput" class="form-control mt-1" type="text" placeholder="<?=$sotaikhoanmb_config;?>" style="border-radius: 7px; box-shadow: red 0px 0px 5px; text-align: center;" disabled>
                          </div>
                      </div>
                      <hr>
                      <form style="margin: auto;"
                          method="post" action="">
                          <center><span style="color: orange; font-size: 12px; font-weight: bold;">Trước khi chuyển thành công vui lòng đợi vài phút trước khi kiểm tra!</span><br>
                          <span style="color: black; font-size: 12px; font-weight: bold;">Trạng Thái:</span> <?=$thongbao;?></center>
                          <div class="form-group mt-2">
                            <label>
                              <b>Mã Giao Dịch:</b>
                            </label>
                            <input class="form-control mt-1" type="text" name="magiaodich" placeholder="Nhập mã giao dịch chuyển khoản..." style="border-radius: 7px; box-shadow: red 0px 0px 5px;">
                          </div>
                          <div class="form-group mt-2">
                            <label>
                              <b>Số Tiền Đã Chuyển:</b>
                            </label>
                            <input class="form-control mt-1" type="number" name="sotien" placeholder="Nhập số tiền đã chuyển..." style="border-radius: 7px; box-shadow: red 0px 0px 5px;">
                          </div>
                          <div class="row mt-2">
                            <label>
                              <b>Xác minh:</b>
                            </label>
                          <div class="col-6">
                            <input type="text" class="form-control mt-1" name="captcha" placeholder="Nhập captcha" style="border-radius: 7px; box-shadow: red 0px 0px 5px;">
                          </div>
                          <div class="col-6 mt-2">
                            <div class="style_captchaContainer__LdFYB">
                              <!-- Hiển thị hình ảnh captcha -->
                              <img src="../core/captcha.php" alt="Captcha" class="captcha-image">
                            </div>
                          </div>
                        </div>
                          <div class="form-group mt-2">
                            <button name="submit" type="submit" class="btn btn-action text-white" style="border-radius: 7px;">Kiểm Tra</button>
                          </div>
                        </form>
                      <hr>
                      <div class="text-center">
                          <span style="color: red; font-size: 12px; font-weight: bold;">Coi kỹ trước khi chuyển tránh thiếu sót hoặc nhầm!</span>
                          <div class="form-group mt-2" style="display: inline-block;">
                              <button onclick="copyPlaceholder('stkInput')" class="btn btn-action text-white" style="border-radius: 7px;">Copy STK</button>
                          </div>
                          <div class="form-group mt-2" style="display: inline-block;">
                              <button onclick="copyPlaceholder('ndInput')" class="btn btn-action text-white" style="border-radius: 7px;">Copy ND</button>
                          </div>
                      </div>
                  </div>
                  </div>
                </div>
        		<hr>
        		<div class="table-responsive">
              <div style="line-height: 15px;font-size: 12px;padding-right: 5px;margin-bottom: 8px;padding-top: 2px;" class="text-center">
                <span class="text-black" style="vertical-align: middle;">Hãy <a href="/pages/napthe.php"><b><u>Loading</u></b></a> lại website để cập nhật!</span>
              </div>
              <table class="table table-hover table-nowrap">
                <tbody style="border-color: black;">
                  <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Thời Gian</th>
                    <th scope="col">Mã Giao Dịch</th>
                    <th scope="col">Số Tiền</th>
                    <th scope="col">Trạng Thái</th>
                  </tr>
                   <?php
                      // Lấy user_id từ session
                      $username = $_SESSION['logger']['username'];
                      $sql = "SELECT id FROM account WHERE username = '$username'";
                      $result = $config->query($sql);
                      if ($result->num_rows > 0) {
                          $row_hvd = $result->fetch_assoc();
                          $user_id = $row_hvd["id"];
                      }
                      // Trang hiện tại (mặc định là 1 nếu không được chỉ định)
                      $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                      // Số lượng bản ghi hiển thị trên mỗi trang
                      $recordsPerPage = 5;

                      // Tính toán vị trí bắt đầu của bản ghi trong truy vấn SQL dựa trên trang hiện tại
                      $startFrom = ($page - 1) * $recordsPerPage;

                      // Truy vấn dữ liệu từ bảng "napthe" của người dùng đã đăng nhập với giới hạn số lượng bản ghi và vị trí bắt đầu
                      $query = "SELECT * FROM atm_lichsu WHERE user_nap = $user_id LIMIT $startFrom, $recordsPerPage";
                      $result = mysqli_query($config, $query);
                      // Sử dụng biến cờ để theo dõi có dữ liệu hay không
                   	  $hasData = false;
                      // Hiển thị dữ liệu lên bảng
                      while ($row = mysqli_fetch_assoc($result)) {
                      $hasData = true;
                    ?>
                    <tr>
                              <td><b>#<?=$row['id'];?></b></td>
                              <td><?=$row['thoigian'];?></td>
                              <td><b><?=$row['magiaodich'];?><b></td>
                    		  <td><?=number_format($row['sotien']);?> VNĐ</td>
                              <td>
                              <?php
                        	  if ($row["status"] == 1) {
                                  echo '<font color="green">Thành Công</font>';
                              } 
                        	  ?>
                              </td>
                   </tr> 
                    <?php } 
                                
					// Kiểm tra biến cờ và hiển thị thông báo "Lịch Sử Trống" nếu không có dữ liệu
                   	if (!$hasData) {
                       echo ' <tr>
                                 <td colspan="6" align="center"><span style="font-size:100%;"><< Lịch Sử Nạp Trống >></span></td>
                               </tr>';
                   }
                   ?>
                </tbody>
              </table>
           <?php
          // ...
          // Tính tổng số trang dựa trên số lượng bản ghi và số lượng bản ghi hiển thị trên mỗi trang
          $totalPages = ceil(mysqli_num_rows(mysqli_query($config, "SELECT * FROM napthe WHERE user_nap = $user_id")) / $recordsPerPage);
          ?>

          <!-- Thêm vào sau phần hiển thị lịch sử nạp thẻ -->
          <div class="pagination">
              <?php
              // Hiển thị nút Previous (trang trước)
              if ($page > 1) {
                  echo '<a href="napthe.php?page=' . ($page - 1) . '"><< Trước</a>';
              }

              // Hiển thị các nút trang
              for ($i = 1; $i <= $totalPages; $i++) {
                  echo '<a href="napthe.php?page=' . $i . '">' . $i . '</a>';
              }

              // Hiển thị nút Next (trang kế tiếp)
              if ($page < $totalPages) {
                  echo '<a href="napthe.php?page=' . ($page + 1) . '">Sau >></a>';
              }
              ?>
          </div>
          <style>
              .pagination {
                  display: flex;
                  justify-content: center;
              }

              .pagination a {
                  color: black;
                  padding: 8px 16px;
                  text-decoration: none;
                  border: 1px solid #ddd;
                  margin: 0 4px;
              }

              .pagination a.active {
                  background-color: #4CAF50;
                  color: white;
              }

              .pagination a:hover:not(.active) {
                  background-color: #ddd;
              }
          </style>
            </div>
            </div>
		<div>
   	</div>
</main>
<?php require_once('../core/end.php'); ?>