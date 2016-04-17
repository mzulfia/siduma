<?php
	use app\models\Shift;
	use app\models\Schedule;
	use app\models\Support;
	use app\models\ServiceFamily;
	use app\models\DmReport;
?>

<br>
<div class="row" style = 'text-align: center;'><h3 align = "center"><b> LAPORAN MONITORING OPERASIONAL LAYANAN IT <b></h3></div>

<br>
<br>
<table border="0">
	<tr>
		<td>Tanggal</td>
		<td><?php 
			if(!empty(DmReport::getLastUpdated()))
				echo ": ". date("d-F-Y", strtotime(explode(" ", DmReport::getLastUpdated()->created_at)[0])); ?></td>
	</tr>
	<tr>
		<td>Shift</td>
		<td><?php 
			if(!empty(DmReport::getLastUpdated()))
				echo ": ". Shift::getShift(explode(" ", DmReport::getLastUpdated()->created_at)[1])->shift_name; ?></td>
	</tr>
	<tr>
		<td>Duty Manager</td>
		<td>
			<?php 
				if(!empty(DmReport::getLastUpdated()))
					echo ": ". Support::getName(DmReport::getLastUpdated()->support_id);
				else
					echo ": "; 
			?>
		</td>	
	</tr>
</table>

<br>
<table border="1" style="width:100%; border-spacing: 0; border-collapse: collapse;">
	<tr>
		<th style="text-align:center;">NO</th>
		<th style="text-align:center;">LAYANAN</th>
		<th style="text-align:center;">STATUS</th>
		<th style="text-align:center;">KETERANGAN</th>
	</tr>	
	<?php
		for($i=1; $i <= sizeof(ServiceFamily::find()->all()); $i++){
          $array = DmReport::getServiceDmReport($i);
          $status = "";
          if($array->status == "2"){
          	$status = "Normal";
          } elseif($array->status == "1"){
          	$status = "Warning";
          } else{
          	$status = "Critical";
          }

          echo 
          	"<tr>
          		<td style='text-align:center;'>". $i ."</td>
          		<td style='text-align:center;'>". $array->service->service_name ."</td>
          		<td style='text-align:center;'>". $status ."</td>
          		<td>". $array->information ."</td>
          	 </tr>	
          ";
        }
    ?>    
</table>

<br>
<br>
<table border="0" style="width:100%; margin-top: 20px;">
	<tr>
		<td style="text-align:center;">Mengetahui,</td>
		<td style="text-align:center;">Yang Membuat Laporan,</td>
	</tr>
	<tr>
		<td style="text-align:center;"><br><br><br><br><br>
			<?php 
				if(!empty(DmReport::getLastUpdated())){
					if(!empty(Schedule::getDmNext(explode(" ", DmReport::getLastUpdated()->created_at)[0], explode(" ", DmReport::getLastUpdated()->created_at)[1]))){
						$dm_next = Schedule::getDmNext(explode(" ", DmReport::getLastUpdated()->created_at)[0], explode(" ", DmReport::getLastUpdated()->created_at)[1]);
						echo "(". Support::getName($dm_next->support_id) . ")";
					} else{
						echo "(..............................)";
					}
				} else{
					echo "(..............................)";
				}
			?> 
		</td>
		<td style="text-align:center;"><br><br><br><br><br>
			<?php 
				if(!empty(DmReport::getLastUpdated()))
					echo "(". Support::getName(DmReport::getLastUpdated()->support_id) .")";
				else
					echo "(..............................)";
			?> 
		</td>
	</tr>
</table>