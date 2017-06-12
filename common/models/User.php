<?php

namespace common\models;

use common\helpers\AuthHelper;
use common\helpers\MirandaHelper;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use common\models\query\UserQuery;

/**
 * This is the model class for table "tbl_user".
 *
 * @property string $id
 * @property boolean $superadmin
 * @property integer $status
 * @property string $email
 * @property string $new_email
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $api_key
 * @property string $login_ip
 * @property string $login_time
 * @property string $create_ip
 * @property string $create_time
 * @property integer $updated_time
 * @property string  $ban_time
 * @property string  $ban_reason
 * @property integer $permanent_session
 * @property integer $active
 *
 * @property Profile   $profile
 * @property Role[]      $roles
 * @property Role      $commonRole
 * @property UserKey[] $userKeys
 * @property UserAuth[] $userAuths
 * @property Sessions[] $sessions
 */
class User extends UserIdentity
{

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 0;
    const STATUS_BANNED = -1;

    const SCENARIO_NEW_USER = 'newUser';

    /**
     * @var string
     */
    public $gridRoleSearch;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $repeat_password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Yii::$app->miranda->user_table;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['username', 'unique'],
            [['username', 'email', 'bind_to_ip'], 'trim'],
            [['status'], 'integer'],
            [['superadmin', 'email_confirmed'], 'boolean'],
            [['superadmin'], 'default', 'value' => false],
            [['email_confirmed'], 'default', 'value' => false],
            ['email', 'email'],
            ['email', 'validateEmailUnique'],
            ['bind_to_ip', 'validateBindToIp'],
            ['bind_to_ip', 'string', 'max' => 255],
            ['password', 'required', 'on' => [self::SCENARIO_NEW_USER, 'changePassword']],
            ['password', 'string', 'max' => 255, 'on' => [self::SCENARIO_NEW_USER, 'changePassword']],
            ['password', 'string', 'min' => 6, 'on' => [self::SCENARIO_NEW_USER, 'changePassword']],
            ['password', 'trim', 'on' => [self::SCENARIO_NEW_USER, 'changePassword']],
            ['repeat_password', 'required', 'on' => [self::SCENARIO_NEW_USER, 'changePassword']],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * Store result in session to prevent multiple db requests with multiple calls
     *
     * @param bool $fromSession
     *
     * @return static
     */
    public static function getCurrentUser($fromSession = true)
    {
        if (!$fromSession) {
            return static::findOne(Yii::$app->user->id);
        }

        $user = Yii::$app->session->get('__currentUser');

        if (!$user) {
            $user = static::findOne(Yii::$app->user->id);

            Yii::$app->session->set('__currentUser', $user);
        }

        return $user;
    }

    public function getLanguage()
    {

        $profile = $this->profile;
        $language = Yii::$app->miranda->defaultLanguage;


        if (!empty($profile->language)){

            $language = $profile->language;
        }

        return $language;

    }

    public function getShortLanguageCode()
    {

        $profile = $this->profile;
        $language = Yii::$app->miranda->defaultLanguage;


        if (!empty($profile->language)){

            $language = $profile->language;
        }

        $language = explode('-', $language);

        return $language[0];

    }

    /**
     * Assign role to user
     *
     * @param int $userId
     * @param string $roleName
     *
     * @return bool
     */
    public static function assignRole($userId, $roleName)
    {
        try {
            Yii::$app->db->createCommand()
                    ->insert(Yii::$app->miranda->auth_assignment_table, [
                        'user_id' => $userId,
                        'item_name' => $roleName,
                        'created_at' => time(),
                    ])->execute();

            AuthHelper::invalidatePermissions();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Assign roles to user
     *
     * @param int $userId
     * @param array $roles
     *
     * @return bool
     */
    public function assignRoles(array $roles)
    {
        foreach ($roles as $role) {
            User::assignRole($this->id, $role);
        }
    }

    /**
     * Revoke role from user
     *
     * @param int $userId
     * @param string $roleName
     *
     * @return bool
     */
    public static function revokeRole($userId, $roleName)
    {
        $result = Yii::$app->db->createCommand()
                        ->delete(Yii::$app->miranda->auth_assignment_table, ['user_id' => $userId, 'item_name' => $roleName])
                        ->execute() > 0;

        if ($result) {
            AuthHelper::invalidatePermissions();
        }

        return $result;
    }

    /**
     * @param string|array $roles
     * @param bool $superAdminAllowed
     *
     * @return bool
     */
    public static function hasRole($roles, $superAdminAllowed = true)
    {
        if ($superAdminAllowed AND Yii::$app->user->isSuperAdmin) {
            return true;
        }
        $roles = (array) $roles;

        AuthHelper::ensurePermissionsUpToDate();

        return array_intersect($roles, Yii::$app->session->get(AuthHelper::SESSION_PREFIX_ROLES, [])) !== [];
    }

    /**
     * @param string $permission
     * @param bool $superAdminAllowed
     *
     * @return bool
     */
    public static function hasPermission($permission, $superAdminAllowed = true)
    {
        if ($superAdminAllowed AND Yii::$app->user->isSuperAdmin) {
            return true;
        }

        AuthHelper::ensurePermissionsUpToDate();

        return in_array($permission, Yii::$app->session->get(AuthHelper::SESSION_PREFIX_PERMISSIONS, []));
    }

    /**
     * Useful for Menu widget
     *
     * <example>
     *    ...
     *        [ 'label'=>'Some label', 'url'=>['/site/index'], 'visible'=>User::canRoute(['/site/index']) ]
     *    ...
     * </example>
     *
     * @param string|array $route
     * @param bool $superAdminAllowed
     *
     * @return bool
     */
    public static function canRoute($route, $superAdminAllowed = true)
    {
        if ($superAdminAllowed AND Yii::$app->user->isSuperAdmin) {
            return true;
        }

        $baseRoute = AuthHelper::unifyRoute($route);

        if (substr($baseRoute, 0, 4) === "http") {
            return true;
        }

        if (Route::isFreeAccess($baseRoute)) {
            return true;
        }

        AuthHelper::ensurePermissionsUpToDate();

        return Route::isRouteAllowed($baseRoute, Yii::$app->session->get(AuthHelper::SESSION_PREFIX_ROUTES, []));
    }

    /**
     * getStatusList
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('miranda', 'Active'),
            self::STATUS_INACTIVE => Yii::t('miranda', 'Inactive'),
            self::STATUS_BANNED => Yii::t('miranda', 'Banned'),
        ];
    }


    /**
     * getUsersList
     *
     * @return array
     */
    public static function getUsersList()
    {
        $users = static::find()->select(['id', 'username'])->asArray()->all();
        return ArrayHelper::map($users, 'id', 'username');
    }

    /**
     * getStatusValue
     *
     * @param string $val
     *
     * @return string
     */
    public static function getStatusValue($val)
    {
        $ar = self::getStatusList();

        return isset($ar[$val]) ? $ar[$val] : $val;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Check that there is no such confirmed E-mail in the system
     */
    public function validateEmailUnique()
    {
        if ($this->email) {
            $exists = User::findOne(['email' => $this->email]);

            if ($exists AND $exists->id != $this->id) {
                $this->addError('email', Yii::t('miranda', 'This e-mail already exists'));
            }
        }
    }

    /**
     * Validate bind_to_ip attr to be in correct format
     */
    public function validateBindToIp()
    {
        if ($this->bind_to_ip) {
            $ips = explode(',', $this->bind_to_ip);

            foreach ($ips as $ip) {
                if (!filter_var(trim($ip), FILTER_VALIDATE_IP)) {
                    $this->addError('bind_to_ip', Yii::t('miranda', "Wrong format. Enter valid IPs separated by comma"));
                }
            }
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('miranda', 'ID'),
            'username' => Yii::t('miranda', 'Username'),
            'superadmin' => Yii::t('miranda', 'Super Administrator'),
            'confirmation_token' => Yii::t('miranda', 'Confirmation Token'),
            'registration_ip' => Yii::t('miranda', 'Registration IP'),
            'bind_to_ip' => Yii::t('miranda', 'Bind to IP'),
            'status' => Yii::t('miranda', 'Status'),
            'gridRoleSearch' => Yii::t('miranda', 'Roles'),
            'created_at' => Yii::t('miranda', 'Created'),
            'updated_at' => Yii::t('miranda', 'Updated'),
            'password' => Yii::t('miranda', 'Password'),
            'repeat_password' => Yii::t('miranda', 'Repeat password'),
            'email_confirmed' => Yii::t('miranda', 'E-mail confirmed'),
            'email' => Yii::t('miranda', 'E-mail'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(Role::className(), ['name' => 'item_name'])
                        ->viaTable(Yii::$app->miranda->auth_assignment_table, ['user_id' => 'id']);
    }

    /**
     * Make sure user will not deactivate himself and superadmin could not demote himself
     * Also don't let non-superadmin edit superadmin
     *
     * @inheritdoc
     */
    public function beforeSave($insert)
    {

        if ($insert) {
            if (php_sapi_name() != 'cli') {
                $this->registration_ip = MirandaHelper::getRealIp();
            }
            $this->generateAuthKey();
        } else {
            // Console doesn't have Yii::$app->user, so we skip it for console
            if (php_sapi_name() != 'cli') {
                if (Yii::$app->user->id == $this->id) {
                    // Make sure user will not deactivate himself
                    $this->status = static::STATUS_ACTIVE;

                    // superadmin could not demote himself
                    if (Yii::$app->user->isSuperAdmin AND $this->superadmin != 1) {
                        $this->superadmin = 1;
                    }
                }

                // Don't let non-superadmin edit superadmin
                if (!Yii::$app->user->isSuperAdmin AND $this->oldAttributes['superadmin'] == 1
                ) {
                    return false;
                }
            }
        }

        // If password has been set, than create password hash
        if ($this->password) {
            $this->setPassword($this->password);
        }

        return parent::beforeSave($insert);
    }

    /**
     * Don't let delete yourself and don't let non-superadmin delete superadmin
     *
     * @inheritdoc
     */
    public function beforeDelete()
    {
        // Console doesn't have Yii::$app->user, so we skip it for console
        if (php_sapi_name() != 'cli') {
            // Don't let delete yourself
            if (Yii::$app->user->id == $this->id) {
                return false;
            }

            // Don't let non-superadmin delete an superadmin
            if (!Yii::$app->user->isSuperAdmin) {
                return false;
            }
        }

        return parent::beforeDelete();
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Get created date
     *
     * @return string
     */
    public function getCreatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at);
    }

    /**
     * Get created date
     *
     * @return string
     */
    public function getUpdatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->updated_at);
    }

    /**
     * Get created time
     *
     * @return string
     */
    public function getCreatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->updated_at);
    }

    /**
     * Get created time
     *
     * @return string
     */
    public function getUpdatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->updated_at);
    }

    /**
     * Get created datetime
     *
     * @return string
     */
    public function getCreatedDatetime()
    {
        return "{$this->createdDate} {$this->createdTime}";
    }

    /**
     * Get created datetime
     *
     * @return string
     */
    public function getUpdatedDatetime()
    {
        return "{$this->updatedDate} {$this->updatedTime}";
    }

}
