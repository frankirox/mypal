<?php
/**
 * @var common\widgets\ActiveForm $form
 * @var common\models\Permission $model
 */

use yii\helpers\Html;

$this->title = Yii::t('miranda/user', 'Update Permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('miranda/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('miranda/user', 'Permissions'), 'url' => ['/user/permission/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="permission-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>