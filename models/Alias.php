<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;


use Yii;

/**
 * This is the model class for table "alias".
 *
 * @property int $id
 * @property string|null $username
 * @property string $domain
 * @property string|null $destination
 * @property int|null $active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Domain $domain0
 */
class Alias extends \yii\db\ActiveRecord
{
    //public $destinations;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['domain', 'username', 'destination'], 'required'],
            [['active', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 100],
            [['domain'], 'string', 'max' => 250],
            [['destination'],'email'],
            [['destination'], 'string', 'max' => 255],
            [['username', 'domain', 'destination'], 'unique', 'targetAttribute' => ['username', 'domain', 'destination']],
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
            'username' => Yii::t('app', 'Username'),
            'domain' => Yii::t('app', 'Domain'),
            'destination' => Yii::t('app', 'Destination'),
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
    
    public function getDestinations()
    {
        return $this->hasMany(Alias::className(), ['username'=>'username','domain'=>'domain']);
        
        $result = [];
        foreach (Alias::find()->where(['username'=>$this->username,'domain'=>$this->domain])->all() as $a) {
            $result[] = $a->destination;
        }
        return $result;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDomain()
    {
        return $this->hasOne(Domain::className(), ['domain' => 'domain']);
    }
}
