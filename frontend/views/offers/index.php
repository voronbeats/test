<?php

use yii\widgets\ListView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->registerJsFile('@web/js/site.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<div class="d-flex p-2" style="justify-content:space-between; background-color: rgba(0, 0, 0, 20%);">
    <div class="col-3" style="margin-right: 10px;">
        <?= Html::input('text', 'name', '', ['id' => 'name-input', 'placeholder' => 'Поиск по имени', 'class' => 'form-control']) ?>
    </div>
    <div class="col-3">
        <?= Html::input('text', 'email', '', ['id' => 'email-input', 'placeholder' => 'Поиск по email', 'class' => 'form-control']) ?>
    </div>
    <div class="col-6"></div>
</div>

<h1><?= Html::encode($this->title) ?></h1>

<div id="data-container">
    <?= $this->render('_data', ['dataProvider' => $dataProvider]) ?>
</div>



<div id="form-container">
    <?php $form = ActiveForm::begin(['id' => 'offer-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Введите название оффера', 'id' => 'offers-name']) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Введите email', 'id' => 'offers-email']) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Введите номер телефона', 'id' => 'offers-phone']) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success mt-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<div id="edit-modal" style="display:none;">

    <?php $form = ActiveForm::begin(['id' => 'edit-form']); ?>

    <?= $form->field($model, 'id')->hiddenInput(['id' => 'edit-id', 'name' => 'id'])->label(false) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Введите название оффера', 'id' => 'edit-name', 'name' => 'name']) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Введите email', 'id' => 'edit-email', 'name' => 'email']) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Введите номер телефона', 'id' => 'edit-phone', 'name' => 'phone']) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success mt-2']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
   
</div>

