<?php

namespace app\modules\admin\api\controllers;

use app\core\models\admin\Admin;
use app\modules\admin\api\Controller;
use app\modules\admin\api\models\AdminSearchForm;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function actionCreate()
    {
        $admin = new Admin();

        if (!\Yii::$app->getRequest()->getIsPost()) {
            return $admin;
        }

        $admin->setScenario('create');
        $admin->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$admin->save()) {
            return $admin;
        }

        return $this->message('管理员新建成功', ['adminId' => $admin->id]);
    }

    public function actionDelete($id)
    {
        $admin = $this->getAdminById($id);

        if (!$admin->delete()) {
            return $admin;
        } else {
            return $this->message('管理员删除成功');
        }
    }

    private function getAdminById($id)
    {
        /* @var $admin Admin */
        $admin = Admin::findOne(['id' => $id]);

        if ($admin == null) {
            throw new NotFoundHttpException('管理员不存在');
        }

        return $admin;
    }

    public function actionEdit($id)
    {
        $admin = $this->getAdminById($id);

        if (!\Yii::$app->getRequest()->getIsPut()) {
            return $admin;
        }

        $admin->setScenario('edit');
        $admin->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$admin->save()) {
            return $admin;
        }

        return $this->message('管理员编辑成功');
    }

    public function actionIndex()
    {
        $form = new AdminSearchForm();
        $form->load(\Yii::$app->getRequest()->getQueryParams(), '');

        return $form;
    }

    public function actionView($id)
    {
        return $this->getAdminById($id);
    }

    public function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'create' => ['GET', 'HEAD', 'POST'],
            'view' => ['GET', 'HEAD'],
            'edit' => ['GET', 'HEAD', 'PUT'],
            'delete' => ['DELETE'],
        ];
    }
}
