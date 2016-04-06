<!-- Favicon and touch icons -->
<link rel="icon" type="image/x-icon"
    href="<?php echo \Yii::$app->homeUrl;?>images/ico/favicon.png"  />
<link rel="shortcut icon" type="image/x-icon"
    href="<?php echo \Yii::$app->homeUrl;?>images/ico/favicon-32.png"  />
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
		<td><?php echo ": ". date("d-m-Y"); ?></td>
	</tr>
	<tr>
		<td>Shift</td>
		<td><?php echo ": ". Shift::getShift(date("H:i:s"))->shift_name; ?>
	</tr>
	<tr>
		<td>Duty Manager</td>
		<td>
			<?php 
				$dm_now = Schedule::getDmNow(); 
				if(isset($dm_now))
					echo ": ". Support::getName($dm_now->support_id);
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
		<td style="text-align:center;"><br><br><br><br>
			<?php 
	    		$dm_next = Schedule::getDmNext(); 
	    		if(isset($dm_next))
					echo "(" . Support::getName($dm_next->support_id) . ")"; 
				else
					echo "(.......................)";
			?> 
		</td>
		<td style="text-align:center;"><br><br><br><br>
			<?php 
	    		$dm_now = Schedule::getDmNow(); 
				if(isset($dm_now))
					echo "(". Support::getName($dm_now->support_id) . ")";
				else
					echo "(.......................)";
			?> 
		</td>
	</tr>
	
</table>