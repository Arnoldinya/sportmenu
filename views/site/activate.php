<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Ошибка!';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="alert alert-danger">

        <?php echo $sMessage;?>

    </div>
</div>
