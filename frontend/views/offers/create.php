<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Offers $model */

$this->title = 'Создать пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
