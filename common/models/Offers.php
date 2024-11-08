<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "offers".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $phone
 * @property string|null $created_at
 */

class Offers extends GeneralModel
{
    public static function tableName()
    {
        return '{{%offers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['phone', 'created_at', 'updated_at'], 'integer'],
            [['name', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название оффера',
            'email' => 'email',
            'phone' => 'Номер телефона',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    function echoNumber($aphone)
    {
        return sprintf(
            "%s (%s) %s-%s-%s",
            substr($aphone, 0, 1),
            substr($aphone, 1, 3),
            substr($aphone, 4, 3),
            substr($aphone, 7, 2),
            substr($aphone, 9)
        );
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = strtotime(date('Y-m-d H:i:s'));
                // Yii::$app->session->setFlash('success', 'Запись добавлена!');
            } else {
                // Yii::$app->session->setFlash('success', 'Запись обновлена!');
                $this->updated_at = strtotime(date('Y-m-d H:i:s'));
            }
            return true;
        } else {
            return false;
        }
    }
}
