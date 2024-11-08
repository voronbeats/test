<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

Pjax::begin(['id' => 'pjax-container']);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'name',
        'email',
        [
            'attribute' => 'phone',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->echoNumber($model->phone);
            },
        ],
        'created_at:date',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('Редактировать', '#', [
                        'class' => 'btn btn-primary edit-button',
                        'data-id' => $model->id, // Сохраняем ID записи
                        'data-name' => $model->name, // Сохраняем текущее имя
                        'data-email' => $model->email, // Сохраняем текущий email
                        'data-phone' => $model->phone, // Сохраняем текущий номер телефона
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('Удалить', 'offers/delete?id='. $model->id, [
                        'class' => 'btn btn-danger',
                        'data-confirm' => 'Вы уверены, что хотите удалить эту запись?',
                        'data-method' => 'post',
                    ]);
                },
            ],
        ],
    ],
]);
Pjax::end();
