<?php
/**
 * Created by PhpStorm.
 * User: Huijiewei
 * Date: 2014/11/3
 * Time: 16:21
 */

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $context \app\modules\admin\spa\Controller */
$context = $this->context;

\app\modules\admin\spa\ManifestAssetBundle::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="api-host" content="<?= \app\modules\admin\api\Module::toRoute([''], true); ?>">
        <title><?= '管理后台' . ' - ' . Yii::$app->name; ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div id="root"></div>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage();
