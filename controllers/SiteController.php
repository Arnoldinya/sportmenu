<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
    * Регистрация
    */
    public function actionIndex()
    {
        $oUser = new User();

        if ($oUser->load(Yii::$app->request->post()) && $oUser->validate(['email']))
        {
            $oUser->hash = md5($oUser->email.'salt');
            $oUser->password = User::generatePass();

            if($oUser->save())
            {
                //назначаем роль "user"
                $auth = Yii::$app->authManager;
                $role = $auth->getRole('user');
                $auth->assign($role, $oUser->id);

                //После ввода e-mail пользователю высылается одноразовая ссылка.
                Yii::$app->mailer->compose('new_user_link', [
                    'sHash' => $oUser->hash,
                ])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo(trim($oUser->email))
                ->setSubject('Регистрация на сайте')
                ->send();

                Yii::$app->session->setFlash('registerFormSubmitted');
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'oUser' => $oUser,
        ]);
    }

    public function actionActivate($hash)
    {
        $oUser = User::find()->where([
            'hash' => $hash,
        ])->one();

        $sMessage = '';
        if($oUser)
        {
            if ($oUser->is_active==0)
            {
                $oUser->is_active = 1;
                $oUser->save();

                if(!Yii::$app->user->isGuest)
                    Yii::$app->user->logout();

                $oLoginForm = new LoginForm();
                $oLoginForm->username = $oUser->email;
                $oLoginForm->password = $oUser->password;
                $oLoginForm->login();

                return $this->redirect(['personal/index']);
            }
            else
            {
                $sMessage = 'Данная ссылка устарела.';
            }
        }
        else
            $sMessage = 'Пользователь не найден.';

        return $this->render('activate', [
            'sMessage' => $sMessage,
        ]);
    }

    /**
    * Вход
    */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $oLoginForm = new LoginForm();        

        if ($oLoginForm->load(Yii::$app->request->post()))
        {
            $oUser = User::findByUsername($oLoginForm->username);

            $oLoginForm->is_active = $oUser ? $oUser->is_active : 2;

            if($oLoginForm->login())
            {
                return $this->goBack();
            }          
        }


        return $this->render('login', [
            'oLoginForm' => $oLoginForm,
        ]);
    }

    /**
    * Выход
    */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
