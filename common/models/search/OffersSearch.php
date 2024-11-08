<?php

namespace common\models\search;

use common\models\Offers;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OffersSearch extends Offers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone'], 'integer'],
            [['name', 'email'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    public function search($params)
    {
        
        $query = Offers::find();
        // Загружаем параметры
        $this->load($params);

        if (!$this->validate()) {
            return new ActiveDataProvider([
                'query' => $query,
            ]);
        }

        if (!empty($_GET['name'])) {
            $query->andFilterWhere(['like', 'name', $_GET['name']]);
        }

        if (!empty($_GET['email'])) {
            $query->andFilterWhere(['like', 'email', $_GET['email']]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' =>
            [
                'pagesize' => 10,
            ]
        ]);
    }
}
