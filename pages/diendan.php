<?php
require_once('../core/config.php');
require_once('../core/head.php');
$thongbao = null;
$thongbao_admin = null;
// Kiểm tra xem người dùng có phải là quản trị viên hay không
$sql_admin = "SELECT id FROM account WHERE username = '$_username'";
$result_admin = $config->query($sql_admin);
$row_admin = ($result_admin && $result_admin->num_rows > 0) ? $result_admin->fetch_assoc() : null;
// Kiểm tra xem người dùng có hoạt động hay không
$sql_active = "SELECT active FROM account WHERE username = '$_username'";
$result_active = $config->query($sql_active);
$row_active = ($result_active && $result_active->num_rows > 0) ? $result_active->fetch_assoc() : null;
// Lấy ID tài khoản
$sql = "SELECT id FROM account WHERE username = '$_username'";
$result = $config->query($sql);
if ($result->num_rows > 0) {
    $row_hvd = $result->fetch_assoc();
    $accountId = $row_hvd["id"];
    // Kiểm tra sự tồn tại của ID tài khoản trong bảng player
    $sql_check_player = "SELECT COUNT(*) as player_count FROM player WHERE account_id = '$accountId'";
    $result_check_player = $config->query($sql_check_player);
    $row_check_player = ($result_check_player && $result_check_player->num_rows > 0) ? $result_check_player->fetch_assoc() : null;
    $player_exists = ($row_check_player && $row_check_player['player_count'] > 0);
    // Lấy giới tính từ bảng player
    $sql_gender = "SELECT gender FROM player WHERE account_id = $accountId";
    $result_gender = $config->query($sql_gender);
    $row_gender = ($result_gender && $result_gender->num_rows > 0) ? $result_gender->fetch_assoc() : null;
}


$profanityFilter = file('../profanity.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Function to check if the comment contains profanity
function containsProfanity($comment, $profanityFilter) {
    foreach ($profanityFilter as $word) {
        if (stripos($comment, $word) !== false) {
            return true;
        }
    }
    return false;
}


// Xử lý khi người dùng gửi bình luận
if (isset($_POST['submit']) && isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $baiviet_id = $_GET['id'];
    $captcha = $_POST['g-recaptcha'];
        if(!$captcha){
            $thongbao = 'Hãy xác minh captcha!';
        } else {
          if (empty($comment)) {
              $thongbao = 'Vui lòng nhập nội dung bình luận!';
          } else {
                if (containsProfanity($comment, $profanityFilter)) {
                    $thongbao = 'Nội dung bình luận chứa từ ngữ không phù hợp!';
                } else {
                    $sql_comment = "INSERT INTO cmt_hoangvietdung (baiviet_id, khach_id, noidung, time) VALUES ('$baiviet_id', '$accountId', '$comment', NOW())";
                    $result_comment = $config->query($sql_comment);
                    if ($result_comment) {
                        $thongbao = 'Bình luận thành công!';
                    } else {
                        $thongbao = 'Đã xảy ra lỗi!';
                    }
                    if (!$player_exists) {
                        $thongbao = 'Hãy tạo nhân vật trước khi đăng bài!';
                    }
                }
          }
        }
}
if (isset($_GET['id'])) {
    $id_delete = $_GET['id'];
    if ($row_admin['id'] == 1) {
        if (isset($_GET['delete'])) {
            $sql_delete = "DELETE FROM baiviet_hoangvietdung WHERE id = $id_delete";

            if ($config->query($sql_delete) === TRUE) {
                echo '<script>window.location.href = "/pages/diendan.php";</script>';
            } else {
                $thongbao_admin =  'Đã xảy ra lỗi!';
            }
        }
    }
} else {
    $thongbao_admin = 'Bạn không có quyền truy cập!';
}
// Truy vấn để lấy danh sách bài viết
$sql = "SELECT b.id, b.tieude, b.top_baiviet, b.new,b.avta, b.noidung, b.time, a.username, p.gender, p.name
    FROM baiviet_hoangvietdung AS b
    INNER JOIN account AS a ON b.account_id = a.id
    LEFT JOIN player AS p ON p.account_id = a.id";
$result = $config->query($sql);
$rows = array();
$topPosts = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;

        if ($row['top_baiviet'] == 1) {
            $topPosts[] = $row;
        }
    }
}
// Sắp xếp mảng $rows theo trường 'time' giảm dần
usort($rows, function($a, $b) {
    return strtotime($b['time']) - strtotime($a['time']);
});
// Lấy giá trị trang hiện tại từ URL
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;

// Số bài viết hiển thị trên mỗi trang
$postsPerPage = 10;

// Tính toán giá trị startIndex và endIndex
$totalPosts = count($rows);
$totalPages = ceil($totalPosts / $postsPerPage);

$startIndex = ($currentpage - 1) * $postsPerPage;
$endIndex = $startIndex + $postsPerPage;

// Giới hạn giá trị startIndex và endIndex
$startIndex = max(0, $startIndex);
$endIndex = min($totalPosts, $endIndex);

// Lấy dữ liệu bài viết phù hợp với trang hiện tại
$displayedPosts = array_slice($rows, $startIndex, $endIndex - $startIndex);

$endIndex = $startIndex + $postsPerPage;
if (isset($_GET['id']) && !empty($rows)) {
    $id = $_GET['id'];

    foreach ($rows as $row) {
        if ($row['id'] == $id) {
?>
<main>
<div class="p-1 mt-1 alert alert-danger" style="background-color:#ffe8d1;border-radius: 7px; box-shadow: 0px 0px 5px black;">
<div class="alert alert-danger" style="background-color:#ffe8d1;border-radius: 7px;border: none">
    <div class="col">
        <table cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
            <tbody>
                <tr>

                    <script>
                    // Kiểm tra biến $thongbao, nếu nó không rỗng, hiển thị SweetAlert2
                    var thongbao_admin = '<?=$thongbao_admin;?>';
                    if (thongbao_admin !== '') {
                        Swal.fire({
                        title: 'Lỗi',
                        html: thongbao_admin,
                        icon: 'error',
                        confirmButtonText: 'Đóng'
                        });
                    }
                    </script>

                    <td width="60px;" style="vertical-align: top">
                        <div class="text-center" style="margin-left: -10px;">
                        <?php if ($row['top_baiviet'] == 1){ ?>
                                <?php if ($row['avta'] == 1) { ?>
                                <img src="../public/images/logo/a1.png"width="60"  style="margin-left: 10px;" >
                                <?php }else if ($row['avta'] == 2) {?>               
                                <img src="../public/images/logo/a2.png"width="45"  style="margin-left: 10px;" >
                                <?php }else if ($row['avta'] == 3) {?>               
                                <img src="../public/images/logo/a3.png"width="45"  style="margin-left: 10px;" >
                                <?php }else if ($row['avta'] == 4) {?>               
                                <img src="../public/images/logo/a4.png"width="45"  style="margin-left: 10px;" >    
                                <?php }else if ($row['avta'] == 5) {?>               
                                <img src="../public/images/logo/a5.png"width="45"  style="margin-left: 10px;" >
                                <?php }else if ($row['avta'] == 6) {?>               
                                <img src="../public/images/logo/a6.png"width="45"  style="margin-left: 10px;" >
                                <?php }else if ($row['avta'] == 7) {?>               
                                <img src="../public/images/logo/a7.png"width="45"  style="margin-left: 10px;" >
                                <?php }else if ($row['avta'] == 8) {?>               
                                <img src="../public/images/logo/a8.png"width="45"  style="margin-left: 10px;" >
                                <?php }else if ($row['avta'] == 9) {?>               
                                <img src="../public/images/logo/a9.png"width="45"  style="margin-left: 10px;" >
                                <?php }else if ($row['avta'] == 10) {?>               
                                <img src="../public/images/logo/a10.png"width="45"  style="margin-left: 10px;" >
                            <?php } ?>
                            <div style="font-size: 12px; padding-top: 5px">
                                <b style="color: red;"><?=$row['name'];?></b>
                                <br>
                                <b style="color: red;"></b>
                            </div>
                        <?php } else { ?>
                        <?php if(!$row['gender']){ ?>
                        <img src="../public/images/icon/3.png" width="50" /><br>
                        <?php } else { ?>  
                        <img src="../public/images/icon/<?=$row['gender'];?>.png" width="50" /><br>
                        <?php } ?>
                            <div style="font-size: 12px; padding-top: 5px">
                                <b class="text-dark"><?=$row['name'];?></b>
                                <br>
                                <b style="color: red;"></b>
                            </div>
                        <?php } ?>
                        </div>
                    </td>

                    <td class="bg bg-light" style="border-radius: 7px;">
                        <div class="row" style="font-size: 9px; padding: 5px 7px;">
                            <div class="col">
                                <span><?=$row['time'];?></span>
                            </div>
                            <div class="col text-right">
                              <?php if($row_admin['id'] == 1){ ?>
                                <span><b>[<a href="?id=<?=$id_delete; ?>&delete=1">Xoá Bài Viết</a>]</b></span>
                              <?php } ?>
                            </div>
                        </div>
                        <div class="row" style="padding: 0 7px 15px 7px">
                            <div class="col">
                            <?php if ($row['top_baiviet'] == 1){ ?>
                            <span><a style="color:orange" class="alert-link text-decoration-none"><?=$row['tieude'];?><a></span>
                            <?php } else { ?>
                            <span><a style="color:blue" class="alert-link text-decoration-none"><?=$row['tieude'];?><a></span>
                            <?php } ?>
                                <br>
                                <span><?=$row['noidung'];?></span>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>



        
</div>
<div class="alert alert-danger" style="background-color:#ffe8d1;border-radius: 7px;border:none;">
<?php
$cmtSql = "SELECT c.noidung AS cmt_noidung, c.time AS cmt_time, a.username, p.gender, p.name
            FROM cmt_hoangvietdung AS c
            INNER JOIN account AS a ON c.khach_id = a.id
            INNER JOIN player AS p ON p.account_id = a.id
            WHERE c.baiviet_id = $id";

$cmtResult = $config->query($cmtSql);

if ($cmtResult->num_rows > 0) {
    while ($cmtRow = $cmtResult->fetch_assoc()) {
        ?>
        <table cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
            <tbody>
                <tr>
                    <td width="60px;" style="vertical-align: top">
                        <div class="text-center" style="margin-left: -10px;">
                            <img src="../public/images/icon/<?=$cmtRow['gender'];?>.png" width="50" /><br>
                            <div style="font-size: 12px; padding-top: 5px">
                                <b><?=$cmtRow['name'];?></b>
                            </div>
                        </div>
                    </td>
                    <td class="bg bg-white" style="border-radius: 7px;">
                        <div class="row" style="font-size: 9px; padding: 5px 7px;">
                            <div class="col">
                                <span><?=$cmtRow['cmt_time'];?></span>
                            </div>
                            <div class="col text-right">
                                <span>Marcus Player Comment</span>
                            </div>
                        </div>
                        <div class="row" style="padding: 0 7px 15px 7px">
                            <div class="col">
                                <span><?=$cmtRow['cmt_noidung'];?></span>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <?php
    }
}
?>
</div>

<?php if ($_SESSION['logger']['name']) { ?>             
<div class="col" style="padding:20px;">
<table cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
<tbody>
<tr>
<td width="60px;" style="vertical-align: top;">
    <div class="text-center" style="margin-left: -10px; height:35px;">
    <?php if(!$row_gender['gender']){ ?>
    <img src="../public/images/icon/3.png" width="50" /><br>
    <?php } else { ?>
    <img src="../public/images/icon/<?=$row_gender["gender"];?>.png" width="50" /><br>
    <?php } ?>
    </div>
</td>

<td style="border-radius: 7px;">

<script>
  // Kiểm tra biến $thongbao, nếu nó không rỗng, hiển thị SweetAlert2
  var thongbao = '<?=$thongbao;?>';
  if (thongbao !== '') {
    Swal.fire({
      title: 'Lỗi',
      html: thongbao,
      icon: 'error',
      confirmButtonText: 'Đóng'
    });
  }
</script>

<form method="POST" action="">
  <div class="row">
  <input type="hidden" id="idbv" name="idbv" value="17">
      <div class="form-group mb-1">
          <textarea class="form-control" name="comment" rows="3" placeholder="Bình luận không vượt quá 75 ký tự" style="border-radius: 7px;" formcontrolname="comment"></textarea>
      </div>
      <div class="mt-1">
          <?php if ($row_active['active'] == 1 && $player_exists) { ?>
          <div class="g-recaptcha" data-sitekey="<?=$site_key;?>"></div>
          <br>
          <button type="submit" name="submit" class="btn btn-action text-black" style="border-radius: 7px;"><i class="fa fa-comment"></i> Bình luận</button>
          <a href="/pages/diendan.php" class="btn btn-action text-black" style="border-radius: 7px;"><i class="fa fa-sign-in"></i> Quay Lại</a>
          <?php } else { ?>
          <span style="color: red; font-size: 12px; font-weight: bold;"><b><i>Hãy tạo nhân vật trước khi <u>bình luận</u>!</i></b></span>
          <?php } ?>
      </div>
  </div>
</form>
</td>
</tr>
</tbody>
</table>
</div>
<?php } ?>
</div>
</main>
<?php } } } else { ?>
    
    <main>
    <div style="background: #ffe8d1; border-radius: 7px; box-shadow: 0px 2px 5px black; padding:20px;" class="pb-1">

       <img src="../public/images/logo/logo1.png" style="display: block; margin-left: auto; margin-right: auto; max-width: 250px;animation: stretch 2s infinite alternate;">
            <?php foreach ($topPosts as $post) : ?>
                <div style="background: #FFAA09; border-radius: 10px;margin-top:5px;padding:5px; box-shadow: 0px 2px 5px black;" class="pb-1">
              
                
                <?php if ($post['avta'] == 1) { ?>
                    <img src="../public/images/logo/a1.png"width="45" height="45" style="margin-left: 10px;" >
                    <?php }else if ($post['avta'] == 2) {?>               
                    <img src="../public/images/logo/a2.png"width="45" height="45" style="margin-left: 10px;" >
                    <?php }else if ($post['avta'] == 3) {?>               
                    <img src="../public/images/logo/a3.png"width="45" height="45" style="margin-left: 10px;" >
                    <?php }else if ($post['avta'] == 4) {?>               
                    <img src="../public/images/logo/a4.png"width="45" height="45" style="margin-left: 10px;" >    
                    <?php }else if ($post['avta'] == 5) {?>               
                    <img src="../public/images/logo/a5.png"width="45" height="45" style="margin-left: 10px;" >
                    <?php }else if ($post['avta'] == 6) {?>               
                    <img src="../public/images/logo/a6.png"width="45" height="45" style="margin-left: 10px;" >
                    <?php }else if ($post['avta'] == 7) {?>               
                    <img src="../public/images/logo/a7.png"width="45" height="45" style="margin-left: 10px;" >
                    <?php }else if ($post['avta'] == 8) {?>               
                    <img src="../public/images/logo/a8.png"width="45" height="45" style="margin-left: 10px;" >
                    <?php }else if ($post['avta'] == 9) {?>               
                    <img src="../public/images/logo/a9.png"width="45" height="45" style="margin-left: 10px;" >
                    <?php }else if ($post['avta'] == 10) {?>               
                    <img src="../public/images/logo/a10.png"width="45" height="45" style="margin-left: 10px;" >
                <?php } ?>
                
                <span style="padding:auto;margin-left: 10px;"><a href="?id=<?= $post['id']; ?>" style="color:#FF0000;font-size:15px;" class="alert-link text-decoration-none blinking-link"><?= $post['tieude']; ?></a></span>
                
                <?php if ($post['new'] == 1) { ?>
                    <img src="../public/images/logo/new.gif"width="30">
                <?php }else if ($post['new'] == 2) {?>               
                    <img src="../public/images/logo/hot.gif"width="30">
                <?php }else if ($post['new'] == 3) {?>               
                    <img src="../public/images/logo/danger.gif"width="30">
                <?php } ?>
                </div>
            <?php endforeach; ?>
       
        <br>
        
        <?php foreach ($displayedPosts as $row) : ?>
            <?php if ($row['top_baiviet'] == 0) { ?>
                <div style="width:45px;float:left;margin-right: 3px;"><img style=" margin-left: 10px;max-width:100%;max-height:100%;" src="../public/images/icon/<?= $row['gender']; ?>.png" /></div>
                <span style="margin-left: 10px;"><a href="?id=<?= $row['id']; ?>" class="alert-link text-decoration-none"><?= $row['tieude']; ?></a></span><br><small style="margin-left: 10px;">bởi <b><?= $row['name']; ?></b></small>
                <hr id="custom-hr">
            <?php } ?>
        <?php endforeach; ?>

        <div class="d-flex justify-content-between">
            <?php if ($_SESSION['logger']['username'] && $player_exists) { ?>
                <div>
                <a href="/pages/dangbai_diendan.php" class="btn btn-action text-black" style="border-radius: 7px;" routerlink="post">Đăng bài</a>
            </div>
                <?php } ?>
                <?php if ($totalPages > 1) { ?>
              <ul class="pagination">
        <?php if ($currentpage > 1) { ?>
          <a class="btn btn-action text-black" href="?page=<?php echo ($currentpage - 1); ?>" aria-label="Previous" style="border-radius: 15px 0px 0px 15px; pointer-events: none;"><span aria-hidden="true">«</span></a>
        <?php } ?>

        <?php
        $numAdjacent = 2; // Số trang số trung gian hiển thị xung quanh trang hiện tại

        $startPage = max(1, $currentpage - $numAdjacent);
        $endPage = min($totalPages, $currentpage + $numAdjacent);

        if ($startPage > 1) {
            // Hiển thị trang đầu tiên và dấu "..."
            ?>
            <li class=""><a href="?page=1" class="btn btn-action text-black">1</a></li>
            <?php if ($startPage > 2) { ?>
                <li class="disabled"><a class="btn btn-action text-black">...</a></li>
            <?php }
        }

        for ($page = $startPage; $page <= $endPage; $page++) {
            ?>
            <li class=""><a href="?page=<?php echo $page; ?>" class="btn btn-<?php echo ($page == $currentpage) ? 'warning' : 'action'; ?> text-black"><?php echo $page; ?></a></li>
            <?php
        }

        if ($endPage < $totalPages) {
            // Hiển thị dấu "..." và trang cuối cùng
            if ($endPage < ($totalPages - 1)) {
                ?>
                <li class="disabled"><a class="btn btn-action text-black">...</a></li>
            <?php } ?>
            <li class=""><a href="?page=<?php echo $totalPages; ?>" class="btn btn-action text-black"><?php echo $totalPages; ?></a></li>
        <?php }

        if ($currentpage < $totalPages) { ?>
            <a class="btn btn-action text-black" href="?page=<?php echo ($currentpage + 1); ?>" aria-label="Next" style="border-radius: 0px 15px 15px 0px; "><span aria-hidden="true">»</span></a>
        <?php } ?>
    </ul>
<?php } ?>

            </div>
    </div>
</main>

<?php } ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#Noti_Home').modal('show');
    })
</script>

<?php require_once('../core/end.php'); ?>