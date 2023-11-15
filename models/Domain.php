<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "{{%domain}}".
 *
 * @property int $id
 * @property string $domain
 * @property string $destination
 * @property string|null $description
 * @property int|null $aliases
 * @property int|null $mailboxes
 * @property int|null $quota
 * @property int|null $active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Account[] $accounts
 * @property AdminDomain[] $adminDomains
 * @property Alias[] $aliases0
 */
class Domain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%domain}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain', ], 'required'],
            [['domain', ], 'required', 'on'=>'alias'],
            [['aliases', 'mailboxes', 'quota', 'active', 'created_at', 'updated_at'], 'integer'],
            [['domain', 'destination', 'description'], 'string', 'max' => 250],
            [['domain'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'domain' => Yii::t('app', 'Domain'),
            'destination' => Yii::t('app', 'Destination'),
            'description' => Yii::t('app', 'Description'),
            'aliases' => Yii::t('app', 'Aliases'),
            'mailboxes' => Yii::t('app', 'Mailboxes'),
            'quota' => Yii::t('app', 'Quota'),
            'active' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    public function beforeSave($insert)
    {
        if ($this->destination=='') {
            $this->destination = $model->domain;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['domain' => 'domain']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminDomains()
    {
        return $this->hasMany(AdminDomain::className(), ['domain' => 'domain','domain'=>'destination']);
    }

    public function getAdmins()
    {
        return $this->hasMany(AdminDomain::className(), ['domain' => 'domain'],['admin_id'=>Yii::$app->user->id]);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAliases()
    {
        return $this->hasMany(Alias::className(), ['domain' => 'domain']);
    }
    
    public function canUpdate()
    {
        if (Yii::$app->user->isGuest) return false;
        
        if (Yii::$app->user->identity->isMaster) return true;
        
        if (Yii::$app->user->identity->isAdmin) {
            if (count($this->admins)>0) {
                return true;
            }
        }
        return false;
    }
}
