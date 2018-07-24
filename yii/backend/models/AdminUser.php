<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * ContactForm is the model behind the contact form.
 */
class AdminUser extends ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user';
    }


	public static function checkAdminInfo($username,$password){
		if( !$username || !$password){
			return '用户名或密码信息有误,请重新输入';
		}
		//根据用户名和密码查询信息
		$info = static::find()->where("admin_username = :name and admin_password = :pass",[':name'=>$username,':pass'=>$password])->asArray()->one();
		
		return $info;
	}

	/**
	 * 获取所有管理员信息数据
	 * @return [type] [description]
	 */
	public static function getAllAdminUserData(){
		$res = static::find()->select('*')->innerJoin('admin_role','admin_user.admin_role_id=admin_role.role_id')->asArray()->all();
		return $res;
	}

	/**
	 * 根据ID删除单条记录
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public static function deleteAdminUserByID($id){
		$res = static::findOne($id)->delete();
		return $res;
	}

	/**
	 * 获取某条admin信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public static function getOneDataByAdminID($id){
		$res = static::find()->where("admin_id = :id",[':id'=>$id])->asArray()->one();
		return $res;
	}

	/**
	 * 修改密码
	 * @param  [type] $newpass [description]
	 * @param  [type] $id      [description]
	 * @return [type]          [description]
	 */
	public static function updatePassword($newpass,$id){
		$res = static::updateAll(array('admin_password'=>MD5($newpass)),'admin_id = :id',array(':id'=>$id));
		return $res;
	}

	/**
	 * 批量删除
	 * @param  [type] $post [description]
	 * @return [type]       [description]
	 */
	public static function deleteUserInCheckID($post){
		$ids = implode(',',$post);
		$res = static::deleteAll("admin_id in ($ids)");
		return $res;
	}

	public static function getSearchResultByName($name){
		$res = static::find()->select('*')->innerJoin('admin_role','admin_user.admin_role_id=admin_role.role_id')->where("admin_user.admin_username = :name",[':name'=>$name])->asArray()->one();
		return $res;
	}
}
