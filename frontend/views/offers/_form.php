<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Audit $model */
/** @var yii\widgets\ActiveForm $form */


$this->registerJsFile('@web/js/site.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="offers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <div class="form-group" style="margin-top: 10px;    ">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'id' => 'btn-submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
