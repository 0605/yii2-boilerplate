<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/6/20
 * Time: 19:31
 */

namespace app\modules\admin\spa;

class ManifestAssetBundle extends \app\core\components\ManifestAssetBundle
{
    public $manifestFile = 'admin' . DIRECTORY_SEPARATOR . 'manifest.json';
}
