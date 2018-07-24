<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = '添加子菜单';
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
        <form class="layui-form" action="/category/menu_add_son" method="post">
          <div class="layui-form-item">
              <label for="menu_name" class="layui-form-label">
                  <span class="x-red">*</span>菜单名称
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="menu_name" name="menu_name" required="" lay-verify="required"
                  autocomplete="off" value="" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="menu_parent_id" class="layui-form-label">
                  <span class="x-red">*</span>父级ID
              </label>
              <div class="layui-input-inline">
                  <input type="text" value="<?php echo $info['menu_id']?>" id="menu_parent_id" name="menu_parent_id" required="" lay-verify="menu_parent_id" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>(默认显示为当前菜单的ID)
              </div>
          </div>
          <div class="layui-form-item">
              <label for="menu_status" class="layui-form-label">
                  <span class="x-red">*</span>菜单状态
              </label>
              <div class="layui-input-inline">
                  <input type="text" value="1" id="menu_status" name="menu_status" required="" lay-verify="menu_status" autocomplete="off" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red">*</span>(默认为1,显示状态)
              </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  添加
              </button>
          </div>
      </form>
    </div>
  </body>
	
</html>