<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Menu is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Menu extends ActiveRecord
{

	/**
	 * 返回指定表名
	 * @return [type] [description]
	 */
    public static function tableName()
    {
        return '{{%menu}}';
    }




	//获取所有父类菜单数据
	public static function getFatherMenuList()
	{
		//查询所有父类菜单
		$father = static::find()->where("menu_parent_id = 0")->asArray()->all();
		return $father;
	}

	/**
	 * 获取所有子类菜单
	 * @return [type] [description]
	 */
	public static function getSonMenuList(){
		//查询所有子类菜单
		$son = static::find()->where("menu_parent_id != 0")->asArray()->all();
		return $son;
	}

	/**
	 * 获取单条菜单信息
	 * @param  [type] $menu_id [description]
	 * @return [type]          [description]
	 */
	public static function getOneDataByMenuID($menu_id){
		$res = static::find()->where("menu_id = :id",[':id'=>$menu_id])->asArray()->one();
		return $res;
	}

	/**
	 * 编辑单条菜单信息
	 * @param  [type] $menu_id     [description]
	 * @param  [type] $menu_name   [description]
	 * @param  [type] $menu_status [description]
	 * @return [type]              [description]
	 */
	public static function updateOneMenuInfo($menu_id,$menu_name,$menu_status){
		$res = static::updateAll(array('menu_name'=>$menu_name,'menu_status'=>$menu_status,'update_time'=>date('Y-m-d H:i:s')),'menu_id = :id',array(':id'=>$menu_id));
		return $res;
	}
}