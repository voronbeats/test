<?php


namespace common\models;


use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

class GeneralModel extends \yii\db\ActiveRecord
{

    const HIDDEN = 0;
    const VISIBLE = 1;


    /**
     * Возвращает массив вариантов видимости
     *
     * @return array
     */
    public static function getVisibleOptions(): array
    {
        return [
            self::VISIBLE => 'Видимый',
            self::HIDDEN => 'Скрытый',
        ];
    }


}