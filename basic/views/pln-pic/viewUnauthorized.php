<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\User;
use app\models\PicArea;
use app\models\PlnPic;

/* @var $this yii\web\View */
/* @var $model app\models\PlnPic */

$this->title = 'PLN PIC | View Profile';

if(User::getRoleId(\Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){
    $this->params['breadcrumbs'][] = ['label' => 'PLN PICs', 'url' => ['index']];
    $this->params['breadcrumbs'][] = 'View Profile';
} else{
    $this->params['breadcrumbs'][] = 'View Profile';
}
?>
<div class="pln-pic-view">

    <div class="profile-picture">
        <?= Html::img(Yii::$app->homeUrl . PlnPic::getProfilePicture($model->pln_pic_id), ['class' => 'img-circle', 'alt' => 'PLN PIC Image']);?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pic_name',
            'email',
            'no_hp',
            [
                'label' => 'Service Family',
                'format' => 'raw',
                'value' => PicArea::getServiceInCharge($model->pln_pic_id)
            ]
        ],
    ]) ?>

</div>
