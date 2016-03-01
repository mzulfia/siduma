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
 use app\models\Support;
 use app\models\Shift;
 use app\models\Report;


/* @var $this yii\web\View */

$this->title = 'SIDUMA';
$this->params['breadcrumbs'][] = 'Dashboard';

$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
    e.preventDefault();
    $('#modal').modal('show').find('#modalContent')
    .load($(this).attr('href'));
    e.preventDefault();
   });
});");

?>


<?php
        Modal::begin([
            'header' => '<h4>Profile</h4>',
            'id' => 'modal',
            'size' => 'modal-lg'
        ]);

        echo "<div id='modalContent'>

        </div>";

        Modal::end(); 
?>


<div class="site-index">
       <div class="col-md-12" style = 'text-align: center; margin-bottom: 20px'> 
        
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-6">
              <?php //var_dump(Report::getServiceReport(1));?>
               <h3 style='text-align: center'><b><span>Service Condition</span></b></h3>
                 <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Latest Report</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div><!-- /.box-header -->
                  <div class="box-body" style="display: block;">
                    <div class="table-responsive">
                      <table class="table no-margin">
                        <thead>
                          <tr>
                            <th>Service Family</th>
                            <th>Status</th>
                            <th>Information</th>
                            <th>Files</th>
                            <th>Duty Manager</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                              for($i=1; $i<= sizeof(ServiceFamily::find()->all()); $i++){
                                $array = Report::getServiceReport($i);
                                if(isset($array)){
                                    $status = '';
                                    $file_path = '';
                                    // var_dump($array->file_path);
                                    if($array->status == 2){
                                        $status = '<span class="label label-success">Normal</span>';
                                     } elseif($array->status == 1){
                                        $status = '<span class="label label-warning">Sufficient</span>';
                                     } else{
                                        $status = '<span class="label label-danger">Bad</span>';
                                     }

                                     if(is_null($array->file_path)){
                                        $file_path = null;
                                     } else{
                                        $file_path = Html::a(Html::encode(explode("/", $array->file_path)[2]), 
                                        Url::toRoute(['report/download', 'file_path' => $array->file_path]), 
                                        [
                                           // 'title'=>'Clave',
                                           // 'data-confirm' => Yii::t('yii', 'Are you sure you want to change this password?'),
                                           'data-method' => 'post',
                                        ]);
                                     }
                                    echo '
                                      <tr>
                                        <td>' . $array->service->service_name . '</td>
                                        <td>' . $status . '</td>
                                        <td>' . $array->information . '</td> 
                                        <td>' . $file_path . '</td> 
                                        <td>' . $array->support->support_name . '</td>
                                      </tr>';
                                    
                                }
                              }  
                          ?>
                        </tbody>
                      </table>
                    </div><!-- /.table-responsive -->
                  </div><!-- /.box-body -->
                 </div> 
               
                <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Recently Added Products</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul class="products-list product-list-in-box">
                    <li class="item">
                      <div class="product-img">
                        <img src="dist/img/default-50x50.gif" alt="Product Image">
                      </div>
                      <div class="product-info">
                        <a href="javascript::;" class="product-title">Samsung TV <span class="label label-warning pull-right">$1800</span></a>
                        <span class="product-description">
                          Samsung 32" 1080p 60Hz LED Smart HDTV.
                        </span>
                      </div>
                    </li><!-- /.item -->
                    <li class="item">
                      <div class="product-img">
                        <img src="dist/img/default-50x50.gif" alt="Product Image">
                      </div>
                      <div class="product-info">
                        <a href="javascript::;" class="product-title">Bicycle <span class="label label-info pull-right">$700</span></a>
                        <span class="product-description">
                          26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                        </span>
                      </div>
                    </li><!-- /.item -->
                    <li class="item">
                      <div class="product-img">
                        <img src="dist/img/default-50x50.gif" alt="Product Image">
                      </div>
                      <div class="product-info">
                        <a href="javascript::;" class="product-title">Xbox One <span class="label label-danger pull-right">$350</span></a>
                        <span class="product-description">
                          Xbox One Console Bundle with Halo Master Chief Collection.
                        </span>
                      </div>
                    </li><!-- /.item -->
                    <li class="item">
                      <div class="product-img">
                        <img src="dist/img/default-50x50.gif" alt="Product Image">
                      </div>
                      <div class="product-info">
                        <a href="javascript::;" class="product-title">PlayStation 4 <span class="label label-success pull-right">$399</span></a>
                        <span class="product-description">
                          PlayStation 4 500GB Console (PS4)
                        </span>
                      </div>
                    </li><!-- /.item -->
                  </ul>
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="javascript::;" class="uppercase">View All Products</a>
                </div><!-- /.box-footer -->
              </div>

            </div>
            <div class="col-lg-6">
                <div class="profile-picture">
                    <?php $dm = Schedule::getDmNow();?>
                    <?php if(isset($dm)){ ?>
                        <?= Html::img(Yii::$app->homeUrl . Support::getProfilePicture($dm->support_id), ['class' => 'img-circle', 'alt' => 'Support Image']);?>
                    <?php } ?>   
                </div>

                <h3 style='text-align: center'><b><i class="fa fa-user"></i><span>Duty Manager Now</span></b></h3>
                <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Shift</th>
                        <th>Service Family</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($dm)){
                                $service_family = Support::getServiceInCharge($dm->support_id);
                                date_default_timezone_set("Asia/Jakarta");
                                $shift = Shift::getShift(date('H:i:s'))->shift_name;
                                $name = $dm->support->support_name;
                                $email = $dm->support->email;
                                $no_hp = $dm->support->no_hp;
                                echo '
                                    <tr>
                                        <td>' . $shift . '</td>
                                        <td>' . $service_family . '</td>
                                        <td><a class="popupModal users-list-name" href="'. Url::to(['support/view/', 'id'=>$dm->support_id]) . '">' . $name . '</a></td>
                                        <td>' . $email . '</td>
                                        <td>' . $no_hp . '</td>
                                    </tr>';
                            }    
                        ?>
                        </tbody>
                </table>



                <h3 style='text-align: center'><b><i class="fa fa-users"></i><span>Team</span></b></h3>
                

                <?php 
                    for($i=1; $i<= sizeof(ServiceFamily::find()->all()); $i++){
                    $arrays_team = Schedule::getTeamNow($i);

                    if(isset($arrays_team)){
                ?>
                <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title"> <?php echo ServiceFamily::getServiceName($arrays_team[0]['service_family_id'])?> </h3>
                      <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <ul class="users-list clearfix">
                        <?php 
                            foreach($arrays_team as $array_team){
                                echo'
                                <li>
                                  <img src="' . Yii::$app->homeUrl . Support::getProfilePicture($array_team['support_id']) . '" class="img-circle-team" alt="User Image">
                                  <a class="popupModal users-list-name" href="'. Url::to(['support/view/', 'id'=>$array_team['support_id']]) . '">' . $array_team['support_name'] . '</a>
                                  <span class="users-list-date">' . $array_team['email'] . '</span>
                                  <span class="users-list-date">' . $array_team['no_hp'] . '</span>
                                </li>';

                            }
                        ?>
                     </ul><!-- /.users-list -->
                   </div><!-- /.box-body -->
                </div><!--/.box -->
                <?php 
                    }
                  } 
                ?>
            </div>
        </div>
    </div>
</div>
