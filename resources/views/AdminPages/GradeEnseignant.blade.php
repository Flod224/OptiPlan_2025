<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="utf-8" />
		<title>DefenseScheduler | Dashboard</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

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

							<!-- BEGIN: Topbar -->
							<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
								
								<div class="m-stack__item m-topbar__nav-wrapper">
									<ul class="m-topbar__nav m-nav m-nav--inline">
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
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

				<!-- BEGIN: Left Aside -->
				<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>

	
				<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

					<!-- BEGIN: Aside Menu -->
					<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
						<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
							@if(session()->has('selected_session_id'))
								<li class="m-menu__item  m-menu__item" aria-haspopup="true"><a href="/choiceSession" class="m-menu__link "><i class="m-menu__link-icon flaticon-line-graph"></i> <span class="m-menu__link-text"> Sessions </span></a><br><br><br>
								<li class="m-menu__item " aria-haspopup="true"><a href="/AdminDashboard/{{ session('selected_session_id') }}" class="m-menu__link "><i class="m-menu__link-icon flaticon-line-graph"></i> <span class="m-menu__link-text"> Gérer les programmes</span></a><br><br><br>
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
								<li class="m-menu__item m-menu__item--active m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-avatar "></i> <span class="m-menu__link-text"> Enseignants</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
										<ul class="m-menu__subnav">
											<li class="m-menu__item " aria-haspopup="true"><a href="/Enseignant" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Tous les enseignants</span></a></li>
											<li class="m-menu__item m-menu__item--active " aria-haspopup="true"><a href="/GradeEnseignant" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Grade</span></a></li>
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

				<!-- END: Left Aside -->

				<div class="m-grid__item m-grid__item--fluid m-wrapper">

				<!-- BEGIN: Subheader -->

				<div class="m-subheader ">
					<div class="d-flex align-items-center">
						<div class="mr-auto">
							<h3 class="m-subheader__title m-subheader__title--separator">Grade des enseignants </h3>
							<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
								<li class="m-nav__item m-nav__item--home">
									<a href="#" class="m-nav__link m-nav__link--icon">
										<i class="m-nav__link-icon la la-home"></i>
									</a>
								</li>
							</ul>
						</div>
						<div>
						</div>
					</div>
				</div>

			<!-- END: Subheader -->

			{{-- Tableau --}}
				<div class="m-content">

					<!--begin::Portlet-->

						<div class="m-portlet" >
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon">
											<i class="flaticon-calendar-with-a-clock-time-tools"></i>
										</span>
										<h3 class="m-portlet__head-text">
											Grade
										</h3>
									</div>
								</div>
								<div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item">
											{{-- <a href="#" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill m-btn--air" id="grade" data-skin="dark" data-toggle="m-tooltip" data-placement="bottom" title="Ajouter">
												<i class="fa flaticon-plus"></i>
											</a> --}}
										</li>
									</ul>
								</div>
							</div>

							<div class="m-portlet__body">
								@if ($errors->any())
									@foreach ($errors->all() as $error)
										<script>
											Swal.fire({
												title: 'Erreur!',
												text: '{{ $error }}',
												icon: 'error'
											});
										</script>
									@endforeach
								@endif
								<form action="{{ route('ajoutGrades') }}" method="POST">
									@csrf
									<div class="m-portlet__body">

										<div class="form-group m-form__group row">
                                            <div class="col-5">
												<label for=""><b>Grade</b></label><br><br>
												<input class="form-control m-input" type="text" placeholder="Grade" name="nom">
											</div>
                                            
											<div class="col-2">
												<label for=""><b>Actions</b></label><br><br>
												<div class="m-demo__preview m-demo__preview--btn">
													<button type="submit" class="btn btn-success">Enregistrer grade</button>
												</div>
											</div>
										</div><br>

									</div>
								</form>
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h5 class="m-portlet__head-text" style="color: blue; text-align: center;">
											Grades enregistrées
										</h5>
									</div>
								</div>
								@foreach ($grades as $grade)
									<form action="{{ route('gradeUpdate') }}" method="POST">
										@csrf
										<div class="m-portlet__body" style="margin-bottom: -40px;">

											<div class="form-group m-form__group row">
												<input class="form-control m-input" type="text" style="display: none;" value="{{$grade->id}}" name="id">
												<div class="col-5">
													<input class="form-control m-input" type="text" value="{{$grade->nom}}" name="nom">
												</div>
						
												<div class="col-2">
													<div class="m-demo__preview m-demo__preview--btn">
														<button type="submit" class="btn btn-primary">Modifier le grade</button>
													</div>
												</div>
												</form>
												<!-- Formulaire de suppression -->
												<form action="{{ route('gradeDelete') }}" method="POST" style="display: inline-block;">
													@csrf
													<!-- Champ caché pour l'ID -->
													<input type="hidden" name="id" value="{{ $grade->id }}">
													<button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce grade ?')">
														Supprimer
													</button>
												</form>
											</div>

										</div>
									
								@endforeach

								<script>
									@if(session('success'))
									Swal.fire({
										title: 'Succès!',
										text: '{{ session('success') }}',
										icon: 'success'
									});
									@endif
								</script>
							</div>

						</div>

					<!--end::Portlet-->
					
				</div>

				</div>
					
			</div>
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


			// const grade = document.getElementById('grade');
			// const gradeDiv = document.querySelector('.gradeDiv');

			// grade.addEventListener('click', (event) => {
			// 	event.preventDefault();
			// 	const newgradeDiv = document.createElement('div');
			// 	newgradeDiv.classList.add('gradeDiv');
			// 	newgradeDiv.style.display = 'block';
			// 	newgradeDiv.innerHTML = gradeDiv.innerHTML;

			// 	gradeDiv.parentNode.insertBefore(newgradeDiv, gradeDiv.nextSibling);
			// });

			// /**
			//  * Suppression
			// */

			// const sectionContainers = document.querySelectorAll('.m-portlet__body');

			// sectionContainers.forEach(container => {
			// 	container.addEventListener('click', (event) => {
			// 		event.preventDefault();
			// 		const target = event.target;
					
			// 		// Vérifiez si le bouton de suppression a été cliqué
			// 		if (target.classList.contains('flaticon-delete')) {
			// 			const itemDiv = target.closest('.gradeDiv');
			// 			if (itemDiv) {
			// 				itemDiv.remove();
			// 			}
			// 		}
			// 	});
			// });

			</script>
		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>