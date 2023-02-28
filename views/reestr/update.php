<?php

use yii\helpers\Html;
use app\models\Family;

/* @var $this yii\web\View */
/* @var $model app\models\Reestr */

$this->params['breadcrumbs'][] = ['label' => Family::find_father($model->id_fio), 'url' => ['fio/update?id='.$model->id_fio.'&rel=5']];?>
<div class="reestr-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
