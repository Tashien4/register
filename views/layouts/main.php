<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100" style="background: radial-gradient( #ffffff,#ebebeb);">
<style>
    /*.nav > li > a {font-size:18px;} */
</style>

<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
                'items' => [!Yii::$app->user->isGuest ? (['label' => 'Личный кабинет', 'url' => ['/site/lk']]):(['label' => '', 'url' => ['/site/login']]),
            	    !Yii::$app->user->isGuest ? (['label' => 'Реестр', 'url' => ['/fio/list']]):(['label' => '', 'url' => ['/site/login']]),
			!Yii::$app->user->isGuest ? (['label' => 'Список членов семьи', 'url' => ['/family/list']]):(['label' => '', 'url' => ['/site/login']]),
    		!Yii::$app->user->isGuest ? (['label' => 'Обращения', 'url' => ['/reestr/list']]):(['label' => '', 'url' => ['/site/login']]),
            Yii::$app->user->isGuest ?
                ['label' => '', 'url' => ['/site/index']]:
                 Yii::$app->user->identity->role>0 ? 
                ['label' => 'Администрирование', 'url' => ['/site/admin']]:
                ['label' => '', 'url' => ['/site/index']],
             Yii::$app->user->isGuest ? (
                ['label' => 'Вход', 'url' => ['/site/login']]
            ) : ( ['label' => 'Выход (' . Yii::$app->user->identity->usernamerus . ')', 'url' => ['/site/logout']]
              
            )
        ],
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
