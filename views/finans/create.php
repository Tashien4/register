<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Finans */

$this->title = 'Create Finans';
$this->params['breadcrumbs'][] = ['label' => 'Finans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finans-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
