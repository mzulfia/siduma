<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

// use app\models\Pic;
use app\models\Schedule;
use app\models\Support;
use app\models\SupportArea;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Active Support on ' . $date;
$this->params['breadcrumbs'][] = ['label' => 'Schedules', 'url' => ['viewcalendar']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php  

$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
    e.preventDefault();
    $('#modal-profile').modal('show').find('#modalContent')
    .load($(this).attr('href'));
    e.preventDefault();
   });
});");

$this->registerJs("$(function() {
      $('#modal-profile').on('hidden.bs.modal', function (e) {
           $(this).find('#modalContent').val('').end();
      });
  });");


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
?>

<?php
    foreach($morning_dm as $item){
         echo
         '<div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><b>Duty Manager Pagi</b></h3>
                </div>
                <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                      <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Service Family</th>
                      </tr>
                            <tr>
                              <td><img src="' . Yii::$app->homeUrl . Support::getProfilePicture($item->support_id) . '" class="img-box" alt="User Image"></td>
                              <td><a class="popupModal users-list-name" href="'. Url::to(['support/view/', 'id'=>$item->support_id]) . '">' . $item->support->support_name . '</a></td>
                              <td>' . $item->support->email . '</td>
                              <td>' . $item->support->no_hp . '</td>
                              <td>' . SupportArea::getServiceInCharge($item->support_id) . '</td>
                            </tr>
                    </tbody>
                </table>
                </div><!-- /.box-body -->
            </div>
            <br>
            
            ';  
        }
    
    echo
    '<div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Team</b></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody>
              <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Service Family</th>
              </tr>';
    
    foreach($morning_team as $item){
        echo 
        '<tr>
          <td><img src="' . Yii::$app->homeUrl . Support::getProfilePicture($item->support_id) . '" class="img-box" alt="User Image"></td>
          <td><a class="popupModal users-list-name" href="'. Url::to(['support/view/', 'id'=>$item->support_id]) . '">' . $item->support->support_name . '</a></td>
          <td>' . $item->support->email . '</td>
          <td>' . $item->support->no_hp . '</td>
          <td>' . SupportArea::getServiceInCharge($item->support_id) . '</td>
        </tr>';
    }   

     echo '
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div>';  

    foreach($afternoon_dm as $item){
         echo
         '<div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><b>Duty Manager Sore</b></h3>
                </div>
                <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                      <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Service Family</th>
                      </tr>
                            <tr>
                              <td><img src="' . Yii::$app->homeUrl . Support::getProfilePicture($item->support_id) . '" class="img-box" alt="User Image"></td>
                              <td><a class="popupModal users-list-name" href="'. Url::to(['support/view/', 'id'=>$item->support_id]) . '">' . $item->support->support_name . '</a></td>
                              <td>' . $item->support->email . '</td>
                              <td>' . $item->support->no_hp . '</td>
                              <td>' . SupportArea::getServiceInCharge($item->support_id) . '</td>
                            </tr>
                    </tbody>
                </table>
                </div><!-- /.box-body -->
            </div>
            <br>
            
            ';  
        }
    echo
    '<div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Team</b></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody>
              <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Service Family</th>
              </tr>';
    
    foreach($afternoon_team as $item){
        echo 
        '<tr>
          <td><img src="' . Yii::$app->homeUrl . Support::getProfilePicture($item->support_id) . '" class="img-box" alt="User Image"></td>
          <td><a class="popupModal users-list-name" href="'. Url::to(['support/view/', 'id'=>$item->support_id]) . '">' . $item->support->support_name . '</a></td>
          <td>' . $item->support->email . '</td>
          <td>' . $item->support->no_hp . '</td>
          <td>' . SupportArea::getServiceInCharge($item->support_id) . '</td>
        </tr>';
    }   

     echo '
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div>';  

    foreach($evening_dm as $item){
         echo
         '<div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><b>Duty Manager Malam</b></h3>
                </div>
                <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                      <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Service Family</th>
                      </tr>
                            <tr>
                              <td><img src="' . Yii::$app->homeUrl . Support::getProfilePicture($item->support_id) . '" class="img-box" alt="User Image"></td>
                              <td><a class="popupModal users-list-name" href="'. Url::to(['support/view/', 'id'=>$item->support_id]) . '">' . $item->support->support_name . '</a></td>
                              <td>' . $item->support->email . '</td>
                              <td>' . $item->support->no_hp . '</td>
                              <td>' . SupportArea::getServiceInCharge($item->support_id) . '</td>
                            </tr>
                    </tbody>
                </table>
                </div><!-- /.box-body -->
            </div>
            <br>
            
            ';  
        }
    
    echo
    '<div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Team</b></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody>
              <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Service Family</th>
              </tr>';
    
    foreach($evening_team as $item){
        echo 
        '<tr>
          <td><img src="' . Yii::$app->homeUrl . Support::getProfilePicture($item->support_id) . '" class="img-box" alt="User Image"></td>
          <td><a class="popupModal users-list-name" href="'. Url::to(['support/view/', 'id'=>$item->support_id]) . '">' . $item->support->support_name . '</a></td>
          <td>' . $item->support->email . '</td>
          <td>' . $item->support->no_hp . '</td>
          <td>' . SupportArea::getServiceInCharge($item->support_id) . '</td>
        </tr>';
    }   

     echo '
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div>';  

   