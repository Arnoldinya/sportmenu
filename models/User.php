<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $surname
 * @property string $name
 * @property string $patronymic
 * @property string $phone
 *
 * @property Service[] $services
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $authKey;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['is_active'], 'integer'],
            [['email', 'password', 'surname', 'name', 'patronymic', 'phone', 'hash'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'patronymic' => 'Отчество',
            'phone' => 'Телефон',
            'hash' => 'Токен',
            'is_active' => 'Активирован',
        ];
    }

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
        /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getFIO()
    {
        $aName = [
            $this->surname,
            $this->name,
            $this->patronymic,
        ];
        $sName = trim(implode(" ", $aName));
        
        return $sName ? $sName : "ФИО";
    }

    public static function getRole($iUserId, $rus = true)
    {
        if($iUserId)
        {
            $connection = \Yii::$app->db;
            $connection->open();
            $sql = "select auth_item.description, auth_item.name from auth_item
            join auth_assignment on auth_assignment.item_name=auth_item.name
            where auth_assignment.user_id=".$iUserId;
            $command = $connection->createCommand($sql);
            $aData = $command->queryOne();

            if($rus)
                return $aData['description'];
            else
                return $aData['name'];
        }
    }

    public static function findByRolename($sRole)
    {
        return static::find()
                ->join('LEFT JOIN','auth_assignment','auth_assignment.user_id = id')
                ->where(['auth_assignment.item_name' => $sRole])
                ->all();
    }

    /**
    * Генератор пароля
    * @return string password
    */
    public static function generatePass()
    {
        $aData = [
            'a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0'
        ];

        // Генерируем пароль
        $sPass = "";
        for($i = 0; $i < 8; $i++)
        {
          // Вычисляем случайный индекс массива
          $iIndex = rand(0, count($aData) - 1);
          $sPass .= $aData[$iIndex];
        }

        return $sPass;
    }
}
