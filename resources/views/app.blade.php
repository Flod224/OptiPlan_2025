<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="utf-8" />
		<title>@yield('title','DefenseScheduler | Dashboard')</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>

		<script>
			WebFont.load({
				google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
        </script>

		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>

		<link href={{asset("assets/vendors/base/vendors.bundle.css")}} rel="stylesheet" type="text/css" />
		<link href={{asset("assets/demo/default/base/style.bundle.css")}} rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href={{asset("assets/app/media/img/logos/OPTIMAID1.png")}} />

	</head>

	<style>

		.textSection{
			font-size: 12px;
			text-align: center;
			margin-top: 2cm;
		}
		.entete{
			display: flex;
			justify-content: center;
			gap: 2cm;
		}
		.logo{
			margin-top: 5%
		}
		.logo img{
			height: 5rem;
		}
		.tableau {
			display: flex;
			justify-content: center;
			padding-top: 2%;
			padding-bottom: 5%;
		}
		.content-table {
			width: 100%;
			table-layout: auto;
			border-collapse: collapse;
			border: 1px solid #ddd;
		}
		th{
			text-align: center;
			height: 1.5cm;
			border: 1px solid #ddd;
			font-size: 12px;
			padding: 8px;
		}
		td{
			height: 1.5cm;
			border: 1px solid #ddd;
			text-align: left;
			font-size: 12px;
			padding: 15px;
		}

		li{
			list-style: none;
			margin-bottom: 5px;
		}
	
	</style>

	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop">

						<!-- BEGIN: Brand -->
						<div class="m-stack__item m-brand  m-brand--skin-dark ">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="/choiceSession" class="m-brand__logo-wrapper">
										<img alt="" src={{asset("assets/app/media/img/logos/OPTIMAID1.png")}} style="height: 1.75cm;" />
									</a>
								</div>
								<div class="m-stack__item m-stack__item--middle m-brand__tools">
									
									<!-- BEGIN: Left Aside Minimize Toggle -->
									<a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
										<span></span>
									</a>

									<!-- END -->

									<!-- BEGIN: Responsive Aside Left Menu Toggler -->
									<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
										<span></span>
									</a>

									<!-- END -->

									<!-- BEGIN: Topbar Toggler -->
									<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
										<i class="flaticon-more"></i>
									</a>

									<!-- BEGIN: Topbar Toggler -->
								</div>
							</div>
						</div>

						<!-- END: Brand -->
						<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

							<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
								<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
									<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"><span class="m-menu__link-text" style="font-size: 18px;">DefenseScheduler</span></li>
								</ul>
							</div>
							
							<!-- BEGIN: Topbar -->
							<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
								
								<div class="m-stack__item m-topbar__nav-wrapper">
									<ul class="m-topbar__nav m-nav m-nav--inline">
										<li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light" m-dropdown-toggle="click" id="selectedSessionContent"
										 m-fullscreen-mode="dropdown" m-dropdown-persistent="1">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-nav__link-icon" style="font-size: 13px; width:7cm;"></span>
											</a>
										</li>
										<li class="m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light"
										 m-dropdown-toggle="click">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-nav__link-badge m-badge m-badge--dot m-badge--info m--hide"></span>
												<span class="m-nav__link-icon"><i class="flaticon-file-2"></i></span>
											</a>
											<div class="m-dropdown__wrapper">
												<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
												<div class="m-dropdown__inner">
													<div class="m-dropdown__header m--align-center">
														<span class="m-dropdown__header-title"  style="color: black;">Générer</span>
													</div>
													<div class="m-dropdown__body m-dropdown__body--paddingless">
														<div class="m-dropdown__content">
															<div class="data" data="false" data-height="380" data-mobile-height="200">
																<div class="m-nav-grid m-nav-grid--skin-light">
																	<div class="m-nav-grid__row">
																		<a href="{{ route('generate.invitations', ['sessionId' => session('selected_session_id')]) }}" class="m-nav-grid__item">
																			<i class="m-nav-grid__icon flaticon-file-2"></i>
																			<span class="m-nav-grid__text">Invitations Enseignants</span>
																		</a>
																		<a href="{{ route('generate.pvs', ['sessionId' => session('selected_session_id')]) }}" class="m-nav-grid__item">
																			<i class="m-nav-grid__icon flaticon-file-2"></i>
																			<span class="m-nav-grid__text">Procès verbal Etudiants</span>
																		</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</li>
										<li data-toggle="modal" data-target="#m_modal_2" class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light" m-dropdown-toggle="click" m-fullscreen-mode="dropdown" m-dropdown-persistent="1">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-nav__link-icon"><i class="flaticon-user-add "></i></span>
											</a>
										</li>
										<li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light" m-dropdown-toggle="click" id="fullscreen-button"
										 m-fullscreen-mode="dropdown" m-dropdown-persistent="1">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-nav__link-icon"><i class="flaticon-arrows "></i></span>
											</a>
										</li>
										<li class="m-nav__item">
                                            <a href="{{ route('deconnexion') }}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder" style="background-color: rgb(174, 228, 174); margin-top: 18px;">Déconnexion</a>
										</li>
									</ul>
								</div>
							</div>

							<!-- END: Topbar -->
						</div>
					</div>
				</div>
			</header>

			<!-- END: Header -->

			<!-- begin::Body -->
			<div class="modal fade" id="m_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"> Nommer un admin </h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form class="m-form m-form--fit" method="POST" action="{{route('nommerAdmin')}}">
								<div class="col-12 row">
									<input class="form-control m-input" name="nom" placeholder="Nom" required type="text" required>
								</div><br>
								<div class="col-12 row">
									<input class="form-control m-input" name="prenom" placeholder="Prénom(s)" required type="text" required>
								</div><br>
								<div class="col-12 row">
									<input class="form-control m-input" name="email" placeholder="Email" required type="email" required>
								</div><br>
								<input class="form-control m-input" name="role" type="hidden" value="1">
								@csrf
								<div style="display: flex; justify-content: right; gap: 15px;">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
									<button type="submit" class="btn btn-primary">Envoyer</button>
								</div>
							</form>
						</div>
						
					</div>
				</div>
			</div>
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

				<!-- BEGIN: Left Aside -->
				<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>

	
				<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

					<!-- BEGIN: Aside Menu -->
					<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
						<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
							@if(session()->has('selected_session_id'))
								<li class="m-menu__item  m-menu__item" aria-haspopup="true"><a href="/choiceSession" class="m-menu__link "><i class="m-menu__link-icon flaticon-line-graph"></i> <span class="m-menu__link-text"> Sessions </span></a><br><br><br>
								<li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="/AdminDashboard/{{ session('selected_session_id') }}" class="m-menu__link "><i class="m-menu__link-icon flaticon-line-graph"></i> <span class="m-menu__link-text"> Gérer les programmes</span></a><br><br><br>
								<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users-1"></i> <span class="m-menu__link-text"> Étudiants</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
										<ul class="m-menu__subnav">
											<li class="m-menu__item " aria-haspopup="true"><a href="/Etudiant" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Tous les étudiants</span></a></li>
											<li class="m-menu__item " aria-haspopup="true"><a href="/PreSoutenance/{{ session('selected_session_id') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Pré-soutenance</span></a></li>
											<li class="m-menu__item " aria-haspopup="true"><a href="/EnSoutenance/{{ session('selected_session_id') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Soutenance</span></a></li>
										</ul>
									</div>
								</li>
								<br><br><br>
								<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-avatar "></i> <span class="m-menu__link-text"> Enseignants</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
										<ul class="m-menu__subnav">
											<li class="m-menu__item " aria-haspopup="true"><a href="/Enseignant" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Tous les enseignants</span></a></li>
											<li class="m-menu__item " aria-haspopup="true"><a href="/GradeEnseignant" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Grade</span></a></li>
										</ul>
									</div>
								</li>
								<br><br><br>
								<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users-1"></i> <span class="m-menu__link-text"> Général</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
										<ul class="m-menu__subnav">
											<li class="m-menu__item " aria-haspopup="true"><a href="/Settings/{{ session('selected_session_id') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Paramètres</span></a></li>
											<li class="m-menu__item " aria-haspopup="true"><a href="/DisponibiliteSalle/{{ session('selected_session_id') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Gestion des salles</span></a></li>
										</ul>
									</div>
								</li>
							@endif
						</ul>
					</div>

					<!-- END: Aside Menu -->
				</div>
				@if(session('success'))
					<script>
						Swal.fire({
							title: 'Succès!',
							text: '{{ session('success') }}',
							icon: 'success'
						});
					</script>
				@endif




				<!-- END: Left Aside -->


                @yield('content')



				
			</div>

			<!-- end:: Body -->

			<!-- begin::Footer -->
			<footer class="m-grid__item m-footer bg-dark text-white py-3">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-6 text-center text-md-start">
							<span class="m-footer__copyright">
								&copy; 2024 <strong>DefenseScheduler</strong>. Développé par 
								<a href="#" class="m-link text-decoration-none text-white fw-bold">Karen HOUEHA</a>,
								revu par <a href="https://www.facebook.com/cooptechmons/" class="m-link text-decoration-none text-white fw-bold">OptiPlan</a>.
								<br class="d-md-none"> En partenariat avec 
								<a href="https://web.umons.ac.be/fpms/fr/" class="m-link text-decoration-none text-white fw-bold">UMONS</a>.
							</span>
						</div>
					</div>
				</div>
			</footer>

			<!-- end::Footer -->
		</div>

		<!-- end:: Page -->


		<!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="la la-arrow-up"></i>
		</div>

		<!-- end::Scroll Top -->

		<!--begin::Global Theme Bundle -->
		<script src={{asset("assets/vendors/base/vendors.bundle.js")}} type="text/javascript"></script>
		<script src={{asset("assets/demo/default/base/scripts.bundle.js")}} type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors -->
		<script src={{asset("assets/vendors/custom/fullcalendar/fullcalendar.bundle.js")}} type="text/javascript"></script>
			<script src={{asset("assets/demo/default/custom/crud/forms/widgets/select2.js")}} type="text/javascript"></script>
			<script src={{asset("assets/demo/default/custom/components/calendar/list-view.js")}} type="text/javascript"></script>


		<!--end::Page Vendors -->

		<!--begin::Page Scripts -->
		<script src={{asset("assets/app/js/dashboard.js")}} type="text/javascript"></script>

		<script>

			const fullscreenButton = document.getElementById('fullscreen-button');
			const rootElement = document.documentElement;
			let isInFullscreen = false;
	
			function toggleFullscreen() {
				if (!isInFullscreen) {
					if (rootElement.requestFullscreen) {
					rootElement.requestFullscreen();
					} else if (rootElement.mozRequestFullScreen) {
					rootElement.mozRequestFullScreen();
					} else if (rootElement.webkitRequestFullscreen) {
					rootElement.webkitRequestFullscreen();
					} else if (rootElement.msRequestFullscreen) {
					rootElement.msRequestFullscreen();
					}
				} else {
					if (document.exitFullscreen) {
					document.exitFullscreen();
					} else if (document.mozCancelFullScreen) {
					document.mozCancelFullScreen();
					} else if (document.webkitExitFullscreen) {
					document.webkitExitFullscreen();
					} else if (document.msExitFullscreen) {
					document.msExitFullscreen();
					}
				}
				isInFullscreen = !isInFullscreen;
			}

			fullscreenButton.addEventListener('click', toggleFullscreen);
			
		</script>

		<script>
			$(document).ready(function () {

				// Gestionnaire de changement pour #m_select2_4
				$('#m_select2_4').change(function () {
					var sessionId = $('#m_select2_3').val();
					var selectedOption = $(this).find(':selected');
					var type = selectedOption.val();

					// Vérification de la session
					if (sessionId === '') {
						Swal.fire(
							'Info',
							'Veuillez sélectionner la session',
							'info'
						);
						$('#m_select2_4').val('');
					} else {
						var url = '/pre-soutenance/' + sessionId + '/' + type;
						window.location.href = url;
						// if(type === 'pre'){
						// 	var url = '/pre-soutenance/' + sessionId + '/' + type;
						// 	window.location.href = url;
						// }else {
						// 	var url = '/soutenance/' + sessionId + '/' + type;
						// 	window.location.href = url;
						// }
						
					}
				});

			});
		</script>
		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>