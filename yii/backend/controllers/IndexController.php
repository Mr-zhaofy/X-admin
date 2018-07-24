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
class IndexController extends Controller
{
	//关闭默认布局layout
	public $layout = false;
	//关闭post请求的CSRF验证拦截
	public $enableCsrfValidation=false;

	public function actionIndex(){

		return $this->render('index');
	}


	public function actionEmail(){
		$mail= Yii::$app->mailer->compose();  
		// var_dump($mail);die;
		$mail->setTo('1484890382@qq.com'); //要发送给那个人的邮箱   

		$mail->setSubject("李狗蛋,请看朕赐你的邮件"); //邮件主题   

		$mail->setTextBody('李狗蛋,请看朕赐你的邮件'); //发布纯文字文本   

		$mail->setHtmlBody("李狗蛋,你就是个王八蛋"); //发送的消息内容   

		var_dump($mail->send());
	}
}
