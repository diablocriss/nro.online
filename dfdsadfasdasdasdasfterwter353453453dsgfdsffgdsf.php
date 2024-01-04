<?php
session_start();
include('cauhinh.php');
include('config.php');

    if(isset($_POST['tang']))
    {
        $error = array();
        $showMess = false;
        $row= array();

        if(!$error) {

            function validate($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            $checktk = validate($_POST['checktk']);
            $checktk = strtolower($checktk);
            $hongngoc = validate($_POST['hongngoc']);
            $hongngoc = strtolower($hongngoc);


            $check = "SELECT * FROM account WHERE username = '$checktk'";
            $result = mysqli_query($config, $check);
            $row = mysqli_fetch_array($result);
         

            if(mysqli_num_rows($result)==1)
            {   
                $new_vnd_cong = $row['vnd'] + $hongngoc;
                $tang = "UPDATE account SET vnd ='$new_vnd_cong' WHERE username = '$checktk'";
                $result_tang = mysqli_query($config, $tang);
                $hn=$row['vnd']+ $hongngoc;
                header("Location: dfdsadfasdasdasdasfterwter353453453dsgfdsffgdsf.php?error=CỘNG THÀNH CÔNG $hongngoc VNĐ cho tài khoản: $checktk ! Tổng: $hn VNĐ.");
                exit();
            }else 
            {
                header("Location: dfdsadfasdasdasdasfterwter353453453dsgfdsffgdsf.php?error=Tài khoản $checktk không tồn tại !");
                exit();
            }            
        }
    }


    if(isset($_POST['giam']))
    {
        $error = array();
        $showMess = false;
        $row= array();

        if(!$error) {

            function validate($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            $checktk = validate($_POST['checktk']);
            $checktk = strtolower($checktk);
            $hongngoc = validate($_POST['hongngoc']);
            $hongngoc = strtolower($hongngoc);


            $check = "SELECT * FROM account WHERE username = '$checktk'";
            $result = mysqli_query($config, $check);
            $row = mysqli_fetch_array($result);
         

            if(mysqli_num_rows($result)==1)
            {   
                if ($row['vnd']==0 || $hongngoc>$row['vnd'])
                {
                    header("Location: dfdsadfasdasdasdasfterwter353453453dsgfdsffgdsf.php?error=Không còn tiển để trừ");
                }else{

                    $new_vnd_tru = $row['vnd'] - $hongngoc;
                    $giam = "UPDATE account SET vnd ='$new_vnd_tru' WHERE username = '$checktk'";
                    $result_giam = mysqli_query($config, $giam);
                    $hn=$row['vnd']- $hongngoc;
                    header("Location: dfdsadfasdasdasdasfterwter353453453dsgfdsffgdsf.php?error=TRỪ THÀNH CÔNG $hongngoc VNĐ cho tài khoản: $checktk ! Tổng: $hn VNĐ.");
                    exit();
                
                
                }
            }else 
            {
                header("Location:dfdsadfasdasdasdasfterwter353453453dsgfdsffgdsf.php?error=Tài khoản $checktk không tồn tại !");
                exit();            }            
        }
	}


        

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin</title>

	<!---custom css link--->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!---custom icon--->
	<link rel="icon" type="image/png" href="img/iconweb.png"/>
	<!---boxicons link--->
	<link rel="stylesheet"
    href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!---remixicons link--->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!---google fonts link--->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
    
    form {
      background-color: #fff;
      padding: 50px;
      max-width: 600px;
      margin: 0 auto;
      border-radius: 30px;
	  box-shadow: 0 0 5px rgba(0, 0, 0, 1);

    }
    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #000000;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .hero-text button{
	display: inline-block;
	color: white;
	background: rgba(255,154,0,1);
	border: 1px solid transparent;
	padding: 12px 30px;
	line-height: 1.4;
	font-size: 14px;
	font-weight: 500;
	border-radius: 30px;
	text-transform: uppercase;
	transition: all .55s ease;
    }

    label {
      display: block;
      margin-bottom: 10px;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      border-radius: 30px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
      box-sizing: border-box;
	  box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
  		transition: all 0.3s ease;
    }
	input[type="text"]:focus,
	input[type="password"]:focus {
  	transform: translateY(-5px);
 	 box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);		
	}

    .logo_icon {
      width: 150px;
      display: block;
      margin: 0 auto;
      margin-bottom: 20px;
    }
	.button-container {
	  display: flex;
	  justify-content: space-between;
	  align-items: center;
	}

	.red-button {
	  background-color: red;
	  color: white;
	  border: none;
	  padding: 5px 10px;
	  font-size: 1em;
	  border-radius: 3px;
	  cursor: pointer;
	  float: right;
	}
    
	.custom-table {
        border-collapse: collapse;
        width: 100%;
        margin: 0 auto;
        font-family: Arial, sans-serif;
        font-size: 14px;

        }

        .custom-table th,
        .custom-table td {
        padding: 10px;
        text-align: center;
        }

        .custom-table th {
        font-weight: bold;
        }

        .custom-table tbody tr:hover {
        background-color: #f5f5f5;
        }

		table {
			border-collapse: collapse;
			width: 100%;
		}
		th, td {
			text-align: left;
			padding: 8px;
			border: 1px solid #ddd;
		}
		th {
			background-color: #f2f2f2;
		}
	</style>
    </style>

</head>
<body>
	
		<div class="hero-text">
            <form method="POST">
                <input type="hidden" name="_token" value="JEGpj39vMoqzUAPDoHWTY8Y4jJiy4t0mhPST9nds">
                <h2>Admin</h2>
                <div class="mb-3 form-group">
                  <label for="username" class="form-label">Tên tài khoản:</label>
                  <input type="text" class="form-control" name="checktk"  required>
                </div>
                <div class="mb-3 form-group">
                  <label for="username" class="form-label">Số VNĐ:</label>
                  <input type="text" class="form-control" name="hongngoc" required>
                </div>
                <div style="  display: flex;justify-content: center;align-items: center; ">
                    <button type="submit" style="margin-right: 10px; background: green;" class="submit" name="tang">+ VNĐ</button>
                    <button type="submit" style="margin-left: 10px; background: red;" class="submit" name="giam">- VNĐ</button>
                </div>
                <div style="margin-top: 20px; padding:20px">
                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger w-50 p-3 " role="alert">
                        <?php echo $_GET['error']; ?>
                        </div>
                <?php } ?>
                </div>

              </form>
		</div>
		

	</section>


	<!---######################################################--->


	<!---######################################################--->
	<!---scrollreveal effect--->
	<script src="https://unpkg.com/scrollreveal"></script>

	<!---custom js link--->
	<script src="js/script.js"></script>
    


</body>
</html>

<div>