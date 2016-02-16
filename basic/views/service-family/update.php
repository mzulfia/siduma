<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceFamily */

$this->title = 'Update Service Family: ' . ' ' . $model->service_family_id;
$this->params['breadcrumbs'][] = ['label' => 'Service Families', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->service_family_id, 'url' => ['view', 'id' => $model->service_family_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="service-family-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
