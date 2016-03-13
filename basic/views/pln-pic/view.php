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

    <h1>Profile</h1>

   <p>
        <?php if(User::getRoleId(Yii::$app->user->id) == User::ROLE_ADMINISTRATOR): ?>
            <?= Html::a('Update', ['update', 'id' => $model->pln_pic_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->pln_pic_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

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
