<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\News;
use backend\models\Menu;
use yii\data\Pagination;
use yii\web\UploadedFile;
/**
 * Site controller
 */
class ArticleController extends Controller
{
	//关闭默认布局layout
	public $layout = false;
	//关闭post请求的CSRF验证拦截
	public $enableCsrfValidation = false;
	

	/**
	 * 文章列表
	 * @return [type] [description]
	 */
	public function actionArticle_list(){
		//model查询
		$data = News::find();
		//分页配置
		$pages = new Pagination(['totalCount'=>$data->count(),'pageSize'=>'5']);
		//获取总数
		$count = $data->count();
		//分页查询
		$page_data = $data->where("news_status != 2")->offset($pages->offset)->limit($pages->limit)->all();
		//渲染页面传值
		return $this->render('article_list',['listData'=>$page_data,'count'=>$count,'pages' => $pages]);
	}

	/**
	 * 渲染文章添加页面
	 * @return [type] [description]
	 */
	public function actionAdd_article(){
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
		return $this->render('add_article',['menu'=>$father]);
	}

	/**
	 * 执行添加文章操作
	 * @return [type] [description]
	 */
	public function actionExecute_add(){
		//接收post数据
		$request = Yii::$app->request;
		$data = $request->post();
		//图片上传
		if( $_FILES['files']['error']){
			echo $_FILES['files']['error'];
		}else{
			//判断上传文件类型
			if(($_FILES["files"]["type"]=="image/png"||$_FILES["files"]["type"]=="image/jpeg") && $_FILES["files"]["size"] < 1024000){
				//防止文件名重复
				$filename = './upload/'.date('Ymd').$_FILES['files']['name'];
				//转码
				$filename =iconv("UTF-8","gb2312",$filename);
				// echo $filename;die;
				//检查文件或目录是否存在
				if( file_exists($filename)){
					echo "该文件已存在";
				}else{
					//保存文件
					move_uploaded_file($_FILES["files"]["tmp_name"],$filename);
					$news = new News();
					$news->news_title 	   = $data['title'];
					$news->news_img   	   = date('Ymd').$_FILES['files']['name'];
					$news->news_desc  	   = $data['desc'];
					$news->news_label 	   = $data['label'];
					$news->news_type  	   = $data['type'];
					$news->news_link       = $data['link'];
					$news->news_browse_num = 0 ;
					$news->is_recommend    = 1;
					$news->add_time        = date('Y-m-d H:i:s');
					if($news->save()){
						return true;
					}else{
						return false;
					}
				}
			}else{
				echo "文件格式错误";
			}
		}
	}

	/**
	 * 文章列表---删除
	 * @return [type] [description]
	 */
	public function actionArticle_delete(){
		$request = Yii::$app->request;
		$news_id = $request->get('news_id');
		//删除文章
		$res = News::getDelDataInfo($news_id);
		if($res){
			return $this->redirect('/article/article_list');
		}else{
			return 0;
		}
	}

	/**
	 * 停用/启用
	 * @return [type] [description]
	 */
	public function actionArticle_enable(){
		//文章id
		$news_id = Yii::$app->request->get('news_id');
		//状态
		$enable_val = Yii::$app->request->get('val');
		//更新状态
		$res = News::SaveNewsStatus($news_id,$enable_val);
		if( $res){
			return $this->redirect('/article/article_list');
		}else{
			return 0;
		}
	}

	/**
	 * 渲染编辑页面
	 * @return [type] [description]
	 */
	public function actionArticle_edit(){
		$news_id = Yii::$app->request->get('news_id');
		//根据当前id查询该文章信息
		$info = News::getOneArticleData($news_id);
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
		return $this->render('article_edit',['data'=>$info,'menu'=>$father]);
	}


	public function actionExecute_edit(){
		//接收post数据
		$request = Yii::$app->request;
		$datas = $request->post();
		$news_id = $datas['news_id'];
		//判断是否上传图片
		$file_name = $_FILES['files']['name'];
		if( empty($file_name)){
			//没有修改图片,直接更新其他字段
			$res = News::updateOtherInfo($datas,$news_id);
			if($res){
				return true;
			}else{
				return false;
			}
		}else{
			//从新上传图片,全部更新
			if(($_FILES["files"]["type"]=="image/png"||$_FILES["files"]["type"]=="image/jpeg") && $_FILES["files"]["size"] < 1024000){
				//防止文件名重复
				$filename = './upload/'.date('Ym').$_FILES['files']['name'];
				//转码
				$filename =iconv("UTF-8","gb2312",$filename);
				// echo $filename;die;
				//检查文件或目录是否存在
				if( file_exists($filename)){
					echo "该文件已存在";
				}else{
					$res = News::updateImgInfo($datas,$news_id,$file_name);
					if($res){
						return true;
					}else{
						return false;
					}
				}
			}
		}
	}
	/**
	 * 文章删除列表
	 * @return [type] [description]
	 */
	public function actionArticle_del(){
		//model查询
		$data = News::find()->where("news_status = 2");
		//分页配置
		$pages = new Pagination(['totalCount'=>$data->count(),'pageSize'=>'5']);
		//获取总数
		$count = $data->count();
		//分页查询
		$page_data = $data->where("news_status = 2")->offset($pages->offset)->limit($pages->limit)->all();
		//渲染页面传值
		return $this->render('article_del_list',['listData'=>$page_data,'count'=>$count,'pages' => $pages]);
	}

	/**
	 * 删除列表--数据恢复
	 * @return [type] [description]
	 */
	public function actionArticle_recovery(){
		$news_id = Yii::$app->request->get('news_id');
		//恢复某条数据
		$res = News::RecoveryOneData($news_id);

		if( $res){
			return $this->redirect('/article/article_list');
		}else{
			return 0;
		}
	}
}