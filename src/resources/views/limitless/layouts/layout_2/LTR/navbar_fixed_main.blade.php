<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>@yield('title')</title>

	<base href="{{ url('template/limitless/bootstrap4/layout_2/LTR/default') }}/">

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="../../../global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="../../../global_assets/js/main/jquery.min.js"></script>
	<script src="../../../global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="../../../global_assets/js/plugins/loaders/blockui.min.js"></script>
	@yield('core_js')
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="../../../global_assets/js/plugins/ui/perfect_scrollbar.min.js"></script>
	<script src="../../../global_assets/js/plugins/ui/headroom.min.js"></script>
	<script src="../../../global_assets/js/plugins/ui/prism.min.js"></script>
	@yield('theme_js')

	<script src="assets/js/app.js"></script>
	<script src="../../../global_assets/js/demo_pages/layout_fixed_sidebar_custom.js"></script>
	<script src="../../../global_assets/js/demo_pages/navbar_hideable.js"></script>
	@yield('page_js')
	<!-- /theme JS files -->

</head>

<body class="bg-transparent sidebar-opposite-visible">

	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		@csrf
	</form>

	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-light navbar-slide-top fixed-top d-block d-md-none">

		<!-- Header with logos -->
		<div class="navbar-header navbar-dark d-none d-md-flex align-items-md-center">
			<div class="navbar-brand navbar-brand-md">
				<a href="../full/index.html" class="d-inline-block">
					<img src="../../../global_assets/images/logo_light.png" alt="">
				</a>
			</div>
			
			<div class="navbar-brand navbar-brand-xs">
				<a href="../full/index.html" class="d-inline-block">
					<img src="../../../global_assets/images/logo_icon_light.png" alt="">
				</a>
			</div>
		</div>
		<!-- /header with logos -->
	

		<!-- Mobile controls -->
		<div class="d-flex flex-1 d-md-none">
			<div class="navbar-brand mr-auto">
				<a href="../full/index.html" class="d-inline-block">
					<img src="../../../global_assets/images/logo_dark.png" alt="">
				</a>
			</div>	

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>

			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>
		<!-- /mobile controls -->


		<!-- Navbar content -->
		<div class="collapse navbar-collapse" id="navbar-mobile">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>

				<li class="nav-item">
					<a href="#" class="navbar-nav-link">Text link</a>
				</li>

				<li class="nav-item dropdown">
					<a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">Menu</a>

					<div class="dropdown-menu">
						<a href="#" class="dropdown-item">Action</a>
						<a href="#" class="dropdown-item">Another action</a>
						<a href="#" class="dropdown-item">One more action</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">Separate action</a>
					</div>
				</li>
			</ul>

			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link">Text link</a>
				</li>

				<li class="nav-item dropdown">
					<a href="#" class="navbar-nav-link">
						<i class="icon-bell2"></i>
						<span class="d-md-none ml-2">Notifications</span>
						<span class="badge badge-mark border-white"></span>
					</a>
				</li>

				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
						<img src="../../../global_assets/images/image.png" class="rounded-circle mr-2" height="34" alt="">
						<span>Victoria</span>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="#" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
						<a href="#" class="dropdown-item"><i class="icon-coins"></i> My balance</a>
						<a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Messages <span class="badge badge-pill bg-blue ml-auto">58</span></a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item"><i class="icon-cog5"></i> Account settings</a>
						<a href="#" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
					</div>
				</li>
			</ul>
		</div>
		<!-- /navbar content -->

	</div>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md sidebar-fixed">

			<!-- Sidebar mobile toggler -->
			<div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle">
					<i class="icon-arrow-left8"></i>
				</a>
				Navigation
				<a href="#" class="sidebar-mobile-expand">
					<i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i>
				</a>
			</div>
			<!-- /sidebar mobile toggler -->


			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- User menu -->
				<div class="sidebar-user">
					<div class="card-body">
						<div class="media">
							<div class="mr-3">
								<a href="#"><img src="../../../global_assets/images/image.png" width="38" height="38" class="rounded-circle" alt=""></a>
							</div>

							<div class="media-body">
								<div class="media-title font-weight-semibold">Victoria Baker</div>
								<div class="font-size-xs opacity-50">
									<i class="icon-pin font-size-sm"></i> &nbsp;Santa Ana, CA
								</div>
							</div>

							<div class="ml-3 align-self-center">
								<a href="#" class="text-white"><i class="icon-cog3"></i></a>
							</div>
						</div>
					</div>
				</div>
				<!-- /user menu -->


				<!-- Main navigation -->
				<div class="card card-sidebar-mobile">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<!-- Main -->
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
						<li class="nav-item">
							<a href="{{route('admin.index')}}" class="nav-link active">
								<i class="icon-home4"></i>
								<span>
									Dashboard
									<span class="d-block font-weight-normal opacity-50">System(s) performance</span>
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.services.index')}}" class="nav-link">
								<i class="icon-sync"></i>
								<span>
									Apps
									<span class="d-block font-weight-normal opacity-50">Manage Apps</span>
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.services.index')}}" class="nav-link">
								<i class="icon-cog"></i>
								<span>
									Services
									<span class="d-block font-weight-normal opacity-50">Manage Services</span>
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('admin.users.index')}}" class="nav-link">
								<i class="icon-users"></i>
								<span>
									Users
									<span class="d-block font-weight-normal opacity-50">Manage Users</span>
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{route('logout')}}" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
								<i class="icon-lock"></i>
								<span>Logout</span>
							</a>
						</li>
						<!-- /main -->

					</ul>
				</div>
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->
			
		</div>
		<!-- /main sidebar -->

		@yield('sidebar')

		@yield('content')

	</div>
	<!-- /page content -->

</body>
</html>
