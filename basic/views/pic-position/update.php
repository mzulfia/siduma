<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PicPosition */

$this->title = 'Update Pic Position: ' . ' ' . $model->pic_position_id;
$this->params['breadcrumbs'][] = ['label' => 'Pic Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pic_position_id, 'url' => ['view', 'id' => $model->pic_position_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pic-position-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
