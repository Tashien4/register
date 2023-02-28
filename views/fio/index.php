<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Fio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_fio',
            'id_bls',
            'id_bls_reg',
            'id_bls_fact',
            //'tel',
            //'family_status',
            //'org',
            //'dolg',
            //'obr',
            //'spec',
            //'lgtype',
            //'house_status',
            //'gas',
            //'water',
            //'blag',
            //'form',
            //'tab',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
