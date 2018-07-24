<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = '管理员添加';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?= Html::encode($this->title);?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
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

  	<div class="x-nav">
      	<span class="layui-breadcrumb">
	        <a href="">首页</a>
	        <a href="">演示</a>
	        <a>
	          <cite>数据导出</cite></a>
      	</span>
      	<a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        	<i class="layui-icon" style="line-height:30px">ဂ</i>
        </a>
    </div>
    <form class="layui-form" method="post" action="/export/execute_export">
	    <div class="x-body">
	        <div class="layui-form-item">
		    	<label class="layui-form-label">选择要导出的数据</label>
		    	<div class="layui-input-block" style="width:220px">
			      	<select name="type" lay-filter="aihao">
			      		<option selected>-----请选择-----</option>
			        	<option value="1">管理员数据</option>
			        	<option value="2">文章数据</option>
			        	<!-- <option value="3">分类数据</option> -->
			      	</select>
			    </div>
			</div>
			<div class="layui-form-item">
	            <label for="L_repass" class="layui-form-label"></label>
	            <button  class="layui-btn" lay-filter="add" lay-submit="">
	                导出
	            </button>
	        </div>
	    </div>
   	</form>
    <script>
        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;

        });
    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>