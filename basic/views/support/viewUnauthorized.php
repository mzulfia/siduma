<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\User;
use app\models\Support;
use app\models\SupportArea;

/* @var $this yii\web\View */
/* @var $model app\models\Pic */

$this->title = "Supports | View Profile";
$this->params['breadcrumbs'][] = 'View Profile';
?>
<div class="support-viewUnauthorized">

    <div class="profile-picture">
        <?= Html::img(Yii::$app->homeUrl . Support::getProfilePicture($model->support_id), ['class' => 'img-circle', 'alt' => 'Support Image']);?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'support_name',
            'company',
            'no_hp',
            'email',
            [
                'label' => 'Position',
                'value' => $model->pos->position_name
            ],
            [
                'label' => 'Service Family',
                'format'=>'raw',
                'value' => SupportArea::getServiceInCharge($model->support_id)
            ]
        ],
    ]) ?>

</div>
