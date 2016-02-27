<?php
namespace app\commands;
use Yii;
use yii\console\Controller;
use app\rbac\UserRoleRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth = Yii::$app->authManager;
        $user = $auth->createRole('user');
        $auth->add($user);

        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('admin');
        $auth->assign($admin, 1);
    }
}
