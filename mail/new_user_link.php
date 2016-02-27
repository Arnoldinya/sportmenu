<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>
<div class="site-login">
    <h1>Здравствуйте!</h1>

    <h3>
        Вы зарегистрирвоались на сайте!
    </h3>

    <p>
        Для завершения регистрации перейдите по ссылке: <a href="<?php echo Yii::$app->params['domain'].Url::toRoute(['site/activate', 'hash' => $sHash])?>">
        <?php echo Yii::$app->params['domain'].Url::toRoute(['site/activate', 'hash' => $sHash])?></a>
    </p>
</div>