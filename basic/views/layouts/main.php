<?php

/* @var $this \yii\web\View */
/* @var $content string */



use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
// use app\assets\AppAsset;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use app\assets\DashboardAsset;

use app\models\User;
use app\models\Support;
use app\models\Management;
use app\models\Supervisor;
use app\models\Schedule;
use app\models\Shift;

DashboardAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="<?php echo \Yii::$app->homeUrl;?>images/ico/favicon.png">
    <link rel="icon-32" sizes="32x32" href= "<?php echo \Yii::$app->homeUrl;?>images/ico/favicon-32.png">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href= <?php echo Yii::$app->homeUrl;?> class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>DM</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>SIDUMA</b></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
              
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li><a href='#' style="color: white">Login as <b><?php echo User::getRoleName(\Yii::$app->user->getId());?></b>
                <li><?php echo Html::a('Logout (' . Yii::$app->user->identity->username . ')', ['/site/logout'],['data-method'=>'post']);?></li>
            </ul>  
          </div>
        </nav>      
    </header>

      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" style="height: auto">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <?php if(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){ ?>
              <div class="user-panel">
                <div class="pull-left image">
                  <img src="<?php echo Yii::$app->homeUrl . Support::getProfilePicture(User::getSupportId(Yii::$app->user->getId())); ?>" class="img-circle-sidebar" alt="User Image">
                </div>
                <div class="pull-left info">
                  <p><?php echo Support::getName(User::getSupportId(Yii::$app->user->getId())); ?></p>
                  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
              </div>

          <?php } elseif(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_MANAGEMENT){ ?>
            <div class="user-panel">
              <div class="pull-left image">
                <img src="<?php echo Yii::$app->homeUrl . Management::getProfilePicture(User::getManagementId(Yii::$app->user->getId())); ?>" class="img-circle-sidebar" alt="User Image">
              </div>
              <div class="pull-left info">
                <p><?php echo Management::getName(User::getManagementId(Yii::$app->user->getId())); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
              </div>
            </div>
          <?php } elseif(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_SUPERVISOR) { ?>
            <div class="user-panel">
              <div class="pull-left image">
                <img src="<?php echo Yii::$app->homeUrl . Supervisor::getProfilePicture(User::getSupervisorId(Yii::$app->user->getId())); ?>" class="img-circle-sidebar" alt="User Image">
              </div>
              <div class="pull-left info">
                <p><?php echo Supervisor::getName(User::getSupervisorId(Yii::$app->user->getId())); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
              </div>
            </div>
          <?php } else { ?>
            <div class="user-panel">
              <div class="pull-left image">
                <img src="<?php echo Yii::$app->homeUrl . Support::getProfilePicture(User::getSupportId(Yii::$app->user->getId())); ?>" class="img-circle-sidebar" alt="User Image">
              </div>
              <div class="pull-left info">
                <p><?php echo Support::getName(User::getSupportId(Yii::$app->user->getId())); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
              </div>
            </div>
          <?php } ?>
          
          <ul class="sidebar-menu">
            <li class="header" style="text-align: center; color: white">MAIN MENU</li>
            <li>
                <a href="<?php echo Url::toRoute(['/site/index']);?>">
                  <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>  
            <?php if(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){?>
              <li>
                  <a href="#">
                    <i class="fa fa-user"></i> <span>Profile</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="<?php echo Url::toRoute(['/support/update', 'id' => User::getSupportId(Yii::$app->user->getId())]);?>"><i class="fa fa-circle-o"></i> Update </a></li>
                    <li><a href="<?php echo Url::toRoute(['/support/view', 'id' => User::getSupportId(Yii::$app->user->getId())]);?>"><i class="fa fa-circle-o"></i> View </a></li></li>
                  </ul>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-users"></i> <span>Users</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo Url::toRoute(['/user/index']);?>"><i class="fa fa-circle-o"></i> All </a></li>
                  <li><a href="<?php echo Url::toRoute(['/user/create']);?>"><i class="fa fa-circle-o"></i> Create </a></li></li>
                </ul>
              </li>
               <li>
                <a href="#">
                  <i class="fa fa-users"></i> <span>Managements</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo Url::toRoute(['/management/index']);?>"><i class="fa fa-circle-o"></i> All </a></li>
                  <li><a href="<?php echo Url::toRoute(['/management/create']);?>"><i class="fa fa-circle-o"></i> Create </a></li></li>
                </ul>
              </li>
             <li>
                <a href="#">
                  <i class="fa fa-users"></i> <span>Supervisors</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo Url::toRoute(['/supervisor/index']);?>"><i class="fa fa-circle-o"></i> All </a></li>
                  <li><a href="<?php echo Url::toRoute(['/supervisor/create']);?>"><i class="fa fa-circle-o"></i> Create </a></li></li>
                </ul>
              </li>
              <li>
                  <a href="#">
                    <i class="fa fa-users"></i> <span>Support</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="<?php echo Url::toRoute(['/support/index'])?>"></i> All Support</a></li>
                    <li><a href="<?php echo Url::toRoute(['/support-position/index'])?>"></i> All Position </a></li>
                    <li><a href="<?php echo Url::toRoute(['/support-area/index'])?>"></i> All Area </a></li>
                  </ul>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-users"></i> <span>PLN PICs</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo Url::toRoute(['/pln-pic/index']);?>"><i class="fa fa-circle-o"></i> All </a></li>
                  <li><a href="<?php echo Url::toRoute(['/pln-pic/create']);?>"><i class="fa fa-circle-o"></i> Create </a></li></li>
                </ul>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-calendar"></i> <span>Schedules</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo Url::toRoute(['/schedule/index']);?>"><i class="fa fa-circle-o"></i> All </a></li>
                  <li><a href="<?php echo Url::toRoute(['/schedule/create']);?>"><i class="fa fa-circle-o"></i> Create </a></li></li>
                  <li><a href="<?php echo Url::toRoute(['/schedule/viewcalendar']);?>"><i class="fa fa-circle-o"></i> View </a></li></li>
                </ul>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-clock-o"></i> <span>Shifts</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo Url::toRoute(['/shift/index']);?>"><i class="fa fa-circle-o"></i> All </a></li>
                  <li><a href="<?php echo Url::toRoute(['/shift/create']);?>"><i class="fa fa-circle-o"></i> Create </a></li></li>
                </ul>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-desktop"></i> <span>Service Family</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo Url::toRoute(['/service-family/index']);?>"><i class="fa fa-circle-o"></i> All </a></li>
                  <li><a href="<?php echo Url::toRoute(['/service-family/create']);?>"><i class="fa fa-circle-o"></i> Create </a></li></li>
                </ul>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-book"></i> <span>Duty Manager Report</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo Url::toRoute(['/dm-report/index']);?>"><i class="fa fa-circle-o"></i> All</a></li>
                  <li><a href="<?php echo Url::toRoute(['/dm-report/create']);?>"><i class="fa fa-circle-o"></i> Create</a></li></li>
                </ul>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-book"></i> <span>Support Report</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo Url::toRoute(['/support-report/index']);?>"><i class="fa fa-circle-o"></i> All</a></li>
                  <li><a href="<?php echo Url::toRoute(['/support-report/create']);?>"><i class="fa fa-circle-o"></i> Create</a></li></li>
                </ul>
              </li>
                <li>
                    <a href="<?php echo Url::toRoute('/dm-report/reporthistory');?>">
                        <i class="fa fa-calendar"></i><span>Report History</span>
                    </a>
                </li>
            <?php } elseif(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_MANAGEMENT){ ?>
              <li>
                  <a href="#">
                    <i class="fa fa-user"></i> <span>Profile</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="<?php echo Url::toRoute(['/management/update', 'id' => User::getManagementId(Yii::$app->user->getId())]);?>"><i class="fa fa-circle-o"></i> Update </a></li>
                    <li><a href="<?php echo Url::toRoute(['/management/view', 'id' => User::getManagementId(Yii::$app->user->getId())]);?>"><i class="fa fa-circle-o"></i> View </a></li></li>
                  </ul>
              </li>
              <li>
                <a href="<?php echo Url::toRoute('/schedule/viewcalendar');?>">
                  <i class="fa fa-calendar"></i> <span>Schedules</span>
                </a>
              </li>
               <li>
                <a href="<?php echo Url::toRoute(['/dm-report/index']);?>">
                  <i class="fa fa-book"></i> <span>Duty Manager Report</span>
                </a>
              </li>
              <li>
                <a href="<?php echo Url::toRoute(['/support-report/index']);?>">
                  <i class="fa fa-book"></i> <span>Support Report</span>
                </a>
              </li>
              <li>
                  <a href="<?php echo Url::toRoute('/dm-report/reporthistory');?>">
                      <i class="fa fa-calendar"></i><span>Report History</span>
                  </a>
              </li>
            <?php } elseif(User::getRoleId(Yii::$app->user->getId()) == User::ROLE_SUPERVISOR){ ?>
              <li>
                  <a href="#">
                    <i class="fa fa-user"></i> <span>Profile</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="<?php echo Url::toRoute(['/supervisor/update', 'id' => User::getSupervisorId(Yii::$app->user->getId())]);?>"><i class="fa fa-circle-o"></i> Update </a></li>
                    <li><a href="<?php echo Url::toRoute(['/supervisor/view', 'id' => User::getSupervisorId(Yii::$app->user->getId())]);?>"><i class="fa fa-circle-o"></i> View </a></li></li>
                  </ul>
              </li>
             <li>
                <a href="#">
                  <i class="fa fa-calendar"></i> <span>Schedules</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="<?php echo Url::toRoute(['/schedule/index']);?>"><i class="fa fa-circle-o"></i> All </a></li>
                  <li><a href="<?php echo Url::toRoute(['/schedule/create']);?>"><i class="fa fa-circle-o"></i> Create </a></li></li>
                  <li><a href="<?php echo Url::toRoute(['/schedule/viewcalendar']);?>"><i class="fa fa-circle-o"></i> View </a></li></li>
                </ul>
              </li>
              <li>
                  <a href="#">
                    <i class="fa fa-users"></i> <span>Support</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="<?php echo Url::toRoute(['/support/index'])?>"></i> All Support</a></li>
                    <li><a href="<?php echo Url::toRoute(['/support-area/index'])?>"></i> All Area </a></li>
                  </ul>
              </li>
              <li>
                <a href="<?php echo Url::toRoute(['/dm-report/index']);?>">
                  <i class="fa fa-book"></i> <span>Duty Manager Report</span>
                </a>
              </li>
              <li>
                <a href="<?php echo Url::toRoute(['/support-report/index']);?>">
                  <i class="fa fa-book"></i> <span>Support Report</span>
                </a>
              </li>
              <li>
                  <a href="<?php echo Url::toRoute('/dm-report/reporthistory');?>">
                      <i class="fa fa-calendar"></i><span>Report History</span>
                  </a>
              </li>
            <?php } else { ?>
                  <?php 
                      date_default_timezone_set("Asia/Jakarta");
                      if(Schedule::getIsDmNow(date('Y-m-d'), Shift::getShift(date("H:i:s"))->shift_id, User::getSupportId(Yii::$app->user->getId()))) { 
                  ?>
                      <li>
                        <a href="#">
                          <i class="fa fa-user"></i> <span>Profile</span>
                          <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="<?php echo Url::toRoute(['/support/update', 'id' => User::getSupportId(Yii::$app->user->getId())]);?>"><i class="fa fa-circle-o"></i> Update </a></li>
                          <li><a href="<?php echo Url::toRoute(['/support/view', 'id' => User::getSupportId(Yii::$app->user->getId())]);?>"><i class="fa fa-circle-o"></i> View </a></li></li>
                        </ul>
                      </li>
                      <li>
                        <a href="<?php echo Url::toRoute('/schedule/viewcalendar');?>">
                          <i class="fa fa-calendar"></i> <span>Schedules</span>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-book"></i> <span>Duty Manager Report</span>
                          <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="<?php echo Url::toRoute(['/dm-report/index']);?>"><i class="fa fa-circle-o"></i> All</a></li>
                          <li><a href="<?php echo Url::toRoute(['/dm-report/create']);?>"><i class="fa fa-circle-o"></i> Create</a></li></li>
                        </ul>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-book"></i> <span>Support Report</span>
                          <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="<?php echo Url::toRoute(['/support-report/index']);?>"><i class="fa fa-circle-o"></i> All </a></li>
                          <li><a href="<?php echo Url::toRoute(['/support-report/create']);?>"><i class="fa fa-circle-o"></i> Create </a></li></li>
                        </ul>
                      </li>
                <?php } else {?>
                        <li>
                        <a href="#">
                          <i class="fa fa-book"></i> <span>Profile</span>
                          <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="<?php echo Url::toRoute(['/support/update', 'id' => User::getSupportId(Yii::$app->user->getId())]);?>"><i class="fa fa-circle-o"></i> Update </a></li>
                          <li><a href="<?php echo Url::toRoute(['/support/view', 'id' => User::getSupportId(Yii::$app->user->getId())]);?>"><i class="fa fa-circle-o"></i> View </a></li></li>
                        </ul>
                        </li>
                          <li>
                          <a href="<?php echo Url::toRoute('/schedule/viewcalendar');?>">
                            <i class="fa fa-calendar"></i> <span>Schedules</span>
                          </a>
                          </li>
                          <?php 
                            date_default_timezone_set("Asia/Jakarta");
                            if(Schedule::getIsSupportNow(date('Y-m-d'), Shift::getShift(date("H:i:s"))->shift_id, User::getSupportId(Yii::$app->user->getId()))) { 
                                echo '
                                <li>
                                <a href="#">
                                  <i class="fa fa-book"></i> <span>Support Report</span>
                                  <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                  <li><a href="'. Url::toRoute(['/support-report/index']) .'"><i class="fa fa-circle-o"></i> All </a></li>
                                  <li><a href="'.  Url::toRoute(['/support-report/create']) .'"><i class="fa fa-circle-o"></i> Create </a></li></li>
                                </ul>
                              </li>';
                            } else {
                              echo '
                                <li>
                                  <a href="'. Url::toRoute(['/support-report/index']) .'">
                                        <i class="fa fa-book"></i> <span>Support Report</span>
                                      </a>
                              </li>';
                            }   
                          ?>
                  <?php } ?>
            <?php } ?>
            <li>
                <a href="<?php echo Url::toRoute(['/site/contact']);?>">
                  <i class="fa fa-info-circle"></i> <span>Contact Info</span>
                </a>
            </li>  
            <li>
                <a href="<?php echo Url::toRoute(['/user/changepassword']);?>">
                  <i class="fa fa-lock"></i> <span>Change Password</span>
                </a>
            </li>  
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <!-- Get all flash messages and loop through them -->
            <?php foreach (\Yii::$app->session->getAllFlashes() as $message):; ?>
              <?php
              echo \kartik\widgets\Growl::widget([
                  'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                  'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                  'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                  'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                  'showSeparator' => true,
                  'delay' => 1, //This delay is how long before the message shows
                  'pluginOptions' => [
                      'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                      'placement' => [
                          'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                          'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                      ]
                  ]
              ]);
              ?>
            <?php endforeach; ?>
            <?= $content ?>
        </section?>    
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-right">&copy; OJT 49 PT PLN (Persero) 2016</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
