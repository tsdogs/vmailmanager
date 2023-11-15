<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ChangepasswordForm extends Model
{
    public $currentpassword;
    public $newpassword;
    public $confirmpassword;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['currentpassword', 'newpassword', 'confirmpassword',], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'currentpassword' => 'Current password',
            'newpassword' => 'New password',
            'confirmpassword' => 'Confirm new password',
        ];
    }
    
    public function beforeValidate()
    {
        if (Yii::$app->user->identity->validatePassword($this->currentpassword)) {
            $this->addError('currentpassword',Yii::t('app','Current password is wrong'));
        }
        if ($this->newpassword!=$this->confirmpassword) {
            $this->addError('confirmpassword',Yii::t('app','New password do not match!'));
        }
        return parent::beforeValidate();
    }

}
