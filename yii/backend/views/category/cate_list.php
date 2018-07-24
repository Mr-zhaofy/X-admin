<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = '分类列表';
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
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>分类列表</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so layui-form-pane" action="/category/add_parent_menu" method="post">
          <input class="layui-input" placeholder="菜单名称" name="menu_name">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon"></i>增加</button>
        </form>
      </div>
      <blockquote class="layui-elem-quote">每个tr 上有两个属性 cate-id='1' 当前分类id fid='0' 父级id ,顶级分类为 0，有子分类的前面加收缩图标<i class="layui-icon x-show" status='true'>&#xe623;</i></blockquote>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <span class="x-right" style="line-height:40px">共有数据：<?php echo $count?>&nbsp;&nbsp; 条</span>
      </xblock>
      <table class="layui-table layui-form">
        <thead>
          <tr>
            <th width="20">
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th width="70">ID</th>
            <th>栏目名</th>
            <th width="50">父级ID</th>
            <th width="50">状态</th>
            <th width="220">操作</th>
            </tr>
        </thead>
        <tbody class='x-cate'>
        	<?php foreach($menu as $k=>$v){?>
        		<tr cate-id='<?php echo $v['menu_id']?>' fid='<?php echo $v['menu_parent_id']?>'>
        			<td></td>
					<td><?php echo $v['menu_id']?></td>
					<td>
						<?php 
							if(!empty($v['son'])){
						?>
								<i class="layui-icon x-show" status='true'>&#xe623;</i>
								<?php echo $v['menu_name']?>
						<?php	}else{ ?>
								<?php echo $v['menu_name']?>
						<?php
							}
						?>
					</td>
					<td><?php echo $v['menu_parent_id']?></td>
					<td>
						<input type="checkbox" name="switch"  lay-text="开启|停用"  checked="" lay-skin="switch">
					</td>
					<td class="td-manage">
		              	<button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','/category/menu_edit?menu_id=<?php echo $v['menu_id']?>')" ><i class="layui-icon">&#xe642;</i>编辑</button>
		              	<button class="layui-btn layui-btn-warm layui-btn-xs"  onclick="x_admin_show('添加子菜单','/category/menu_son_add?menu_id=<?php echo $v['menu_id']?>')" ><i class="layui-icon">&#xe642;</i>添加子菜单</button>
		              	<button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'要删除的id')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
		            </td>
				</tr>
				<?php
					if(empty($v['son'])){
						continue;
					}
					foreach( $v['son'] as $kk=>$vv){
				?>
					<tr cate-id='<?php echo $vv['menu_id']?>' fid='<?php echo $vv['menu_parent_id']?>' >
			            <td>
			              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div>
			            </td>
			            <td><?php echo $vv['menu_id']?></td>
			            <td>
			              &nbsp;&nbsp;&nbsp;&nbsp;
			              ├<?php echo $vv['menu_name']?>
			            </td>
			            <td><?php echo $vv['menu_parent_id']?></td>
			            <td>
			              <input type="checkbox" name="switch"  lay-text="开启|停用"  checked="" lay-skin="switch">
			            </td>
			            <td class="td-manage">
			              <button class="layui-btn layui-btn layui-btn-xs"  onclick="x_admin_show('编辑','/category/menu_edit?menu_id=<?php echo $vv['menu_id']?>')" ><i class="layui-icon">&#xe642;</i>编辑</button>
			              <button class="layui-btn-danger layui-btn layui-btn-xs"  onclick="member_del(this,'要删除的id')" href="javascript:;" ><i class="layui-icon">&#xe640;</i>删除</button>
			            </td>
          			</tr>
				<?php }?>
        	<?php }?>
        </tbody>
      </table>
    </div>
    <style type="text/css">
      
    </style>
    <script>
      layui.use(['form'], function(){
        form = layui.form;
        
      });

      

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $(obj).parents("tr").remove();
              layer.msg('已删除!',{icon:1,time:1000});
          });
      }



      function delAll (argument) {

        var data = tableCheck.getData();
  
        layer.confirm('确认要删除吗？'+data,function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
      }
    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>