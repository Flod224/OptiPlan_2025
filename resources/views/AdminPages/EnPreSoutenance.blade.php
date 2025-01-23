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
		<link href={{asset("assets/vendors/custom/datatables/datatables.bundle.css")}} rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href={{asset("assets/app/media/img/logos/OPTIMAID1.png")}} />

	</head>
	
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			<header id="m_header" class="m-grid__item m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop">

						<!-- BEGIN: Brand -->
						<div class="m-stack__item m-brand  m-brand--skin-dark ">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="/choiceSession" class="m-brand__logo-wrapper">
										<img alt="" src={{asset("assets/app/media/img/logos/OPTIMAID1.png")}} style="height: 1.55cm;" />
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
								<li class="m-menu__item  m-menu__item" aria-haspopup="true"><a href="/AdminDashboard/{{ session('selected_session_id') }}" class="m-menu__link "><i class="m-menu__link-icon flaticon-line-graph"></i> <span class="m-menu__link-text"> Gérer les programmes</span></a><br><br><br>

								<li class="m-menu__item  m-menu__item--submenu m-menu__item--active" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users-1"></i> <span class="m-menu__link-text"> Étudiants</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
										<ul class="m-menu__subnav">
											<li class="m-menu__item " aria-haspopup="true"><a href="/Etudiant" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Tous les étudiants</span></a></li>
											<li class="m-menu__item m-menu__item--active" aria-haspopup="true"><a href="/PreSoutenance/{{ session('selected_session_id') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Pré-soutenance</span></a></li>
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

				<!-- END: Left Aside -->

				<div class="m-grid__item m-grid__item--fluid m-wrapper">
					<!--begin table -->
						<br>
						<!--begin::Portlet-->
                        
                        <div class="row">
                            <div class="col-xl-1 col-lg-1"></div>

                            <div class="col-xl-4 col-lg-4">

                                <div class="m-portlet m-portlet--full-height">
									<form class="m-form m-form--fit m-form--label-align-right" action="{{ route('programmerPreSoutenance') }}" method="POST" enctype="multipart/form-data">

                                    <div class="m-portlet__body">
                                        <div class="form-group m-form__group row">
											<div class="col-12">
												<label for=""><b>Etudiants</b></label><br><br>
												<select class="form-control m-select2" id="m_select2_4" multiple="multiple" name="etudiant_id[]">
													<option value=""></option>
													@foreach ($etudiants as $etudiant)
														<option value="{{ $etudiant->user->id }}" data-maitre-memoire="{{ $etudiant->maitre_memoire }}">
															{{ $etudiant->user->nom }} {{ $etudiant->user->prenom }} - {{ $etudiant->niveau_etude }} - {{ $etudiant->filiere }}
														</option>
													@endforeach
												</select>
											</div>
										</div><br>
                                    </div>

                                </div>

                            </div>
                            
                            <div class="col-xl-6 col-lg-6">
                                <div class="m-portlet m-portlet--full-height">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-tools">
                                            <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                                        <i class="flaticon-share m--hide"></i>
                                                        Programmation des pré-soutenances
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
									@if(session('error'))
										<script>
											Swal.fire({
												title: 'Erreur!',
												text: '{{ session('error') }}',
												icon: 'error'
											});
										</script>
									@endif
									
                                    <div class="tab-content">
                                        <div class="tab-pane active">
                                                <div class="m-portlet__body">
													@csrf
													<div class="form-group m-form__group row">
														<div class="col-6">
															<label for=""><b>Sessions</b></label><br><br>
															<select class="form-control m-select2" id="m_select2_3" required name="session_id">
																@foreach($sessions as $session)
																	<option value="{{ $session->id }}" data-start="{{ $session->session_start }}" data-end="{{ $session->session_end }}" >
																		{{ $session->description }} ({{ \Carbon\Carbon::parse($session->session_start)->format('d-m-Y') }} - {{ \Carbon\Carbon::parse($session->session_end)->format('d-m-Y') }})
																	</option>
																@endforeach
															</select>
														</div>
														<div class="col-6">
															<label for=""><b>Date</b></label><br><br>
															<input class="form-control m-input" type="date" required id="datePicker" name="jour" placeholder="Date">
														</div>
													</div><br>
													
													<div class="form-group m-form__group row">
													
														<div class="col-6">
															<label for=""><b>Grille horaire</b></label><br><br>
															<select class="form-control m-select2" id="m_select2_1" required name="horaire_id">
																<option value=""></option>
																<option value="1">08H - 13H</option>
																<option value="2">13H - 18H</option>
															</select>
														</div>
														<div class="col-6">
															<label for=""><b>Salle</b></label><br><br>
															<select class="form-control m-select2" id="m_select2_2" required name="salle_id">
																<option value=""></option>
															</select>
														</div>
													</div><br>
			
													<div class="form-group m-form__group row" id="jury">	
														<div class="col-6" id="divExaminateur">
															<label for=""><b>Examinateur</b></label><br><br>
															<select class="form-control m-select2" id="m_select2_8" required name="examinateur">
																<option value=""></option>
															</select>
														</div>
														<div class="col-6" id="divPresidem_select2_1
														m_select2_1nt">
															<label for=""><b>Président</b></label><br><br>
															<select class="form-control m-select2" id="m_select2_9" required name="president">
																<option value=""></option>
															</select>
														</div>				
													</div><br>
                                                </div>
                                                <div class="m-portlet__foot m-portlet__foot--fit"><br>
                                                    <div class="m-form__actions">
                                                        <div class="row">
                                                            <div class="col-12" style="display: flex; justify-content: right;">
																{{-- <button class="btn " style="margin-right: 0.5cm;"><a href="{{ route('etudiantPreSoutenance')}}">Annuler</a></button> --}}
                                                                <button type="submit" class="btn btn-success m-btn m-btn--air m-btn--custom">Programmer</button>&nbsp;&nbsp;
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><br>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
							
						<!--end::Portlet-->		

					</div>

					<!--end table -->

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

			<script src={{asset("assets/vendors/custom/datatables/datatables.bundle.js")}} type="text/javascript"></script>

		<!--end::Page Vendors -->

		<!--begin::Page Scripts -->
		<script src={{asset("assets/demo/default/custom/crud/forms/widgets/select2.js")}} type="text/javascript"></script>
		<script src={{asset("assets/app/js/dashboard.js")}} type="text/javascript"></script>

		<script>

			const fullscreenButton = document.getElementById('fullscreen-button');
			const rootElement = document.documentElement;
			let isInFullscreen = false;

			// activer/désactiver le mode plein écran
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
	
			$(document).ready(function() {
				// $('#m_select2_4').select2();

				$('#m_select2_4').on('change', function() {

					var selectedCount = $(this).val() ? $(this).val().length : 0;

					if (selectedCount > 6) {
						Swal.fire(
							'Limite de sélection dépassée',
							'Vous ne pouvez sélectionner que 6 étudiants au maximum.',
							'warning'
						);						

						$(this).val($(this).data('previous-value')).trigger('change.select2');
					} else {
						$(this).data('previous-value', $(this).val());
					}
				});

				$('#m_select2_1').on('change', function() {

					var hour = $(this).val();
					var jour = $('#datePicker').val();
					var typeSout = 'pre';
					var session = $('#m_select2_3').val();

					$.ajax({
						url: '/SallesDisponibles',
						type: 'GET',
						data: {
							horaire: hour,
							jourSoutenance: jour,
							type : typeSout,
							session_id : session
						},
						success: function(response) {
							var $select2_2 = $('#m_select2_2');

							if ('salles' in response) {
								var salleIds = response.salles;

								$.ajax({
									url: '/SallesNames',
									type: 'GET',
									data: {
										salleIds: salleIds,
									},
									success: function(responseName) {
										if ('salles' in responseName) {
											var salles = responseName.salles;

											$select2_2.empty();

											$select2_2.append($('<option>', {
												value: '',
												text: ''
											}));

											$.each(salles, function(index, salle) {
												$select2_2.append($('<option>', {
													value: salle.id,
													text: salle.nom
												}));
											});

										} else {
											// Gérez le cas où il n'y a pas de noms de salles disponibles
											$select2_2.empty().append($('<option>', {
												value: '',
												text: 'Aucune salle disponible'
											}));
										}
									},
									error: function() {
										// Gérez les erreurs
									}
								});
							} else {
								// Gérez le cas où il n'y a pas de salles disponibles
								$select2_2.empty().append($('<option>', {
									value: '',
									text: 'Aucune salle disponible'
								}));
							}
						},
						error: function() {
							// Gérez les erreurs
						}
					});

					$.ajax({
						url: '/ProfesseursDisponibles',
						type: 'GET',
						data: {
							horaire: hour,
							jourSoutenance: jour,
							type : typeSout,
							session_id : session
						},
						success: function(response) {
							var examinateursIds = response.examinateurs.map(function(professeur) {
								return professeur.prof_id;

							});

							var presidentsIds = response.presidents.map(function(professeur) {
								return professeur.prof_id;
							});

							$.ajax({
								url: '/ProfesseursNames',
								type: 'GET',
								data: {
									examinateursIds: examinateursIds,
									presidentsIds: presidentsIds
								},
								success: function(responseName) {
									if ('error' in responseName) {

										$('#m_select2_8').prop('disabled', true).empty();
										$('#m_select2_9').prop('disabled', true).empty();

									} 
									else {
										var examinateursNom = responseName.examinateurs;
										var presidentsNom = responseName.presidents;

										var $select2_8 = $('#m_select2_8');
										var $select2_9 = $('#m_select2_9');

										$select2_8.empty();
										$select2_9.empty();

										$select2_8.append($('<option>', {
											value: '',
											text: ''
										}));

										$select2_9.append($('<option>', {
											value: '',
											text: ''
										}));
										$.each(examinateursNom, function(index, examinateur) {
											$select2_8.append($('<option>', {
												value: examinateur.id,
												text: examinateur.grade_professeur.nom + ' ' + examinateur.nom + ' ' + examinateur.prenom
											}));
										});
										$.each(presidentsNom, function(index, president) {
											$select2_9.append($('<option>', {
												value: president.id,
												text: president.grade_professeur.nom + ' ' +  president.nom + ' ' + president.prenom
											}));
										});

										$('#m_select2_9').on('change', function() {
											var selectedProf = $select2_8.val();
											var selectedPresident = $select2_9.val();

											if (selectedProf === selectedPresident) {
												Swal.fire(
													'Infos!',
													'L\'examinateur et le président sont les mêmes.',
													'info'
												);
												$select2_9.val('').trigger('change');
											}
										});
										
										$('#m_select2_8').on('change', function() {
											var selectedProf = $select2_8.val();
											var selectedPresident = $select2_9.val();

											if (selectedProf === selectedPresident) {
												Swal.fire(
													'Infos!',
													'L\'examinateur et le président sont les mêmes.',
													'info'
												);
												$select2_8.val('').trigger('change');
											}
										});
							 		}

							 	},
							 	error: function() {
							 		$('#m_select2_8').empty();
							 		$('#m_select2_9').empty();
							 	}
							});
						},
						error: function() {
						}
					});

				});
			});

		</script>

	</body>

	<!-- end::Body -->
</html>