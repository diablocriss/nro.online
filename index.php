<?php 
  require_once('core/config.php'); 
  require_once('core/head.php'); 
?>
      <main>
        <div class="p-1 mt-1 ibox-content" style="background-color: rgba(57,57,57, 0.7); border-radius: 7px; box-shadow: 0px 2px 5px black;">
        
          <div class="p-1 text-white">
            <h5 class="h3 mb-3 font-weight-normal text-white" style="text-align:center;padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Top Nạp</h5>
              
			  <div class="p-1 mt-1 ibox-content" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
				  <main>
					
					<div class="table-responsive">
					  <div style="line-height: 15px;font-size: 12px;padding-right: 5px;margin-bottom: 8px;padding-top: 2px;" class="text-center">
					  </div>
					  <table class="table table-hover table-custom  " style="text-align: center;">
					  <thead >
									<tr>
										<th>TOP</th>
										<th>Tên</th>
										<th>Tổng nạp</th>
									</tr>
								</thead>  
					  <tbody>
						  <?php
							$query = "SELECT player.*
										FROM player
										INNER JOIN account ON account.id = player.account_id
										WHERE account.is_admin = 0 AND account.ban = 0 AND player.vnd > 0
										ORDER BY player.vnd DESC
										LIMIT 3";
							$result = $config->query($query);
							$stt = 1;
							if ($result === false) {
							  echo 'Lỗi truy vấn SQL: '.$config->error;
							} elseif ($result->num_rows > 0) {
							  while ($row = $result->fetch_assoc()) {
							   echo '<tr>
									  <td>'.$stt.'</td>
									  <td>'.$row['name'].'</td>
									  <td>'.number_format($row['vnd']).'<sup>đ</sup></td>
									</tr>';
									
								$stt++;
							  }
							} else {
							  echo ' <tr>
									  <td colspan="3" align="center"><span style="font-size:100%;"><< Lịch Sử Trống >></span></td>
									</tr>';
							}
						  ?> 
						</tbody>
					  </table>
					</div>
				  </main> 
				</div>
			</div>
		</div>	
				<br>
				<div class="p-1 mt-1 ibox-content" style="background-color: rgba(57,57,57, 0.7); border-radius: 7px; box-shadow: 0px 2px 5px black;">
				<div class="p-1 text-white">
            <h5 class="h3 mb-3 font-weight-normal text-white" style="text-align:center;padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Top Nhiệm Vụ</h5>
           
			  <div class="p-1 mt-1 ibox-content" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
				  <main>
					
					<div class="table-responsive">
					  <div style="line-height: 15px;font-size: 12px;padding-right: 5px;margin-bottom: 8px;padding-top: 2px;" class="text-center">
					  </div>
					  <table class="table table-hover table-custom  " style="text-align: center;">
					  <thead >
									<tr>
										<th>TOP</th>
										<th>Tên</th>
										<th>Nhiệm Vụ</th>
									</tr>
								</thead>  
					  <tbody>
						  <?php
							$query = "SELECT name, gender, CAST( split_str(split_str(data_task,',',1),'[',2)  AS UNSIGNED) AS nv , CAST(split_str(data_task,',',2)  AS UNSIGNED) as nv1 ,CAST(split_str(data_task,',',3)  AS UNSIGNED) as nv2 FROM player INNER JOIN account ON account.id = player.account_id WHERE account.is_admin = 0 AND account.ban = 0
							ORDER BY CAST( split_str(split_str(data_task,',',1),'[',2)  AS UNSIGNED) DESC, CAST(split_str(data_task,',',2)  AS UNSIGNED) DESC, CAST(split_str(data_task,',',3)  AS UNSIGNED) DESC LIMIT 10;";
							$result = $config->query($query);
							$stt = 1;
							if ($result === false) {
							  echo 'Lỗi truy vấn SQL: '.$config->error;
							} elseif ($result->num_rows > 0) {
							  while ($row = $result->fetch_assoc()) {
							   echo '<tr>
									  <td>'.$stt.'</td>
									  <td>'.$row['name'].'</td>
									<td>'.$row['nv'].'</td>
									</tr>';
								$stt++;
							  }
							} else {
							  echo ' <tr>
									  <td colspan="3" align="center"><span style="font-size:100%;"><< Lịch Sử Trống >></span></td>
									</tr>';
							}
						  ?> 
						</tbody>
					  </table>
					</div>
				  </main> 
				</div>
				</div>
				</div> 
<br>
				<div class="p-1 mt-1 ibox-content" style="background-color: rgba(57,57,57, 0.7); border-radius: 7px; box-shadow: 0px 2px 5px black;">
				<div class="p-1 text-white">
            <h5 class="h3 mb-3 font-weight-normal text-white" style="text-align:center;padding-top: 3px; font-weight: bold; text-shadow: 2px 2px 2px #000;">Top Sức Mạnh</h5>
             
			  <div class="p-1 mt-1 ibox-content" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
				  <main>
					
					<div class="table-responsive">
					  <div style="line-height: 15px;font-size: 12px;padding-right: 5px;margin-bottom: 8px;padding-top: 2px;" class="text-center">
					  </div>
					  <table class="table table-hover table-custom  " style="text-align: center;">
					  <thead >
									<tr>
										<th>TOP</th>
										<th>Tên</th>
										<th>Sức Mạnh</th>
									</tr>
								</thead>  
					  <tbody>
						  <?php
							$query = "SELECT name, gender, CAST(split_str(data_point, ',', 2) AS UNSIGNED) AS sm
									FROM player
									INNER JOIN account ON account.id = player.account_id
									WHERE account.is_admin = 0 AND account.ban = 0
									ORDER BY CAST(split_str(data_point, ',', 2) AS UNSIGNED) DESC
									LIMIT 10;";
							$result = $config->query($query);
							$stt = 1;
							if ($result === false) {
							  echo 'Lỗi truy vấn SQL: '.$config->error;
							} elseif ($result->num_rows > 0) {
							  while ($row = $result->fetch_assoc()) {
							   echo '<tr>
									  <td>'.$stt.'</td>
									  <td>'.$row['name'].'</td>
									  <td>'.$row['sm'].'</td>
									</tr>';
								$stt++;
							  }
							} else {
							  echo ' <tr>
									  <td colspan="3" align="center"><span style="font-size:100%;"><< Lịch Sử Trống >></span></td>
									</tr>';
							}
						  ?> 
						</tbody>
					  </table>
					</div>
				  </main> 
				</div>
				
                

      </div>
        </div>
      </main>
      
      <br>

<?php require_once('core/end.php'); ?>


<script type="text/javascript">
    $(document).ready(function() {
        $('#Noti_Home').modal('show');
    })
</script>
<?php require_once('core/end.php'); ?>