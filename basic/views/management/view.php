<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Management */

$this->title = "Profile";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="management-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mgt_nip',
            'mgt_name',
            'mgt_position',
        ],
    ]) ?>

</div>
