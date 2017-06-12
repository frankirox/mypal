<?php

use common\widgets\assets\LanguageSelectorAsset;
use yii\helpers\ArrayHelper;

\backend\widgets\LanguageSelector\assets\LanguageSelectorAsset::register($this);

?>

<ul class="dropdown-menu dropdown-usermenu" id="front-end-dorpdown-menu">
    <?php foreach ($languages as $key => $lang) : ?>

        <?php $link = Yii::$app->urlManager->createUrl(ArrayHelper::merge($params, [$url, 'language' => $key])); ?>

        <li role="language">
            <a href="<?= $link ?>"><?= $lang ?></a>
        </li>

    <?php endforeach; ?>
</ul>

