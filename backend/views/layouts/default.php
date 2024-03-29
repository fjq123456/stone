<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;
use backend\modules\menu\models\Menu;
use common\models\User;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
$user = User::findIdentity(Yii::$app->user->id);

$menu = Menu::getMenus(Yii::$app->user->id);
$app = Yii::$app->id;
$m = Yii::$app->controller->module->id;
$c = Yii::$app->controller->id;
$a = Yii::$app->controller->action->id;

$current_menu = $app==$m ? $c.$a:$m.$c.$a;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="<?= Yii::$app->charset ?>"/>
		<title>Tables - Ace Admin</title>
		<?php $this->head() ?>
		<meta name="description" content="Static &amp; Dynamic Tables" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<?= Html::csrfMetaTags() ?>
		<?= Html::cssFile('static/css/ace-part2.min.css',['condition'=>'lte IE 9']) ?>
		<?= Html::cssFile('static/css/ace-ie.min.css',['condition'=>'lte IE 9']) ?>
		<?= Html::jsFile('static/js/html5shiv.min.js',['condition'=>'lte IE 8']) ?>
		<?= Html::jsFile('static/js/respond.min.js',['condition'=>'lte IE 8']) ?>
		<?= Html::jsFile('static/js/respond.min.js',['condition'=>'lte IE 8']) ?>

	</head>

	<body class="no-skin">
		<?php $this->beginBody() ?>
		<!-- #section:basics/navbar.layout -->
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<!-- #section:basics/sidebar.mobile.toggle -->
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<!-- /section:basics/sidebar.mobile.toggle -->
				<div class="navbar-header pull-left">
					<!-- #section:basics/navbar.layout.brand -->
					<a href="#" class="navbar-brand">
						<small>
							<i class="fa fa-leaf"></i>
							后台管理
						</small>
					</a>

					<!-- /section:basics/navbar.layout.brand -->

					<!-- #section:basics/navbar.toggle -->

					<!-- /section:basics/navbar.toggle -->
				</div>








				<!-- #section:basics/navbar.dropdown -->
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="grey">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-tasks"></i>
								<span class="badge badge-grey">4</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-check"></i>
									4 项工作
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">第一项</span>
											<span class="pull-right">65%</span>
										</div>
										<div class="progress progress-mini">
											<div style="width:65%" class="progress-bar"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">第二项</span>
											<span class="pull-right">35%</span>
										</div>

										<div class="progress progress-mini">
											<div style="width:35%" class="progress-bar progress-bar-danger"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">第三项</span>
											<span class="pull-right">15%</span>
										</div>

										<div class="progress progress-mini">
											<div style="width:15%" class="progress-bar progress-bar-warning"></div>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">第四项</span>
											<span class="pull-right">90%</span>
										</div>

										<div class="progress progress-mini progress-striped active">
											<div style="width:90%" class="progress-bar progress-bar-success"></div>
										</div>
									</a>
								</li>

								<li class="dropdown-footer">
									<a href="#">
										查看所有工作
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="purple">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important">8</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									8 个消息
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
												新增评论
											</span>
											<span class="pull-right badge badge-info">+12</span>
										</div>
									</a>
								</li>

								<li>
									<a href="#">
										<i class="btn btn-xs btn-primary fa fa-user"></i>
										新注册用户
									</a>
								</li>

								<li>
									<a href="#">
										<div class="clearfix">
											<span class="pull-left">
												<i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
												新订单
											</span>
											<span class="pull-right badge badge-success">+8</span>
										</div>
									</a>
								</li>
								<li class="dropdown-footer">
									<a href="#">
										查看所有消息
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="green">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
								<span class="badge badge-success">5</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-envelope-o"></i>
									3 通知
									<span class="pull-right"><a href="">清空</a></span>
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
										<li>
											<a href="#">
												<img src="static/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">李总:</span>
														修改一下广告稿
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>a moment ago</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<img src="static/avatars/avatar3.png" class="msg-photo" alt="Susan's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">张同:</span>
														晚上一起回家
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>20 minutes ago</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#">
												<img src="static/avatars/avatar4.png" class="msg-photo" alt="Bob's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">李传:</span>
														把邮件送到办公室
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>3:15 pm</span>
													</span>
												</span>
											</a>
										</li>
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="inbox.html">
										查看所有通知
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<!-- #section:basics/navbar.user_menu -->
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="static/avatars/user.jpg" alt="Jason's Photo" />
								<?=$user->username?>
								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>设置
									</a>
								</li>

								<li>
									<a href="profile.html">
										<i class="ace-icon fa fa-user"></i>个人主页
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="<?= Url::toRoute(['/site/logout']) ?>" data-method='post'>
										<i class="ace-icon fa fa-power-off"></i>登出
									</a>
								</li>
							</ul>
						</li>
						<!-- /section:basics/navbar.user_menu -->
					</ul>
				</div>

				<!-- /section:basics/navbar.dropdown -->
			</div><!-- /.navbar-container -->
		</div>

		<!-- /section:basics/navbar.layout -->
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar                  responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<!-- #section:basics/sidebar.layout.shortcuts -->
						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>

						<!-- /section:basics/sidebar.layout.shortcuts -->
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->
<!-- 这个往里点 -->
<ul class="nav nav-list">
	<li class="">
		<a href="<?=Url::toRoute('/site/index');?>">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text"> Dashboard </span>
		</a>

		<b class="arrow"></b>
	</li>

<?php foreach ($menu as $key => $value):?>
	<li class="p-menu">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-list"></i>
			<span class="menu-text"><?=$value['name']?></span>
			<b class="arrow fa fa-angle-down"></b>
		</a>
		<b class="arrow"></b>
		<ul class="submenu">
			<?php foreach ($value['child'] as $k => $val):?>
			<?php $m_str = $val['module_name'].$val['controller_name'].$val['action_name'];?>
			<li class="<?php if($m_str == $current_menu) echo 'active'?>" rel="<?=$m_str?>">
				<?php $url = '/'.$val['module_name'].'/'.$val['controller_name'].'/'.$val['action_name'];?>
				<a href="<?=Url::toRoute($url);?>">
					<i class="menu-icon <?=$val['icon']?>"></i>
					<?=$val['name']?>
				</a>
				<b class="arrow"></b>
			</li>
			<?php endforeach;?>
		</ul>
	</li>
<?php endforeach;?>

	<!--
	<li class="active open">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-list"></i>
			<span class="menu-text">用户管理</span>

			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			<li class="active">
				<a href="<?=Url::toRoute('user/index');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					列表
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?=Url::toRoute('user/create');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					添加
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?=Url::toRoute('role/index');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					权限
				</a>
				<b class="arrow"></b>
			</li>
		</ul>
	</li>
	
	<li class="active open">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-list"></i>
			<span class="menu-text">权限管理</span>

			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			<li class="active">
				<a href="<?=Url::toRoute('/srbac/default');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					权限列表
				</a>
				<b class="arrow"></b>
			</li>
			<li class="">
				<a href="<?=Url::toRoute('/srbac/role');?>">
					<i class="menu-icon fa fa-caret-right"></i>
					角色管理
				</a>
				<b class="arrow"></b>
			</li>
		</ul>
	</li>
	-->
</ul><!-- /.nav-list -->

				<!-- #section:basics/sidebar.layout.minimize -->
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<!-- /section:basics/sidebar.layout.minimize -->
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<!-- /section:basics/sidebar -->
			<div class="main-content">
				<!-- /section:basics/content.breadcrumbs -->
				<?=$content?>
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<!-- #section:basics/footer -->
					<!--
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Ace</span>
							Application &copy; 2013-2014
						</span>

						&nbsp; &nbsp;
						<span class="action-buttons">
							<a href="#">
								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
							</a>
						</span>
					</div>
					-->
					<!-- /section:basics/footer -->
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- 删除等危险操作的提示 -->
<div id="dialog-confirm" class="hide">
	<div class="space-6"></div>
	<p class="bigger-110 bolder center grey">
		<i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
		确定要执行此操作吗?
	</p>
</div><!-- #dialog-confirm -->

		<?= Html::jsFile('static/js/jquery1x.min.js',['condition'=>'IE']) ?>

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='static/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<?= Html::jsFile('static/js/bootstrap.min.js') ?>
		<?= Html::jsFile('static/js/jquery.dataTables.min.js') ?>
		<?= Html::jsFile('static/js/jquery.dataTables.bootstrap.js') ?>
		<?= Html::jsFile('static/js/ace.min.js') ?>
		
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				//栏目伸缩
				var obj = $('.row .widget-body');
				$('.hand', obj).bind('click',function () {
					$(this).toggleClass('tree-minus').toggleClass('tree-plus').parent('.tree-folder-header')
							.siblings('.tree-folder-content').children('.tree-folder, .tree-item').toggle();
				});
				var oTable1 = 
				$('#sample-table-2').dataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null, null, null,
					  { "bSortable": false }
					],
					"aaSorting": [],

			    } );
				//寻找打开的菜单
				$('.submenu .active').parents('.p-menu').addClass('active open');
			})
		</script>
		<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>