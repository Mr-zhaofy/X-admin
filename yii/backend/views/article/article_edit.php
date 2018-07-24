<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = '文章--编辑';
?>
<!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title><?= Html::encode($this->title);?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/css/font.css">
    <link rel="stylesheet" href="/css/xadmin.css">
    <script type="text/javascript" src="/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <div class="x-body">
        <form class="layui-form" action="/article/execute_edit" method="post" enctype="multipart/form-data">
          <div class="layui-form-item">
              <label for="L_title" class="layui-form-label">
                  <span class="x-red">*</span>文章标题
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_title" name="title" required="" lay-verify="title"
                  autocomplete="off" class="layui-input" value="<?php echo $data['news_title']?>">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_label" class="layui-form-label">
                  <span class="x-red">*</span>文章标签
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_label" name="label" required="" lay-verify="label"
                  autocomplete="off" class="layui-input" value="<?php echo $data['news_label'];?>">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_pass" class="layui-form-label">
                  <span class="x-red">*</span>文章配图
              </label>
              <div class="layui-input-inline">
                  <input type="file" name='files' value="<?php echo $data['news_img']?>">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
                  <span class="x-red">*</span>文章描述
              </label>
              <div class="layui-input-inline">
                  <textarea name="desc" id="desc" cols="60" rows="5"><?php echo $data['news_desc']?></textarea>
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_label" class="layui-form-label">
                  <span class="x-red">*</span>文章链接
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="L_link" name="link" required="" lay-verify="link"
                  autocomplete="off" class="layui-input" value="<?php echo $data['news_link']?>">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
                  <span class="x-red">*</span>文章分类
              </label>
              <div class="layui-input-inline">
                  <select name="type" id="">
					<?php 
                        foreach($menu as $key=>$val){
                    ?>
                            <option value="<?php echo $val['menu_id']?>"><?php echo $val['menu_name']?></option>
                    <?php
                    	if(empty($val['son'])){
                    		continue;
                    	}
                        foreach($val['son'] as $k=>$v){
                    ?>
                    <option value="<?php echo $v['menu_id']?>" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $v['menu_name']?></option>
                    <?php
                            }
                        }
                    ?>
                  </select>
              </div>
          </div>
          <input type="hidden" name='news_id' value="<?php echo $data['news_id']?>">
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="" id="add_but">
                  编辑
              </button>
          </div>
      </form>
    </div>
    
  </body>

</html>