<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = '角色配置权限';
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
        <form class="layui-form">
          	<div class="layui-form-item">
              	<label for="L_title" class="layui-form-label">
                  	<span class="x-red">*</span>管理员选择
              	</label>
              	<div class="layui-input-block">
              		<input type="text" id="" name="role_name" required="" lay-verify="required" autocomplete="off" value="<?php echo $roleInfo['role_name']?>" class="layui-input" readonly>
				</div>
          	</div>
	        <div class="layui-form-item">
			    <label class="layui-form-label"><span class="x-red">*</span>可分配权限</label>
			    <div class="layui-input-block">
			    	<?php foreach($power as $kk=>$vv){ ?>
			    		<input type="checkbox" name="power" value="<?php echo $vv['power_id']?>" title="<?php echo $vv['power_name']?>">
			    	<?php } ?>
			    </div>
			</div>
			<input type="hidden" name='role_id' value="<?php echo $roleInfo['role_id']?>">
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn but" lay-filter="add" lay-submit="" id="add_but">
                  提交
              </button>
          </div>
      </form>
    </div>
  </body>
</html>
<script>
	$(document).ready(function(){
		$('.but').click(function(){
			//获取选中的管理员
			var role_id = $('input[name="role_id"]').val();
			//获取选中的权限
			var power = $("input:checkbox[name='power']:checked").map(function(index,elem){
				return $(elem).val();
			}).get().join(',');
			//传值到后台入库
			$.post('/auth/execute_role_power',{role_id:role_id,power:power},function(data){
				if(data == 1){
					alert('配置成功');
				}else{
					alert('配置失败');
				}
			})
		})
	})
</script>