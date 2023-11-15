<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_domain".
 *
 * @property int $id
 * @property int $admin_id
 * @property string $domain
 * @property int|null $active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Admin $admin
 * @property Domain $domain0
 */
class AdminDomain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_domain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin_id', 'domain', 'created_at', 'updated_at'], 'required'],
            [['admin_id', 'active', 'created_at', 'updated_at'], 'integer'],
            [['domain'], 'string', 'max' => 250],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::className(), 'targetAttribute' => ['admin_id' => 'id']],
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
            'admin_id' => Yii::t('app', 'Admin ID'),
            'domain' => Yii::t('app', 'Domain'),
            'active' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'admin_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomain0()
    {
        return $this->hasOne(Domain::className(), ['domain' => 'domain']);
    }
}
