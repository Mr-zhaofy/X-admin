<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = '管理员列表';
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
          <cite>管理员列表</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
        <!-- <form class="layui-form layui-col-md12 x-so">
          <input class="layui-input" placeholder="开始日" name="start" id="start">
          <input class="layui-input" placeholder="截止日" name="end" id="end">
          <input type="text" id="username"  placeholder="请输入用户名" class="layui-input">
          <button class="layui-btn search"  lay-submit="" lay-filter=""><i class="layui-icon">&#xe615;</i></button>
        </form> -->
      <xblock>
        <button class="layui-btn layui-btn-danger pi"><i class="layui-icon"></i>批量删除</button>
        <button class="layui-btn" onclick="x_admin_show('添加用户','/auth/admin_add')"><i class="layui-icon"></i>添加</button>
        <span class="x-right" style="line-height:40px">共有数据：<?php echo $count;?> &nbsp;条</span>
      </xblock>
      <table class="layui-table" id="search">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><input type="checkbox"  title="" value="" id='checkAllChange'></div>
            </th>
            <th>ID</th>
            <th>登录名</th>
            <th>登录密码</th>
            <th>对应角色</th>
            <th>邮箱</th>
            <th>加入时间</th>
            <th>状态</th>
            <th>操作</th>
        </thead>
        <tbody class='sea'>
        	<?php foreach($data as $key=>$val){?>
        		<tr>
		            <td>
		              	<div class="layui-unselect layui-form-checkbox" lay-skin="primary" value="<?php echo $val['admin_id']?>"><input type="checkbox" class='box' name="check" value="<?php echo $val['admin_id']?>"></div>
		            </td>
		            <td><?php echo $val['admin_id']?></td>
		            <td><?php echo $val['admin_username']?></td>
		            <td><?php echo $val['admin_password']?></td>
                <td><?php echo $val['role_name']?></td>
		            <td><?php echo $val['admin_email']?></td>
		            <td><?php echo $val['add_time']?></td>
		            <td>
		            	<?php if($val['admin_status'] == 1){ ?>
		            		<span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
		            	<?php } ?>
		            </td>
		            <td class="td-manage">
		              	<!-- <a onclick="member_stop(this,'10001')" href="javascript:;"  title="启用">
		                	<i class="layui-icon">&#xe601;</i>
		              	</a> -->
		              	<!-- <a title="编辑"  onclick="x_admin_show('编辑','/auth/admin_list_edit?id=<?php echo $val["admin_id"]?>')" href="javascript:;">
		                	<i class="layui-icon">&#xe642;</i>
		              	</a> -->
		              	<!---->
		              	<a  title="修改密码" onclick="x_admin_show('修改密码','/auth/modify_pass?id=<?php echo $val["admin_id"]?>',600,400)" href="javascript:;" class="pass" >
                			<i class="layui-icon">&#xe631;</i>
              			</a>
		              	<a title="删除" href="javascript:;" class='del' value="<?php echo $val['admin_id']?>">
		                	<i class="layui-icon">&#xe640;</i>
		              	</a>
		            </td>
	          	</tr>
        	<?php }?>
        </tbody>
      </table>
    </div>
    <script>
      // layui.use('laydate', function(){
      //   var laydate = layui.laydate;
        
      //   //执行一个laydate实例
      //   laydate.render({
      //     elem: '#start' //指定元素
      //   });

      //   //执行一个laydate实例
      //   laydate.render({
      //     elem: '#end' //指定元素
      //   });
      // });

       /*用户-停用*/
      function member_stop(obj,id){
          layer.confirm('确认要停用吗？',function(index){

              if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

              }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
              }
              
          });
      }

      	/*用户-删除*/
      	$('.del').click(function(){
      		var id = $(this).attr('value');
      		
      		layer.confirm('确认要删除吗？',function(index){
      			$.post('/auth/admin_list_del',{id:id},function(data){
	      			if(data == 1){
			            layer.msg('已删除!',{icon:1,time:1000});
			            location.reload();
	      			}else{
	      				layer.msg('删除失败!',{icon:1,time:1000});
	      			}
	      		});
      		});
      	});

        /*****全选/全不选*****/
        $("#checkAllChange").click(function() { 
          if (this.checked == true) { 
            $(".box").each(function() { 
              this.checked = true; 
            }); 
          } else { 
            $(".box").each(function() { 
              this.checked = false; 
            }); 
          } 
        });

      	/********批量删除**********/
      	$('.pi').click(function(){
      	    var id = $("input:checkbox[name='check']:checked").map(function(index,elem){
                return $(elem).val();
            }).get().join(',');
            layer.confirm('确认删除所选中的吗？',function(index){
                $.post('/auth/batch_delete',{id:id},function(data){
                  if(data == 1){
                      layer.msg('已删除!',{icon:1,time:1000});
                      location.reload();
                  }else{
                    layer.msg('删除失败!',{icon:1,time:1000});
                  }
                })  
            });
      	})


        /******搜索******/
        $('.search').click(function(){
            var username = $('#username').val();
            $.post('/auth/admin_user_search',{username:username},function(data){
              $("#search").html(data);
            });
        })
    </script>
  </body>

</html>