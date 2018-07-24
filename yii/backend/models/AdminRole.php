<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * ContactForm is the model behind the contact form.
 */
class AdminRole extends ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_role';
    }


    /**
     * 获取所有角色信息
     * @return [type] [description]
     */
    public static function getAllRoleData(){
    	$res = static::find()->asArray()->all();
    	return $res;
    }

    /**
     * 获取具体的角色信息
     * @param  [type] $role_id [description]
     * @return [type]          [description]
     */
    public static function getOneRoleDataByID($role_id){
    	$res = static::find()->where("role_id = :id",[':id'=>$role_id])->asArray()->one();
    	return $res;
    }

    /**
     * 删除单条记录
     * @param  [type] $role_id [description]
     * @return [type]          [description]
     */
    public static function deleteOneRoleByID($role_id){
        $res = static::findOne($role_id)->delete();
        return $res;
    }
}