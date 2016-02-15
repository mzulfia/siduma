<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PicPosition */

$this->title = 'Create Pic Position';
$this->params['breadcrumbs'][] = ['label' => 'Pic Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pic-position-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
