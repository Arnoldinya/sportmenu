<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php if (Yii::$app->session->hasFlash('registerFormSubmitted')): ?>
        <div class="alert alert-success">
            Для завершения регистрации перейдите по ссылке, которая была отправлена на ваш E-mail.
        </div>
    <?php else:?>
        <div class="user-form">

            <?php $form = ActiveForm::begin(); ?>

            <div class="form-group">
                <?= $form->field($oUser, 'email')->textInput(['maxlength' => 500]) ?>
            </div>

            <div class="form-group">
                <?php echo Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    <?php endif;?>
</div>
