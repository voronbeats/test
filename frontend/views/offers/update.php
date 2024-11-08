<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Offers $model */

$this->title = 'Обновить ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->name];
?>
<div class="offers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
