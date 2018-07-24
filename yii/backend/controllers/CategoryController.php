<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Menu;
use yii\data\Pagination;
use yii\web\UploadedFile;
/**
 * Site controller
 */
class CategoryController extends Controller
{
	//关闭默认布局layout
	public $layout = false;
	//关闭post请求的CSRF验证拦截
	public $enableCsrfValidation=false;

	public function actionCategory_list(){
		//获取所有分类
		$father = Menu::getFatherMenuList();
		$son = Menu::getSonMenuList();
		foreach($father as $key=>&$val){
			foreach($son as $k=>&$v){
				if($v['menu_parent_id'] == $val['menu_id']){
					$father[$key]['son'][$k] = $v;
				}else{
					continue;
				}
			}
		}
		return $this->render('cate_list',['menu'=>$father,'count'=>count($father)+count($son)]);
	}

	/**
	 * 渲染编辑页面
	 * @return [type] [description]
	 */
	public function actionMenu_edit(){
		$menu_id = Yii::$app->request->get('menu_id');
		//根据menu_id查询单个菜单信息
		$info = Menu::getOneDataByMenuID($menu_id);

		return $this->render('menu_edit',['info'=>$info]);
	}

	/**
	 * 执行编辑入库
	 * @return [type] [description]
	 */
	public function actionMenu_execute_edit(){
		$menu_name = Yii::$app->request->post('menu_name');
		$menu_id = Yii::$app->request->post('menu_id');
		$menu_status = Yii::$app->request->post('menu_status');
		$res = Menu::updateOneMenuInfo($menu_id,$menu_name,$menu_status);
		if($res){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 渲染添加子类菜单页面
	 * @return [type] [description]
	 */
	public function actionMenu_son_add(){

		$menu_id = Yii::$app->request->get('menu_id');
		//根据menu_id查询单个菜单信息
		$info = Menu::getOneDataByMenuID($menu_id);
		return $this->render('add_son_menu',['info'=>$info]);
	}

	/**
	 * 执行添加入库
	 * @return [type] [description]
	 */
	public function actionMenu_add_son(){
		$data = Yii::$app->request->post();
		$model = new Menu();
		$model->menu_name = $data['menu_name'];
		$model->menu_parent_id = $data['menu_parent_id'];
		$model->menu_status = $data['menu_status'];
		$model->add_time = date('Y-m-d H:i:s');
		if($model->save()){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 添加父级菜单入库
	 * @return [type] [description]
	 */
	public function actionAdd_parent_menu(){
		$menu_name = Yii::$app->request->post('menu_name');
		//判断是否为空
		if( !$menu_name){
			echo "<script>alert('菜单名称不能为空');location.href='/category/category_list'</script>";
			return false;
		}
		$model = new Menu();
		$model->menu_name = $menu_name;
		$model->menu_parent_id = 0;
		$model->menu_status = 1;
		$model->add_time = date('Y-m-d H:i:s');
		if($model->save()){
			return $this->redirect('/category/category_list');
		}else{
			return false;
		}
	}
}