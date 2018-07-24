<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * ContactForm is the model behind the contact form.
 */
class News extends ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_img', 'news_desc', 'news_label'], 'string', 'max' => 255]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'NEWS ID',
            'news_img' => 'NEWS Img',
            'news_desc' => 'NEWS Desc',
            'news_label' => 'NEWS Label',
            'news_browse_num' => 'NEWS Browse_num'
        ];
    }

    /**
     * 图片上传
     * @return [type] [description]
     */
    public function upload(){
        return $this->news_img->saveAs('upload/' . $this->news_img->baseName . '.' . $this->news_img->extension);
    }

    /**
     * 获取所有文章数据
     * @return [type] [description]
     */
    public static function getAllNewsData(){
    	$res = static::find()->select('*')->innerJoin('menu','news.news_type=menu.menu_id')->where("news.news_status != 2")->orderBy('news.add_time DESC')->asArray()->all();
    	return $res;
    }

    /**
     * 删除
     * @param  [type] $news_id [description]
     * @return [type]          [description]
     */
    public static function getDelDataInfo($news_id){
    	$res = static::updateAll(array('news_status'=>'2'),'news_id = :id',array(':id'=>$news_id));
    	return $res;
    }

    /**
     * 停用/启用
     * @param [type] $news_id [description]
     */
    public static function SaveNewsStatus($news_id,$enable_val){
    	$res = static::updateAll(array('news_status'=>$enable_val),'news_id = :id',array(':id'=>$news_id));
    	return $res;
    }

    /**
     * 获取编辑时的单挑信息
     * @param  [type] $news_id [description]
     * @return [type]          [description]
     */
    public static function getOneArticleData($news_id){
    	$res = static::find()->where("news_id = :id",[':id'=>$news_id])->asArray()->one();
    	return $res;
    }

    /**
     * 执行修改(不带图片)
     * @param  [type] $datas   [description]
     * @param  [type] $news_id [description]
     * @return [type]          [description]
     */
    public static function updateOtherInfo($datas,$news_id){
		$res = static::updateAll(array('news_title'=>$datas['title'],'news_desc'=>$datas['desc'],'news_label'=>$datas['label'],'news_type'=>$datas['type'],'news_link'=>$datas['link'],'update_time'=>date('Y-m-d H:i:s')),'news_id = :id',[':id'=>$news_id]);
		return $res;
    }

    /**
     * 执行修改(带图片)
     * @param  [type] $datas     [description]
     * @param  [type] $news_id   [description]
     * @param  [type] $file_name [description]
     * @return [type]            [description]
     */
    public static function updateImgInfo($datas,$news_id,$file_name){
		$res = static::updateAll(array('news_title'=>$datas['title'],'news_img'=>$file_name,'news_desc'=>$datas['desc'],'news_label'=>$datas['label'],'news_type'=>$datas['type'],'news_link'=>$datas['link'],'update_time'=>date('Y-m-d H:i:s')),'news_id = :id',[':id'=>$news_id]);
		return $res;
    }


    public static function RecoveryOneData($news_id){
    	$res = static::updateAll(array('news_status'=>1),'news_id = :id',[':id'=>$news_id]);
    	return $res;
    } 
}