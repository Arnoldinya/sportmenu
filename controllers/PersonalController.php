<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;

class PersonalController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $oUser = User::findOne(Yii::$app->user->id);

        return $this->render('index', array(
        	'oUser' => $oUser,
        ));
    }

    /**
    * Редактирвоать данные
    */
    public function actionUpdate()
    {
        $oUser = Yii::$app->user->identity;

        if ($oUser->load(Yii::$app->request->post()) && $oUser->save())
        {
            return $this->redirect(['index']);
        } 
        else
        {
            return $this->render('update', [
                'oUser' => $oUser,
            ]);
        }
    }
}
