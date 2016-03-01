<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SupportArea */

$this->title = 'Create Support Area';
$this->params['breadcrumbs'][] = ['label' => 'Support Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="support-area-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
