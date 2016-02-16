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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<div class="container">    
        <div id="loginbox" style="margin-top:200px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">Sign In</div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >
						<?= $content ?>
					</div>                     
            </div>  
    </div>
</div>        
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>