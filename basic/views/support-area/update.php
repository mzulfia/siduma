<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportArea */

$this->title = 'Update Support Area: ' . ' ' . $model->support_area_id;
$this->params['breadcrumbs'][] = ['label' => 'Support Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->support_area_id, 'url' => ['view', 'id' => $model->support_area_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="support-area-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
