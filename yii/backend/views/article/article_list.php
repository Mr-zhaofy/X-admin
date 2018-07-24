<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = '文章列表';
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
    <link href="/assets/5a1d5fd8/css/bootstrap.css" rel="stylesheet">  
    <script type="text/javascript" src="/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body class="layui-anim layui-anim-up">
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>文章列表</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right;text-decoration:none" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
          <input class="layui-input" placeholder="开始日" name="start" id="start">
          <input class="layui-input" placeholder="截止日" name="end" id="end">
          <input type="text" name="username"  placeholder="请输入用户名" autocomplete="off" class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加文章','/article/add_article',600,400)"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：<?php echo $count?>条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          	<tr>
	            <th>
	              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary" id='check'><i class="layui-icon">&#xe605;</i></div>
	            </th>
	            <th>编号</th>
	            <th>配图</th>
	            <th>标题</th>
	            <th>描述</th>
	            <th>标签</th>
	            <th>浏览量</th>
	            <!-- <th>所属分类</th> -->
	            <th>添加时间</th>
	            <th>状态</th>
	            <th>操作</th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach($listData as $key=>$val){?> 
          	<tr>
	            <td>
	              <div class="layui-unselect layui-form-checkbox" id='check' lay-skin="primary" data-id='2' value="<?php echo $val['news_id']?>"><i class="layui-icon">&#xe605;</i></div>
	            </td>
	            <td><?php echo $val['news_id']?></td>
	            <td><img style="width:50px;height:50px;" src="/upload/<?php echo $val['news_img']?>" ></td>
	            <td><?php echo substr($val['news_title'],0,25).'......';?></td>
	            <td><?php echo substr($val['news_desc'],0,39).'......';?></td>
	            <td><?php echo $val['news_label']?></td>
	            <td><?php echo $val['news_browse_num']?></td>
	            <td><?php echo $val['add_time']?></td>
	            <td class="td-status">
					<?php if($val['news_status'] == 1){?>
	              		<span class="layui-btn layui-btn-normal layui-btn-mini" id='enables' value='1'>已启用</span>
	              	<?php }else if($val['news_status'] == 0){?>
	              		<span class="layui-btn layui-btn-disabled layui-btn-mini" id='enables' value='0'>已停用</span>
	              	<?php } ?>
	            </td>
	            <td class="td-manage">
	            	<input type="hidden" name="_csrf" id='csrf' value="<?= Yii::$app->request->csrfToken ?>"> 
	            	<!-- 启用 -->
	              	<a href="javascript:;" class='enable' style='text-decoration:none' value="<?php echo $val['news_id']?>"><i class="layui-icon">&#xe601;</i></a>
	              	<!-- 编辑 -->	
	              	<a href="javascript:;" onclick="x_admin_show('编辑','/article/article_edit?news_id=<?php echo $val['news_id']?>')" style='text-decoration:none' value="<?php echo $val['news_id']?>"><i class="layui-icon">&#xe642;</i> </a>
	              	<!-- 删除 -->
	              	<a href="javascript:;" class='del' style='text-decoration:none' value="<?php echo $val['news_id']?>"><i class="layui-icon">&#xe640;</i></a>
	            </td> 
          	</tr>
          	<?php }?>
        </tbody>
      </table>
      <div class="page">
        <?=
			LinkPager::widget([
		      'pagination' => $pages,
		    ]);
		?>
      </div>

    </div>
    <script>
    	$(document).ready(function(){
    		/*********启用/停用**********/
    		$('.enable').click(function(){
    			var news_id = $(this).attr('value');
    			var enable_val = $("#enables").attr('value');
    			if( enable_val == 1){
    				var val = 0;
    				layer.confirm('确认要停用吗?',{title:"确认停用"} ,function(index){
			            layer.close(index);
			            window.location.href = '/article/article_enable?news_id='+news_id+'&val='+val;
			            layer.msg('已停用!',{icon:1,time:1000});
			        });
    			}else if(enable_val == 0){
    				var val = 1;
    				layer.confirm('确认要启用吗?',{title:"确认启用"} ,function(index){
			            layer.close(index);
			            window.location.href = '/article/article_enable?news_id='+news_id+'&val='+val;
			            layer.msg('已启用!',{icon:1,time:1000});
			        });
    			}    			
    		})
    		/**********删除************/
    		$('.del').click(function(){
    			var news_id = $(this).attr('value');
    			var csrf = $("#csrf").val();
    			layer.confirm('确认要删除吗，删除后不能恢复',{title:"删除确认"} ,function(index){
		            layer.close(index);
		            window.location.href = '/article/article_delete?news_id='+news_id;
		            layer.msg('已删除!',{icon:1,time:1000});
		        });
    		})
    	})


    	function delAll(){
    		var check = $('#check').attr('value');
    		alert(check);
    	}
    </script>
  </body>

</html>