<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
// use app\assets\AppAsset;
use app\assets\DashboardAsset;
use app\models\User;

DashboardAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Sistem Informasi Duty Manager</title>
    <?php $this->head() ?>
	
	    <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo \Yii::$app->homeUrl;?>css/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo \Yii::$app->homeUrl;?>css/form-elements.css">
        <link rel="stylesheet" href="<?php echo \Yii::$app->homeUrl;?>css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo \Yii::$app->homeUrl;?> images/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

</head>
<?php $this->beginBody() ?>
  <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>SIDUMA</strong> Login</h1>
                            <div class="description">
                            	<p>
	                                                     
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Sistem Informasi Duty Manager</h3>
                            		<p>Enter your username and password to log on:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
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
                            <div class="form-bottom">
                               <?= $content; ?>
			                    <!-- <form role="form" action="" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="form-username" placeholder="Username..." class="form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="form-password" placeholder="Password..." class="form-password form-control" id="form-password">
			                        </div>
			                      <!--  <button type="submit" class="btn">Sign in!</button> -->
                                   
			                    <!-- </form> -->
		                    </div>
                        </div>
                    </div>
                    <div class="row">
                       
                    </div>
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="<?php echo \Yii::$app->homeUrl;?>js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo \Yii::$app->homeUrl;?>js/bootstrap/bootstrap.min.js"></script>
        <script src="<?php echo \Yii::$app->homeUrl;?>js/jquery.backstretch.min.js"></script>
        <script src="<?php echo \Yii::$app->homeUrl;?>js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>