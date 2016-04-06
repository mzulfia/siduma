<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
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
    <title>SIDUMA</title>
    <?php $this->head() ?>
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo \Yii::$app->homeUrl;?>images/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

</head>
<?php $this->beginBody() ?>
<body style="background-color: #d2d6de;"> 
  <div class="container">
    <div class="row">
      <div class="box box-danger" style="margin-top: 5%; box-shadow: 10px 10px 5px #888888;">
        <div class="box-header with-border">
          <h3 class="box-title">Error</h3>
        </div>
        <div class="box-body">
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
        <?= $content; ?>
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
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>