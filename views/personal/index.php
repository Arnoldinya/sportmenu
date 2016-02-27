<?php
	use yii\helpers\Html;
	use yii\widgets\DetailView;
	use yii\helpers\Url;
    use app\models\User;

	$this->title = 'Личный кабинет';
	$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div>
    <?php echo $oUser->FIO?>
</div>

<p>
    <a class="btn btn-primary" href="<?php echo Url::toRoute(['personal/update']);?>">Редактировать профиль</a>
</p>
