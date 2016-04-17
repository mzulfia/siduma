<?php
 use miloschuman\highcharts\Highcharts;
 use kartik\form\ActiveForm;
 use kartik\daterange\DateRangePicker;
 use yii\helpers\Html;
 use yii\helpers\Url;
 use yii\helpers\ArrayHelper;
 use yii\widgets\Pjax;
 use yii\bootstrap\Modal;
 use app\models\ServiceFamily;
 use app\models\Schedule;
 use app\models\Shift;
 use app\models\SupportArea;
 use app\models\DmReport;
 use app\models\SupportReport;
 use app\models\Support;
 use app\models\SupportPosition;


/* @var $this yii\web\View */

$this->title = 'SIDUMA | Dashboard';

$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
    e.preventDefault();
    $('#modal-profile').modal('show').find('#modalContent')
    .load($(this).attr('href'));
    e.preventDefault();
   });
});");

$this->registerJs("$(function() {
   $('.modalPopup').click(function(e) {
    e.preventDefault();
    $('#modal-report').modal('show').find('#modalContent')
    .load($(this).attr('href'));
    e.preventDefault();
   });
});");

$this->registerJs("$(function() {
      $('#modal-profile').on('hidden.bs.modal', function (e) {
           $(this).find('#modalContent').val('').end();
      });
  });");

$this->registerJs("$(function() {
      $('#modal-report').on('hidden.bs.modal', function (e) {
           $(this).find('#modalContent').val('').end();
      });
  });");

header("Refresh:60; url=". Url::to(['site/index']) ."");
?>
<?php
        Modal::begin([
            'header' => '<h4>Profile</h4>',
            'id' => 'modal-profile',
            'size' => 'modal-lg'
        ]);

        echo "<div id='modalContent'>

        </div>";

        Modal::end(); 

        Modal::begin([
            'header' => '<h4>Report</h4>',
          'id' => 'modal-report',
            'size' => 'modal-lg'
        ]);

        echo "<div id='modalContent'>

        </div>";

        Modal::end(); 
?>

<div class="site-index">
  <div class="body-content">
    <div class="row">
      <div class="col-lg-12">
          <div class="box box-info">
            <div class="box-header" style="text-align: center">
                <h3 class="box-title"><b>SIDUMA | DASHBOARD</b></h3>
            </div>
          </div> 
      </div>
    </div>
    <div class="row">
      <?php 
        $max = sizeof(ServiceFamily::find()->all());
        $size = 100/($max);
        $last_updated  = '';
        for($i=1; $i <= sizeof(ServiceFamily::find()->all()); $i++){
          $array = DmReport::getServiceDmReport($i);
          if(isset($array)){
              if($array->status == 2){
                 echo '
                 <a class="modalPopup" href="'. Url::to(['dm-report/view/', 'id'=>$array->dm_report_id]) . '">
                  <div class="col-lg-1 col-xs-3" style="width: '. $size.'%">
                      <div class="small-box bg-green">
                          <div class="inner">
                            <p><b>' .  explode(" ", $array->service->service_name)[0]  . '</b></p>
                          </div>
                      </div>    
                 </div>
                </a>' ;

               } elseif($array->status == 1){
                 echo '
                   <a class="modalPopup" href="'. Url::to(['dm-report/view/', 'id'=>$array->dm_report_id]) . '">
                     <div class="col-lg-1 col-xs-3" style="width: '. $size.'%">
                        <div class="small-box bg-yellow">
                          <div class="inner">
                            <p><b>' .  explode(" ", $array->service->service_name)[0]  . '</b></p>
                         </div>
                        </div>
                     </div>
                  </a>';
               } else{
                echo '
                  <a class="modalPopup" href="'. Url::to(['dm-report/view/', 'id'=>$array->dm_report_id]) . '">
                   <div class="col-lg-1 col-xs-3" style="width: '. $size.'%">
                      <div class="small-box bg-red">
                        <div class="inner">
                          <p><b>' .  explode(" ", $array->service->service_name)[0]  . '</b></p>
                        </div>
                      </div>
                   </div>
                  </a>';
            }
         }
      }
    ?>
    </div>

    <div class="col-md-12">
        <?php 
            if(!empty(DmReport::getLastUpdated())){
                $last_updated = DmReport::getLastUpdated()->created_at;
                echo '<p style="text-align: right; padding-right: 15px;margin-right: -30px !important;"><i> last updated: '. $last_updated . '</i></p>';  
            }
        ?>
    </div>

    <div class="row">     
      <div class="col-lg-6">
        <div class="box box-info">
          <div class="box-header">
              <h3 class="box-title"><b>Duty Manager Now - 085715581553 (Command Center)</b></h3>
          </div>
        </div> 

        <div class="col-lg-5">
            <div class="profile-picture">
              <?php $dm = Schedule::getDmNow();?>
              <?php if(isset($dm)){ ?>
                  <?= Html::img(Yii::$app->homeUrl . Support::getProfilePicture($dm->support_id), ['class' => 'img-circle', 'alt' => 'Support Image']);?>
              <?php } ?>   
            </div>
        </div>
        <div class="col-lg-7">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title"><b>Profile</b></h3>
                <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
              </div>
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody>
                      <?php
                          if(isset($dm)){
                              $service_family = Support::getServiceInCharge($dm->support_id);
                              date_default_timezone_set("Asia/Jakarta");
                              $shift_name = Shift::getShift(date('H:i:s'))->shift_name;
                              $shift_start = Shift::getShift(date('H:i:s'))->shift_start;
                              $shift_end = Shift::getShift(date('H:i:s'))->shift_end;
                              $shift_fix = $shift_name . ", " . $shift_start . " s.d. " . $shift_end;
                              $name = $dm->support->support_name;
                              $email = $dm->support->email;
                              $no_hp = $dm->support->no_hp;
                              $position = $dm->support->pos->position_name;
                              echo '
                                  <tr>
                                      <td>Name</td>
                                      <td><a class="popupModal users-list-name" href="'. Url::to(['support/view/', 'id'=>$dm->support_id]) . '">' . $name . '</a></td>
                                  </tr>
                                  <tr>    
                                      <td>Email</td>
                                      <td>' . $email . '</td>
                                  </tr>
                                  <tr>    
                                      <td>No HP</td>
                                      <td>' . $no_hp . '</td>
                                  </tr>
                                  <tr>    
                                      <td>Shift</td>
                                      <td>' . $shift_fix .  '</td>
                                  </tr>
                                  <tr>    
                                      <td>Position</td>
                                      <td>' . $position . '</td>
                                  </tr>
                                  <tr>    
                                      <td>Service Family</td>
                                      <td>' . $service_family . '</td>
                                  </tr>';
                          }    
                      ?>
                      </tbody>
                  </table>
              </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
      </div>
      <div class="col-lg-6">
          <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title"><b><?php echo ServiceFamily::getServiceOthers(); ?></b></h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body no-padding">
                    <ul class="users-list clearfix">

            <?php
                $arrays_team = SupportArea::getTeamOthersNow();
                if(!empty($arrays_team)){
                  foreach ($arrays_team as $array_team) {
                    echo'
                      <li style="width: 16.66%">
                        <img src="' . Yii::$app->homeUrl . Support::getProfilePicture($array_team['support_id']) . '" class="img-circle-team" alt="User Image">
                        <a class="popupModal users-list-name" href="'. Url::to(['support/view/', 'id'=>$array_team['support_id']]) . '">' . $array_team['support_name'] . '</a>
                        <span class="users-list-date">' . $array_team['no_hp'] . '</span>
                        <span class="users-list-date">' . SupportArea::getServiceInCharge($array_team['support_id']) . '</span>
                      </li>';
                  }
                }
            ?>
                    </ul><!-- /.users-list -->
                  </div><!-- /.box-body -->
        </div><!--/.box -->
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><b><?php echo ServiceFamily::getServiceIcon(); ?></b></h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <ul class="users-list clearfix">
                <?php
                    $arrays_team = SupportArea::getTeamIconNow();
                    $size_iconbox = 0;
                    if(sizeof($arrays_team) > 0)
                      $size_iconbox = 100/sizeof($arrays_team);
                    if(isset($arrays_team)){
                       foreach($arrays_team as $array_team){
                          echo'
                          <li style="width: '. $size_iconbox .'%">
                            <img src="' . Yii::$app->homeUrl . Support::getProfilePicture($array_team['support_id']) . '" class="img-circle-team" alt="User Image">
                            <a class="popupModal users-list-name" href="'. Url::to(['support/view/', 'id'=>$array_team['support_id']]) . '">' . $array_team['support_name'] . '</a>
                            <span class="users-list-date">' . $array_team['no_hp'] . '</span>
                            <span class="users-list-date">' . SupportPosition::getPosition($array_team['support_position_id']) . '</span>
                          </li>';
                      }
                    }  
                ?>
                </ul><!-- /.users-list -->
            </div><!-- /.box-body -->
          </div><!--/.box -->
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <?php 
            $services = ServiceFamily::find()->all();
            $text = '';
            foreach ($services as $service) {
                $text .= $service->service_name . ': ';
                $array = DmReport::getServiceDmReport($service->service_family_id);
                if(!empty($array)){
                  $text .= $array->information . " | ";
                } else {
                  $text .= "Aman | ";
                }
            }
            echo '
            <div style="position: relative;bottom:20px;left:0;right:0;width:100%;">
              <span style="font-family: Source Sans Pro; font-size: 20px; font-weight:bold; color: white;" >
                  <marquee direction="left" scrollamount="5" width="100%" bgcolor="#3c8dbc" >
                    '. $text .'
                  </marquee>
              </span>
            </div>';
        ?>
      </div>
    </div>
  </div>
</div>
