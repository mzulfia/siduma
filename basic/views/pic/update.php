<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pic */

$this->title = 'Update Pic: ' . ' ' . $model->pic_id;
$this->params['breadcrumbs'][] = ['label' => 'Pics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pic_id, 'url' => ['view', 'id' => $model->pic_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
