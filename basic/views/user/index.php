<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

use app\models\User;
use app\models\Role;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users | All';
$this->params['breadcrumbs'][] = 'Users';
?>
<div class="user-index">

    <h1>Users</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            [
                'attribute' => 'role_id',
                'value' => 'role.role_name',
                'filter' => Html::activeDropDownList($searchModel, 'role_id', ArrayHelper::map(Role::find()->all(), 'role_id', 'role_name'),['class'=>'form-control','prompt' => '-']),
            ],
            [
                'header' => 'Action',
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}',
                'contentOptions' => ['style' => 'width:50px;']
            ],
        ],
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'bordered'=>true,
    ]); ?>

</div>
