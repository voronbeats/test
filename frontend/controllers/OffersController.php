<?php

namespace frontend\controllers;

use common\models\Offers;
use common\models\Questions;
use common\models\search\OffersSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Offers controller
 */
class OffersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Offers();
        $searchModel = new OffersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('_data', [
                'dataProvider' => $dataProvider,
            ]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Offers::findOne($id);

        $name = Yii::$app->request->post('name');
        $email = Yii::$app->request->post('email');
        $phone = Yii::$app->request->post('phone');
        $model->name = $name;
        $model->email = $email;
        $model->phone = $phone;


        if ($model->save()) {
            return $this->asJson(['success' => true, 'model' => $model]);
        }
    }

    public function actionCreate()
    {
        $model = new Offers();

        $name = Yii::$app->request->post('name');
        $email = Yii::$app->request->post('email');
        $phone = Yii::$app->request->post('phone');

        if (Yii::$app->request->isAjax) {
            $model->name = $name;
            $model->email = $email;
            $model->phone = $phone;
        }

        if (!$model->save()) {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Offers::findOne(['id' => $id]);
        if ($model !== null) {
            $model->delete();
            return $this->redirect('/');
        }
    }
}
