<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * ContactForm is the model behind the contact form.
 */
class AdminPower extends ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_power';
    }


    /**
     * 获取所有角色信息
     * @return [type] [description]
     */
    public static function getAllPowerData(){
    	$res = static::find()->asArray()->all();
    	return $res;
    }

}