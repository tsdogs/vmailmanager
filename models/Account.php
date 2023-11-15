<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "account".
 *
 * @property int $id
 * @property string $username
 * @property string $domain
 * @property string $password
 * @property string|null $name
 * @property int|null $quota
 * @property int|null $send
 * @property int|null $receive
 * @property int|null $calendar
 * @property int|null $active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Domain $domain0
 * @property Admin $admin
 */
class Account extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    public $newpassword;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'domain', 'password', ], 'required'],
            [['newpassword'],'required','on'=>'insert'],
            [['quota', 'send', 'receive', 'calendar', 'password_expireson', 'password_renewtime', 
                'active', 'created_at', 'updated_at', 'last_login'], 'integer'],
            [['password_expired'],'boolean'],
            [['last_login_ip'],'string', 'max'=>50],
            [['username'], 'string', 'max' => 100],
            [['domain'], 'string', 'max' => 250],
            [['password','newpassword'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 200],
            [['username', 'domain'], 'unique', 'targetAttribute' => ['username', 'domain']],
            [['domain'], 'exist', 'skipOnError' => true, 'targetClass' => Domain::className(), 'targetAttribute' => ['domain' => 'domain']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Email'),
            'domain' => Yii::t('app', 'Domain'),
            'password' => Yii::t('app', 'Password'),
            'newpassword' => Yii::t('app', 'Password'),
            'name' => Yii::t('app', 'Name'),
            'quota' => Yii::t('app', 'Quota'),
            'send' => Yii::t('app', 'Send'),
            'receive' => Yii::t('app', 'Receive'),
            'calendar' => Yii::t('app', 'Calendar'),
            'active' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'password_expireson' => Yii::t('app', 'Password expiration date'),
            'password_renewtime' => Yii::t('app', 'Password expire after (days)'),
            'password_expired' => Yii::t('app', 'Force password change on next login'),
            'last_login' => Yii::t('app', 'Last login'),
            'last_login_ip' => Yii::t('app', 'Last login IP'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomain()
    {
        return $this->hasOne(Domain::className(), ['domain' => 'domain']);
    }

    
    public function getEmail()
    {
        return $this->username.'@'.$this->domain;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'id']);
    }
    
    public function beforeValidate()
    {
        if ($this->newpassword!='') {
            $salt = substr(sha1(rand()), 0, 16);
            $this->password = "{SHA512-CRYPT}" . crypt($this->newpassword, "$6$$salt");;
        }
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        if ($insert) {
            if ($this->name=='')
                $this->name = $this->username;
            if ($this->password_renewtime!=null) {
                $this->password_expireson = strtotime('today + '.$this->password_renewtime.' days');
            }
        } else {
            if ($this->isAttributeChanged('password_renewtime')) {
                if ($this->password_renewtime==null) {
                    $this->password_expireson=null; // o mettiamo il 2999 ?
                } else if ($this->getOldAttribute('password_expireson')==null) {
                    $this->password_expireson = strftime('today + '.$this->password_renewtime.' days');
                }
            }
            if ($this->isAttributeChanged('password') && $this->password_renewtime!=null) {
                $this->password_expireson = strtotime('today + '.$this->password_renewtime.' days');
            }
        }
        
        return parent::beforeSave($insert);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'active' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $x = explode('@',$username);
        return static::findOne(['username' => $x[0],'domain'=>$x[1], 'active' => self::STATUS_ACTIVE]);
    }


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return (crypt($password, str_replace('{SHA512-CRYPT}','',$this->password)) 
                == str_replace('{SHA512-CRYPT}','',$this->password));
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $salt = substr(sha1(rand()), 0, 16);
        $this->password = "{SHA512-CRYPT}" . crypt($password, "$6$$salt");;

    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }
    
    
    public function getIsAdmin()
    {
        return $this->admin != null;
    }
    
    public function getIsMaster()
    {
        if ($this->isAdmin) {
            return $this->admin->master==1;
        }
        return false;
    }
    
    public function getAdminDomains()
    {
        return $this->hasMany(AdminDomain::className(),['admin_id'=>'id'],['active'=>1]);
    }
    
    public function getDomains()
    {
        if ($this->isAdmin) {
            if ($this->isMaster) {
                // tutti i domini
                return Domain::find()->all();
            } else {
                return Domain::find()->joinWith('adminDomains')->where(['admin_domain.admin_id'=>$this->id])->all();
            }
        }
        return [];
    }
    
}
