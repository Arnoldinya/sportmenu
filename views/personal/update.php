<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Редактирвоать профиль';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="user-form">

	    <?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($oUser, 'email')->textInput(['maxlength' => 500]) ?>

	    <?= $form->field($oUser, 'password')->passwordInput(['maxlength' => 500]) ?>

	    <?= $form->field($oUser, 'surname')->textInput(['maxlength' => 500]) ?>

	    <?= $form->field($oUser, 'name')->textInput(['maxlength' => 500]) ?>

	    <?= $form->field($oUser, 'patronymic')->textInput(['maxlength' => 500]) ?>

	    <?= $form->field($oUser, 'phone')->textInput(['maxlength' => 500]) ?>

	    <div class="form-group">
	        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>