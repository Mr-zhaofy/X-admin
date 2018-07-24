<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\AdminUser;
use \phpExcel;
use backend\models\News;
use backend\models\Menu;
/**
 * Site controller
 */
class ExportController extends Controller
{
	//关闭默认布局layout
	public $layout = false;
	//关闭post请求的CSRF验证拦截
	public $enableCsrfValidation=false;

	/**
	 * 页面渲染
	 * @return [type] [description]
	 */
	public function actionData_export(){
		return $this->render('index');
	}

	/**
	 * 导出
	 * @return [type] [description]
	 */
	public function actionExecute_export(){
		$type = Yii::$app->request->post('type');
		//实例化Excel类
		$objectPHPExcel = new \PHPExcel();
		//根据类型判断要导出的数据类型
		if( $type == 1){
			//获取所有管理员数据
			$data = AdminUser::getAllAdminUserData();
			if ( !$data) {
				return false;
			}
			
			foreach ($data as $key => $value) {
				$num = $key + 2 ;
				//报表头
				$objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','管理员ID');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','管理员名称');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','管理员邮箱');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','管理员状态');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','添加时间');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','管理员角色ID');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','角色名称');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','角色状态');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','角色描述');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                //设置居中
                // $objectPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //报表数据
                $objectPHPExcel->getActiveSheet()->setCellValue('A'.$num,$value['admin_id']);
                $objectPHPExcel->getActiveSheet()->setCellValue('B'.$num,$value['admin_username']);
                $objectPHPExcel->getActiveSheet()->setCellValue('C'.$num,$value['admin_email']);
                $objectPHPExcel->getActiveSheet()->setCellValue('D'.$num,$value['admin_status']);
                $objectPHPExcel->getActiveSheet()->setCellValue('E'.$num,$value['add_time']);
                $objectPHPExcel->getActiveSheet()->setCellValue('F'.$num,$value['admin_role_id']);
                $objectPHPExcel->getActiveSheet()->setCellValue('G'.$num,$value['role_name']);
                $objectPHPExcel->getActiveSheet()->setCellValue('H'.$num,$value['role_status']);
                $objectPHPExcel->getActiveSheet()->setCellValue('I'.$num,$value['role_desc']);
			}
			$fileName = date('Ymd').'_'.'adminUser'.'excel.xls';
			$objectPHPExcel->getActiveSheet()->setTitle('adminUser');
        	$objectPHPExcel->setActiveSheetIndex(0);
        	header('Content-Type: application/vnd.ms-excel');
			header("Content-Disposition: attachment;filename=$fileName");
			header('Cache-Control: max-age=0');
			$objWriter = \PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;

		}elseif ( $type ==2) {
			//获取所有文章数据
			$data = News::getAllNewsData();
			if ( !$data) {
				return false;
			}
			foreach ($data as $key => $value) {
				$num = $key + 2 ;
				//报表头
				$objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','文章ID');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','文章标题');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','文章描述');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','文章标签');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','浏览量');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','文章分类');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','文章链接');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','添加时间');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','文章状态');
                //设置居中
                // $objectPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //报表数据
                $objectPHPExcel->getActiveSheet()->setCellValue('A'.$num,$value['news_id']);
                $objectPHPExcel->getActiveSheet()->setCellValue('B'.$num,$value['news_title']);
                $objectPHPExcel->getActiveSheet()->setCellValue('C'.$num,$value['news_desc']);
                $objectPHPExcel->getActiveSheet()->setCellValue('D'.$num,$value['news_label']);
                $objectPHPExcel->getActiveSheet()->setCellValue('E'.$num,$value['news_browse_num']);
                $objectPHPExcel->getActiveSheet()->setCellValue('F'.$num,$value['menu_name']);
                $objectPHPExcel->getActiveSheet()->setCellValue('G'.$num,$value['news_link']);
                $objectPHPExcel->getActiveSheet()->setCellValue('H'.$num,$value['add_time']);
                $objectPHPExcel->getActiveSheet()->setCellValue('I'.$num,$value['news_status']);
			}
			$fileName = date('Ymd').'_'.'news'.'excel.xls';
			$objectPHPExcel->getActiveSheet()->setTitle('news');
        	$objectPHPExcel->setActiveSheetIndex(0);
        	header('Content-Type: application/vnd.ms-excel');
			header("Content-Disposition: attachment;filename=$fileName");
			header('Cache-Control: max-age=0');
			$objWriter = \PHPExcel_IOFactory::createWriter($objectPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;
		}
	}
}