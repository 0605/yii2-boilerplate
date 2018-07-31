<?php
/**
 * Created by PhpStorm.
 * User: huijiewei
 * Date: 2018/7/7
 * Time: 23:34
 */

namespace app\modules\admin\api\controllers;

use app\core\models\user\User;
use app\modules\admin\api\Controller;
use app\modules\admin\api\models\UserSearchFrom;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function actionCreate()
    {
        $user = new User();

        if (!\Yii::$app->getRequest()->getIsPost()) {
            return $user;
        }

        $user->setScenario('create');
        $user->load(\Yii::$app->getRequest()->getBodyParams(), '');
        $user->createdFrom = User::CREATED_FROM_SYSTEM;
        $user->createdIp = \Yii::$app->getRequest()->getUserIP();

        if (!$user->save()) {
            return $user;
        }

        return $this->message('会员新建成功', ['userId' => $user->id]);
    }

    public function actionDelete($id)
    {
        $user = $this->getUserById($id);

        if (!$user->delete()) {
            return $user;
        } else {
            return $this->message('会员删除成功');
        }
    }

    private function getUserById($id)
    {
        /* @var $user User */
        $user = User::findOne(['id' => $id]);

        if ($user == null) {
            throw new NotFoundHttpException('会员不存在');
        }

        return $user;
    }

    public function actionEdit($id)
    {
        $user = $this->getUserById($id);

        if (!\Yii::$app->getRequest()->getIsPut()) {
            return $user;
        }

        $user->setScenario('edit');
        $user->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if (!$user->save()) {
            return $user;
        }

        return $this->message('会员编辑成功');
    }

    public function actionIndex()
    {
        return $this->userSearchForm();
    }

    private function userSearchForm()
    {
        $form = new UserSearchFrom();
        $form->load(\Yii::$app->getRequest()->getQueryParams(), '');

        return $form;
    }

    public function actionExport()
    {
        $form = $this->userSearchForm();

        $export = $form->export();

        if ($export == null) {
            throw new BadRequestHttpException('不支持导出');
        }

        return $export->send('用户列表.xlsx');
    }

    public function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'create' => ['GET', 'HEAD', 'POST'],
            'view' => ['GET', 'HEAD'],
            'edit' => ['GET', 'HEAD', 'PUT'],
            'delete' => ['DELETE'],
            'export' => ['GET', 'HEAD'],
        ];
    }
}
