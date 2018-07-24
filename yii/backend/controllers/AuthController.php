<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\AdminUser;
use backend\models\AdminRole;
use backend\models\AdminPower;
use backend\models\AdminRolePower;
/**
 * Site controller
 */
class AuthController extends Controller
{
	//关闭默认布局layout
	public $layout = false;
	//关闭post请求的CSRF验证拦截
	public $enableCsrfValidation=false;

	/**
	 * 管理员列表
	 * @return [type] [description]
	 */
	public function actionAdmin_list(){
		//获取所有管理员数据信息
		$list = AdminUser::getAllAdminUserData();
		return $this->render('admin_list',['data'=>$list,'count'=>count($list)]);
	}

	/**
	 * 管理员列表---删除
	 * @return [type] [description]
	 */
	public function actionAdmin_list_del(){
		$id = Yii::$app->request->post('id');
		$res = AdminUser::deleteAdminUserByID($id);
		if($res){
			return 1;
		}else{
			return 0;
		}
	}

	/**
	 * 管理员添加页面
	 * @return [type] [description]
	 */
	public function actionAdmin_add(){
		//查询所有角色
		$role = AdminRole::getAllRoleData();
		return $this->render('admin_add',['role'=>$role]);
	}

	/**
	 * 添加入库
	 * @return [type] [description]
	 */
	public function actionExecute_admin_add(){
		$post = Yii::$app->request->post();
		//添加入库
		$model = new AdminUser;
		$model->admin_username = $post['username'];
		$model->admin_password = MD5($post['password']);
		$model->admin_email    = $post['email'];
		$model->admin_status   = 1;
		$model->admin_role_id  = $post['role'];
		$model->add_time       = date('Y-m-d H:i:s');
		if($model->save()){
			return true;
		}else{
			return false;
		}
	}


	/**
	 * 列表--批量删除
	 * @return [type] [description]
	 */
	public function actionBatch_delete(){
		//接收要删除的id
		$post = Yii::$app->request->post();
		// print_r($post);die;
		//根据id批量删除
		$res = AdminUser::deleteUserInCheckID($post);
		if($res){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 渲染修改密码页面
	 * @return [type] [description]
	 */
	public function actionModify_pass(){
		//获取id
		$id = Yii::$app->request->get('id');
		//根据id查询该数据信息
		$info = AdminUser::getOneDataByAdminID($id);
		return $this->render('modify_pass',['info'=>$info]);
	}

	/**
	 * 执行修改密码入库
	 * @return [type] [description]
	 */
	public function actionExecute_modify_pass(){
		$oldpass = Yii::$app->request->post('oldpass');  	//旧密码
		$newpass = Yii::$app->request->post('newpass');		//新密码
		$repass  = Yii::$app->request->post('repass'); 		//确认密码
		$pass    = Yii::$app->request->post('pass');		//原来加密的密码
		$id      = Yii::$app->request->post('id');
		if( MD5($oldpass) != $pass){
			echo "<script>alert('旧密码输入错误');location.href='/auth/modify_pass?id=$id'</script>";
			return false;
		}
		if( $newpass != $repass){
			echo "<script>alert('两次密码输入不同,请重新输入');location.href='/auth/modify_pass?id=$id'</script>";
			return false;
		}
		//验证通过更新密码
		$res = AdminUser::updatePassword($newpass,$id);
		if($res){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 渲染管理员编辑页面
	 * @return [type] [description]
	 */
	public function actionAdmin_list_edit(){
		//获取id
		$id = Yii::$app->request->get('id');
		//根据id查询该数据信息
		$info = AdminUser::getOneDataByAdminID($id);
		return $this->render('admin_edit',['info'=>$info]);
	}


	public function actionAdmin_user_search(){
		$name = Yii::$app->request->post('username');
		//根据获取的name去表中搜索
		$res = AdminUser::getSearchResultByName($name);
		return json_encode($res);
	}

	/**
	 * 获取角色列表
	 * @return [type] [description]
	 */
	public function actionRole_manage_list(){
		//获取角色列表
		$data = AdminRole::getAllRoleData();
		
		return $this->render('admin_role',['data'=>$data,'count'=>count($data)]);
	}


	public function actionRole_delete(){
		$role_id = Yii::$app->request->post('role_id');
		//删除
		$res = AdminRole::deleteOneRoleByID($role_id);
		if($res){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 权限分类列表
	 * @return [type] [description]
	 */
	public function actionAuthority_cate(){
		//获取权限列表
		$power = AdminPower::getAllPowerData();

		return $this->render('admin_power',['data'=>$power,'count'=>count($power)]);
	}

	/**
	 * 权限管理
	 * @return [type] [description]
	 */
	public function actionAuthority_manage(){
		//查询所有管理员
		$admin = AdminUser::getAllAdminUserData();
		//查询所有角色
		$role = AdminRole::getAllRoleData();
		//查询所有权限
		$power = AdminPower::getAllPowerData();
		
		return $this->render('admin_manage',['admin'=>$admin,'role'=>$role,'power'=>$power]);
	}


	/**
	 * 给角色配置权限
	 * @return [type] [description]
	 */
	public function actionConfig_power(){
		$role_id = Yii::$app->request->get('role_id');
		//根据role_id查询当前角色
		$roleData = AdminRole::getOneRoleDataByID($role_id);
		//查询所有权限
		$power = AdminPower::getAllPowerData();

		return $this->render('config_power',['roleInfo'=>$roleData,'power'=>$power]);
	}


	public function actionExecute_role_power(){
		//获取post过来的数据
		$post = Yii::$app->request->post();
		//把权限id转成数组
		$power_array = explode(',', $post['power']);
		// print_r($power_array);die;
		//存到role_power表中
		for ($i=0; $i < count($power_array) ; $i++) { 
			$model = new AdminRolePower;
			$model->role_id = $post['role_id'];
			$model->power_id = $power_array[$i];
			$model->save();
		}

		return true;
	}
	/***********************
	*  (1) 管理员列表  √
	*  (2) 角色列表
	*  (3) 权限列表
	*  (4) 模块列表
	************************/
}