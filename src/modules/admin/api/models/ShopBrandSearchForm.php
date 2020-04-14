<?php

namespace app\modules\admin\api\models;

use app\core\models\SearchForm;
use app\core\models\shop\ShopBrand;

class ShopBrandSearchForm extends SearchForm
{
    public $name;

    /**
     * @return array|null
     */
    public function searchFields()
    {
        return [
            [
                'type' => 'keyword',
                'field' => 'name',
                'label' => '品牌',
            ]
        ];
    }

    public function searchRules()
    {
        return [
            [['name'], 'trim']
        ];
    }

    public function exportOptions()
    {
        return null;
    }

    protected function getQuery()
    {
        $shopBrandQuery = ShopBrand::find()->with(['shopCategories'])->orderBy(['id' => SORT_DESC]);

        if (!empty($this->name)) {
            $shopBrandQuery->andWhere(['LIKE', 'name', $this->name]);
        }

        return $shopBrandQuery;
    }
}
