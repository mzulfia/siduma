<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Modal;
use app\models\PicArea;
use app\models\PlnPic;
use app\models\Management;

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


$this->title = 'SIDUMA | Contact Info';
$this->params['breadcrumbs'][] = 'Contact Info';

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
<div class="site-contact">
    <div class="body-content">
        <div class="row">
          <div class="col-lg-12">
              <div class="box box-info">
                <div class="box-header" style="text-align: center">
                    <h3 class="box-title"><b>SIDUMA | CONTACT INFO</b></h3>
                </div>
              </div> 
          </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
              <div class="box box-info">
                    <div class="box-header with-border">
                      <h3 class="box-title"><b>Management</b></h3>
                      <!-- <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div> -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <ul class="users-list clearfix">
                        <?php
                            if(isset($management)){
                               foreach($management as $member){
                                  echo'
                                  <li style="width: 20%">
                                    <img src="' . Yii::$app->homeUrl . Management::getProfilePicture($member->management_id) . '" class="img-circle-team" alt="Management Image">
                                    <a class="popupModal users-list-name" href="'. Url::to(['management/view/', 'id'=>$member->management_id]) . '">' . $member->mgt_name . '</a>
                                    <span class="users-list-date">' . $member->no_hp . '</span>
                                    <span class="users-list-date">' . $member->position . '</span>
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
                      <h3 class="box-title"><b>PLN PIC</b></h3>
                      <!-- <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div> -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <ul class="users-list clearfix">
                        <?php
                            if(isset($plnpic)){
                               foreach($plnpic as $member){
                                  echo'
                                  <li style="width: 14.28%">
                                    <img src="' . Yii::$app->homeUrl . PlnPic::getProfilePicture($member->pln_pic_id) . '" class="img-circle-team" alt="PIC Image">
                                    <a class="popupModal users-list-name" href="'. Url::to(['pln-pic/view/', 'id'=>$member->pln_pic_id]) . '">' . $member->pic_name . '</a>
                                    <span class="users-list-date">' . $member->no_hp . '</span>
                                    <span class="users-list-date">' . PicArea::getServiceInCharge($member->pln_pic_id) . '</span>
                                  </li>';
                              }
                            }  
                        ?>
                        </ul><!-- /.users-list -->
                    </div><!-- /.box-body -->
                  </div><!--/.box -->
            </div>  
        </div>  
    </div>
</div>    
