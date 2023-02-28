<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Fio */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_fio',
            'id_bls',
            'id_bls_reg',
            'id_bls_fact',
            'tel',
            'family_status',
            'org',
            'dolg',
            'obr',
            'spec',
            'lgtype',
            'house_status',
            'gas',
            'water',
            'blag',
            'form',
            'tab',
        ],
    ]) ?>

</div>
