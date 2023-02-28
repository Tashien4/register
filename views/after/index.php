<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Afters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="after-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create After', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_fio',
            'reability',
            'medicine',
            'psiho',
            //'indiv',
            //'sanatory',
            //'social',
            //'uridict',
            //'vosstan',
            //'trud',
            //'stady',
            //'perepod',
            //'finans_help',
            //'veterans',
            //'initiative',
            //'others',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
