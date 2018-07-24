<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\AdminUser;
/**
 * Site controller
 */
class LoginController extends Controller
{

	//关闭默认布局layout
	public $layout = false;
	//关闭post请求的CSRF验证拦截
	public $enableCsrfValidation=false;

	/**
	 * 渲染登录页面
	 * @return [type] [description]
	 */
	public function actionIndex(){

		return $this->render('login');
	}

	/**
	 * 验证登录
	 * @return [type] [description]
	 */
	public function actionLogin(){

		$request = Yii::$app->request;
		//获取用户名
		$username = $request->post('username');
		//获取密码
		$password = $request->post('password');
		//根据用户名和密码验证
		$result = AdminUser::checkAdminInfo($username,MD5($password));
		//判断查询结果
		if( empty($result)){
			return "非法信息!";
		}
		//存储session
		Yii::$app->session['username'] = $username ;
		Yii::$app->session['password'] = $password ;

		return $this->redirect(array('index/index'));
	}
}