<?php

namespace app\core\models\user;

use app\core\models\Identity;
use app\core\validators\PhoneNumberValidator;

/**
 * Class User
 *
 * @property string $phone
 * @property string $email
 * @property string $name
 * @property string $avatar
 * @property string $createdIp
 * @property string $createdFrom
 *
 * @package app\core\models\user
 */
class User extends Identity
{
    public const CREATED_FROM_SYSTEM = 'SYSTEM';
    public const CREATED_FROM_WEB = 'WEB';
    public const CREATED_FROM_APP = 'APP';
    public const CREATED_FROM_WECHAT = 'WECHAT';

    private $createdFromCache = null;

    public static function findByAccessToken($accessToken, $clientId)
    {
        return null;
    }

    /**
     * @return array
     */
    public static function createdFromValues()
    {
        $createdFromList = static::createdFromList();

        $createdFromValues = [];

        foreach ($createdFromList as $item) {
            $createdFromValues[] = $item->value;
        }

        return $createdFromValues;
    }

    /**
     * @return UserCreatedFrom[]
     */
    public static function createdFromList()
    {
        return [
            new UserCreatedFrom(static::CREATED_FROM_APP, 'APP'),
            new UserCreatedFrom(static::CREATED_FROM_WEB, '网站'),
            new UserCreatedFrom(static::CREATED_FROM_WECHAT, '微信'),
            new UserCreatedFrom(static::CREATED_FROM_SYSTEM, '系统'),
        ];
    }

    public function rules()
    {
        return [
            [['phone', 'email', 'name', 'avatar', 'password', 'passwordRepeat'], 'trim'],
            [['password', 'passwordRepeat'], 'required', 'on' => 'create'],
            [
                ['password', 'passwordRepeat'],
                'string',
                'length' => [5, 20],
                'on' => 'create',
                'when' => function ($model) {
                    return !empty($model->passwordRepeat);
                }
            ],
            ['password', 'compare', 'compareAttribute' => 'passwordRepeat'],
            [['phone', 'email'], 'required'],
            ['phone', PhoneNumberValidator::class],
            ['phone', 'unique'],
            ['email', 'email'],
            ['email', 'unique'],
            ['name', 'string', 'length' => [2, 6]],

        ];
    }

    public function scenarios()
    {
        return [
            'create' => ['password', 'passwordRepeat', 'phone', 'email', 'name', 'avatar'],
            'edit' => ['password', 'passwordRepeat', 'phone', 'email', 'name', 'avatar'],
            'profile' => ['password', 'passwordRepeat', 'phone', 'email', 'name', 'avatar'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => '电话',
            'email' => '邮箱',
            'password' => '密码',
            'passwordRepeat' => '重复密码',
            'name' => '姓名',
            'avatar' => '头像',
            'createdAt' => '注册时间',
            'createdIp' => '注册 IP',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'phone',
            'email',
            'name',
            'avatar',
            'createdAt' => function ($user) {
                /* @var $user User */
                return \Yii::$app->getFormatter()->asDatetime($user->createdAt);
            },
            'createdIp',
            'createdFrom' => function ($user) {
                /* @var $user User */
                return $user->getUserCreatedFrom();
            },
        ];
    }

    /**
     * @return UserCreatedFrom
     */
    public function getUserCreatedFrom()
    {
        if ($this->createdFromCache == null) {
            $createdFrom = new UserCreatedFrom('', '未知');

            foreach (static::createdFromList() as $item) {
                if ($item->value == $this->createdFrom) {
                    $createdFrom = $item;
                    break;
                }
            }

            $this->createdFromCache = $createdFrom;
        }

        return $this->createdFromCache;
    }

    public function can($actionId)
    {
        return true;
    }

    public function generateAccessToken($clientId = '')
    {
        return '';
    }
}
