<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="utf-8" />
		<title>DefenseScheduler | Dashboard</title>
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
		{{-- <link href={{asset("assets/vendors/custom/datatables/datatables.bundle.css")}} rel="stylesheet" type="text/css" /> --}}
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
										<li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light" m-dropdown-toggle="click"
										 m-fullscreen-mode="dropdown" m-dropdown-persistent="1">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-nav__link-icon" style="font-size: 13px; width:auto;">{{$nom}} -{{$debut_presout}} - {{$fin_presout}}</span>
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
											<li class="m-menu__item " aria-haspopup="true"><a href="/PreSoutenance/{{ session('selected_session_id') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Pré-soutenance</span></a></li>
											<li class="m-menu__item m-menu__item--active " aria-haspopup="true"><a href="/EnSoutenance/{{ session('selected_session_id') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Soutenance</span></a></li>
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

						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
											Liste des étudiants
										</h3>
									</div>
								</div>
								
								<div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item"></li>
										<li class="m-portlet__nav-item">
											
										</li>
									</ul>
								</div>

							</div>
							
							<div class="m-portlet__body">
								<!--begin: Search Form -->
								<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
									<div class="row align-items-center">
										<div class="col-xl-8 ">
											<div class="form-group m-form__group row align-items-center">
												<div class="col-md-5">
													<div class="m-input-icon m-input-icon--left">
														<input type="text" class="form-control m-input" placeholder="Rechercher..." id="generalSearch">
														<span class="m-input-icon__icon m-input-icon__icon--left">
															<span><i class="la la-search"></i></span>
														</span>
													</div>
												</div>
											</div>
										</div>
									</div><br><br>

									<div style="display: flex; justify-content: space-between;">
										<div class="d-flex justify-content-around align-items-center my-3" style="display: flex; justify-content: left; gap: 15px;">
											@if($sout !== 0)
												<button class="btn btn-success" id="toutValiderBtn">Tout Valider</button>
												<button class="btn btn-danger" id="toutRejeterBtn">Tout Rejeter</button>
											@endif
										</div>

										<div style="display: flex; justify-content: right; gap: 15px">
											<div class="d-flex justify-content-around align-items-center my-3" style="display: flex; justify-content: left; gap: 15px;">
												@if(session()->has('selected_session_id'))
												<form action="{{ route('afficherPlanning') }}" method="POST" target="_blank">
													@csrf 
													<input type="hidden" name="type" value="Soutenance">
													<input type="hidden" name="session_id" value="{{ session('selected_session_id') }}">
													<button type="submit" class="btn btn-success">Afficher le planning</button>
													
												</form>

												<form id="planningForm" action="{{ route('runPlanning') }}" method="POST" target="_blank">
													@csrf 
													<input type="hidden" name="type" value="Soutenance">
													<input type="hidden" name="session_id" value="{{ session('selected_session_id') }}">
													<input type="hidden" id="choix_heuristique" name="choix_heuristique" value=""> <!-- Champ pour le choix -->
													<button type="button" class="btn btn-success" onclick="handleSubmit()">Programmer la Soutenance</button>
												</form>
												<script>
														/**
														 * Gestion de la soumission du formulaire avec choix de méthode.
														 */
														function handleSubmit() {
															// Afficher une boîte de dialogue pour demander à l'utilisateur de choisir une méthode
															Swal.fire({
																title: 'Choisissez une méthode',
																input: 'select',
																inputOptions: {
																	1: 'Méthode 1',
																	2: 'Méthode 2'
																},
																inputPlaceholder: 'Sélectionnez une méthode',
																showCancelButton: true,
																confirmButtonText: 'Valider',
																cancelButtonText: 'Annuler',
																inputValidator: (value) => {
																	return new Promise((resolve) => {
																		if (value === '1' || value === '2') {
																			resolve();
																			
																		} else {
																			resolve('Veuillez sélectionner une méthode valide.');
																		}
																	});
																	
																}
															}).then((result) => {
																
																if (result) {
																	// Si un choix valide est fait, affecter la valeur au champ caché
																	document.getElementById('choix_heuristique').value = result.value;
																	

																	// Soumettre le formulaire
																	document.getElementById('planningForm').submit();
																}
															});
														}
													</script>
												@endif
											</div>
										</div>
									</div>
									
								</div>

								<!--end: Search Form -->
								<!--begin: Datatable -->
											@if(session('error'))
												<script>
													Swal.fire({
														title: 'Erreur!',
														text: '{{ session('error') }}',
														icon: 'error'
													});
												</script>
											@endif
											<table class="m-datatable" id="html_table" width="100%">
												<thead>
													<tr style="text-align: center;">
														<th>#</th>
														<th>Matricule</th>
														<th>Nom</th>
														<th>Prénoms</th>
														<th>Cycle</th>
														<th>Thème</th>
														<th>Soutenance</th>
														<th>Verdict</th>
														<th>Document</th> <!-- New column for viewing documents -->
													</tr>
												</thead>
												
												<tbody>
													@foreach($etudiants as $etudiant)
													@if ($etudiant->is_ready >= 4 && $etudiant->is_ready <= 6)
														<tr style="text-align: center;">
															<td><span>{{ $loop->iteration }}</span></td>
															<td>{{ $etudiant->user->matricule }}</td>
															<td>{{ $etudiant->user->nom }}</td>
															<td>{{ $etudiant->user->prenom }}</td>
															<td>{{ $etudiant->niveau_etude }}</td>
															<td>{{ $etudiant->theme }} </td>
															<td>
																
																@if($etudiant->is_ready == 4)
																	<div style="background-color: lightgreen; color: white; width: 100%; font-weight: bold; padding: 5px; border-radius: 5px; text-align: center;">Prêt<i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="L'étudiant(e) est prêt(e) pour la soutenance."></i></div>
																@elseif($etudiant->is_ready == 5)
																	<div style="background-color: green; color: white; width: 100%; font-weight: bold; padding: 5px; border-radius: 5px; text-align: center;">Programmé<i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="L'étudiant(e) est programmé(e) pour la soutenance."></i></div>
															
																@elseif($etudiant->is_ready == 6)
																	<div style="background-color: blue; color: white; width: 100%; font-weight: bold; padding: 5px; border-radius: 5px; text-align: center;">Terminé<i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="L'étudiant(e) a terminé sa soutenance."></i></div>
																@endif
													
															</td>
															
															<td>
															@if($etudiant->is_ready == 5)
																	<a href="#" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill saveBtn" title="OUI" data-etudiant-id="{{ $etudiant->user_id }}">
																		<i class="fa flaticon-interface-5"></i>
																	</a>
																@endif
																@if($etudiant->is_ready == 4 || $etudiant->is_ready == 5 || $etudiant->is_ready == 6)
																	<a href="#" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill deleteBtn" title="NON" data-etudiant-id="{{ $etudiant->user_id }}">
																		<i class="fa flaticon-close "></i>
																	</a>
																@endif
															</td>

															<!-- New column for document visualization -->
															<td>
																@if($etudiant->file)  <!-- Check if the student has uploaded a file -->
																	<a href="{{ asset('pdf/' . $etudiant->file) }}" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" target="_blank" title="Voir le document">
																		<i class="fa fa-file-pdf"></i>
																	</a>
																@else
																	<span>Aucun document</span>  <!-- If no file is uploaded -->
																@endif
															</td>
													@endif

														</tr>
													@endforeach
												</tbody>
											</table>
											<!--end: Datatable -->

																		
							</div>
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
						<!-- END EXAMPLE TABLE PORTLET-->
				</div>
					<!--end table -->
				</div>
			</div>

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

			<script src={{asset("assets/demo/default/custom/crud/metronic-datatable/base/html-table.js")}} type="text/javascript"></script>

		<!--end::Page Vendors -->

		<!--begin::Page Scripts -->
		<script src={{asset("assets/app/js/dashboard.js")}} type="text/javascript"></script>
		
		<script>

			const fullscreenButton = document.getElementById('fullscreen-button');
			const rootElement = document.documentElement;
			let isInFullscreen = false;

			// Fonction pour activer/désactiver le mode plein écran
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

				$(".saveBtn").click(function(e) {
					e.preventDefault();
					var etudiantId = $(this).data("etudiant-id");

					Swal.fire({
						title: 'La décision du jury est elle OUI ?',
						text: 'Vous ne pourrez pas revenir en arrière!',
						icon: 'info',
						showCancelButton: true,
						confirmButtonText: 'Oui',
						cancelButtonText: 'Annuler'
					}).then((result) => {
						if (result.value) {
							updateEtudiantStatus(etudiantId, 1);
						}
					});
				});

				$(".deleteBtn").click(function(e) {
					e.preventDefault();
					var etudiantId = $(this).data("etudiant-id");

					Swal.fire({
						title: 'La décision du jury est elle NON ?',
						text: 'Vous ne pourrez pas revenir en arrière!',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: 'Oui',
						cancelButtonText: 'Annuler'
					}).then((result) => {
						if (result.value) {
							updateEtudiantStatus(etudiantId, -1);
						}
					});
				});

				$("#toutValiderBtn").click(function(e) {
					e.preventDefault();
					Swal.fire({
						title: 'Voulez - vous valider la pré-soutenance des étudiants de cette page ?',
						text: 'Vous ne pourrez pas revenir en arrière!',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: 'Oui',
						cancelButtonText: 'Annuler'
					}).then((result) => {
						if (result.value) {
							updateAllEtudiantsStatus(1, 'Soutenance');
						}
					});
				});

				$("#toutRejeterBtn").click(function(e) {
					e.preventDefault();
					Swal.fire({
						title: 'Voulez - vous rejetez la pré-soutenance des étudiants de cette page ?',
						text: 'Vous ne pourrez pas revenir en arrière!',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: 'Oui',
						cancelButtonText: 'Annuler'
					}).then((result) => {
						if (result.value) {
							updateAllEtudiantsStatus(-1, 'Soutenance');
						}
					});
				});


				function updateAllEtudiantsStatus(status, type) {
						$.ajax({
							type: "POST",
							url: "/update-all-etudiants-status", // URL pour le contrôleur Laravel
							data: {
								status: status,
								type: type
							},
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ajout du token CSRF
							},
							success: function (response) {
								if (response.success) {
									Swal.fire('Succès!', 'Tous les étudiants ont été mis à jour.', 'success').then(() => {
										window.location.reload(); // Rafraîchir la page après la mise à jour
									});
								} else {
									Swal.fire('Erreur!', response.message || 'Une erreur est survenue lors de la mise à jour.', 'error');
								}
							},
							error: function () {
								Swal.fire('Erreur!', 'Une erreur est survenue lors de la requête AJAX.', 'error');
							}
						});
					}


				function updateEtudiantStatus(etudiantId, status) {
					$.ajax({
						type: "POST",
						url: "/update-etudiant-status",
						data: {
							etudiantId: etudiantId,
							status: status
						},
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						success: function(response) {
							if (response.success) {
								if (status === 1) {
									$(".saveBtn[data-etudiant-id='" + etudiantId + "']").closest("td").prev().html("<div style='background-color: green; color: white; width: 2cm; font-weight: bold; padding: 5px; border-radius: 5px; margin-left: 25%;'>OUI</div>");
								} else if (status === -1) {
									$(".deleteBtn[data-etudiant-id='" + etudiantId + "']").closest("td").prev().html("<div style='background-color: red; color: white; width: 2cm; font-weight: bold; padding: 5px; border-radius: 5px; margin-left: 25%;'>NON</div>");
								}
							} else {
								Swal.fire('Erreur!', 'Erreur lors de la mise à jour du statut de l\'étudiant.', 'error');
								// return;
							}
							window.location.reload();
						},
						error: function() {
						}
					});
				}
			});
		</script>


		<!--end::Page Scripts -->
	</body>

</html>