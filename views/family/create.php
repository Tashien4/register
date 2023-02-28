<?php

use yii\helpers\Html;
use app\models\Family;

/* @var $this yii\web\View */
/* @var $model app\models\Family */

$this->params['breadcrumbs'][] = ['label' => 'Члены семьи '.$model->find_father($model->id_fio), 'url' => ['fio/update?id='.$model->id_fio]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="family-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,        'mmodel' => $mmodel,
    ]) ?>

</div>
