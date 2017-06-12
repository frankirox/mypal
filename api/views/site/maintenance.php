<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

$this->registerCss("
.fa-spin-custom {
  -webkit-animation: spin 10000ms infinite linear;
  animation: spin 10000ms infinite linear;
}

.fa-spin-custom-inverse {
  -webkit-animation: inverse-spin 10000ms infinite linear;
  animation: inverse-spin 10000ms infinite linear;
}

@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(359deg);
    transform: rotate(359deg);
  }
}

@keyframes spin {
  0% {
   -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
  -webkit-transform: rotate(359deg);
    transform: rotate(359deg);
   
    
  }
}

@-webkit-keyframes inverse-spin {
  0% {
    -webkit-transform: rotate(359deg);
    transform: rotate(359deg);
  }
  100% {
  
   -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
   
  }
}
@keyframes inverse-spin {
  0% {
    -webkit-transform: rotate(359deg);
    transform: rotate(359deg);
  }
  100% {
  -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
    
  }
}

");

?>

<div class="col-middle">
    <div class="text-center">
        <i class="fa fa-cog fa-spin-custom" style="font-size: 272px; color: #ccc;"></i> <i class="fa fa-cog fa-spin-custom-inverse" style="font-size: 172px; color: #ccc;"></i>
        <h1><?= Yii::t('miranda', 'Under Maintenance')?></h1>
        <p>
            <?= Yii::t('miranda', 'We are working hard for you and will return in a few minutes...')?>
        </p>
        <br>
        <?= \yii\helpers\Html::a(Yii::t('miranda', 'Try again'), \yii\helpers\Url::toRoute('/site/index'),['class' => 'btn btn-lg btn-success']); ?>
    </div>
</div>
