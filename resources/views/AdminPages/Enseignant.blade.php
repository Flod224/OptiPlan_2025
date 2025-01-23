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
		<link href={{asset("assets/vendors/custom/datatables/datatables.bundle.css")}} rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href={{asset("assets/app/media/img/logos/OPTIMAID1.png")}} />

	</head>
	<style>
		#loadingOverlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(56, 56, 56, 0.8);
			z-index: 1000;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.loading-spinner {
			text-align: center;
		}
		.loading{
			font-size: 18px;
			color: white;
		}
		.checkbox{
			cursor: pointer;
		}

	</style>
	
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<div id="loadingOverlay" style="display: none;">
			<div class="loading-spinner">
				<span class="loading">Veuillez patienter...</span>
			</div>
		</div>
		
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
								<li class="m-menu__item m-menu__item--active  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-avatar "></i> <span class="m-menu__link-text"> Enseignants</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
										<ul class="m-menu__subnav">
											<li class="m-menu__item m-menu__item--active " aria-haspopup="true"><a href="/Enseignant" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Tous les enseignants</span></a></li>
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
					<div class="m-content">
						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon">
											<i class="flaticon-avatar"></i>
										</span>
										<h3 class="m-portlet__head-text">
											Ajouter un enseignant
										</h3>
									</div>
								</div>
								<div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
									</ul>
								</div>
							</div>

							<div class="m-portlet__body">
								@if ($errors->any())
									<script>
										var missingFields = [];
										@foreach ($errors->all() as $error)
											missingFields.push('{{ $error }}');
										@endforeach

										Swal.fire({
											title: 'Erreur!',
											html: missingFields.join('<br>'),
											icon: 'error'
										});
									</script>
								@endif
								<div class="modal-body">
									<form action="{{ route('ajoutProfesseur') }}" method="POST">
										@csrf

										<div class="form-group m-form__group row">
											<input class="form-control m-input" type="text" style="display: none;" placeholder="Matricule" value="{{ $newMatricule }}" name="matricule" readonly>

											<div class="col-3">
												<label for=""><b>Matricule</b></label>
												<input class="form-control m-input" type="text" placeholder="Matricule" name="matricule">
											</div>
											
											<div class="col-3">
												<label for=""><b>Nom</b></label>
												<input class="form-control m-input" type="text" placeholder="Nom" name="nom">
											</div>

											<div class="col-3">
												<label for=""><b>Prénoms</b></label>
												<input class="form-control m-input" type="text" placeholder="Prénoms" name="prenom">
											</div>

											<div class="col-3">
												<label for=""><b>Sexe</b></label>
												<select class="form-control m-select2" id="m_select2_3" placeholder="Sexe" name="sexe">
													<option value=""></option>
													<option value="M">Masculin</option>
													<option value="F">Féminin</option>
												</select>  
											</div>

											<div class="col-3">
												<label for=""><b>Email</b></label>
												<input class="form-control m-input" type="email" placeholder="Email" name="email">
											</div>
											<div class="col-3">
												<label for=""><b>Télephone</b></label>
												<input class="form-control m-input" type="tel" placeholder="+229 12345678" name="phone">

											</div>
									
											<div class="col-3">
												<label for=""><b>Grade</b></label>
												<select class="form-control m-select2" id="m_select2_1" placeholder="Grade" name="grade">
													<option value=""></option>
													@foreach ($grades as $grade)
														<option value="{{ $grade->id }}">{{ $grade->nom }}</option>
													@endforeach
												</select>
											</div>

											<div class="col-3">
												<label for=""><b>Spécialités</b></label>
												<select class="form-control m-select2" id="m_select2_2" placeholder="Spécialités" name="specialities_ids[]" multiple>
													@foreach ($specialites as $specialite)
														<option value="{{ $specialite->id }}">{{ $specialite->name }}</option>
													@endforeach
												</select>  
											</div>

											<div class="col-4">
												<label for=""><b>Action</b></label>
												<div class="m-demo__preview m-demo__preview--btn">
													<button type="submit" class="btn btn-primary">Ajouter un enseignant</button>
												</div>
											</div>
									
									</form>

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


						<!--end::Portlet-->
						
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
											Liste des enseignants
										</h3>
									</div>
								</div>
								
								<div class="m-portlet__head-tools">
									<ul class="m-portlet__nav">
										<li class="m-portlet__nav-item"></li>
										<li class="m-portlet__nav-item">
											<a href="#" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill m-btn--air" data-skin="dark" data-placement="bottom" data-toggle="modal" data-target="#m_modal_1" title="Importer le fichier">
												<i class="fa flaticon-file-2"></i>
											</a>
										</li>
									</ul>
								</div>
	
								<!--begin::Modal-->
									<div class="modal fade" tabindex="-1" id="m_modal_1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<script>
												@if(session('error'))
												Swal.fire({
													title: 'Erreur!',
													text: '{{ session('error') }}',
													icon: 'error'
												});
												@endif
											</script>
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Importer le fichier</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
																						
													<!--begin::Form-->
													<form class="m-form m-form--fit m-form--label-align-right" action="{{ route('importTeachers') }}" method="POST" enctype="multipart/form-data">
														<div class="custom-file"> 
															<input type="file" name="fileTeachers" id="customFile" accept=".xls, .xlsx, .csv">
															<label class="custom-file-label" for="customFile">Importer le fichier</label>
														</div>
														<div class="m-form__actions" style="display: flex; justify-content: right;">
															<button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-right: 15px;">Fermer</button>
															<button type="submit" class="btn btn-primary">Importer</button>
														</div>
														@csrf
													</form>

													<!--end::Form-->
												</div>
											</div>
										</div>
									</div>
		
								<!--end::Modal-->

							</div>
							
							<div class="m-portlet__body">
								
								<!--begin: Search Form -->

									<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
										<div class="row">
											<div class="col-xl-8">
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
										</div>
										{{-- <div class="m-form__actions" style="float: right;">
											<a data-toggle="modal" id="envoyerEmail" class="btn btn-primary" style="color: white;">Vérifier DisponibilitéProf</a>
										</div> --}}
									</div>

								<!--end: Search Form -->

								<!--begin: Datatable -->
								<div class="modal fade infosSout" id="m_modal_2" tabindex="-1" role="dialog" aria-labelledby="SessionInfos" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="SessionInfos">Session</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<form class="m-form m-form--fit">
													<div class="col-12 row">
														<label for=""><b>Session</b></label><br>
														<input class="form-control m-input" type="text" name="nameSession" placeholder="Session">
													</div><br>
													<div class="col-12 row">
														<label for=""><b>Soutenance</b></label><br>
														<input class="form-control m-input" type="text" name="typeSout" placeholder="Pré-Soutenance ou Soutenance" >
													</div><br>
													<div class="col-12 row">
														<label for=""><b>Jour(s)</b></label><br>
														<input class="form-control m-input" type="text" name="jours" placeholder="Jour(s)" >
													</div><br>  
													@csrf
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
														<button type="submit" id="envoyerMailBtn" class="btn btn-primary">Envoyer</button>
													</div>
												</form>
											</div>
											
										</div>
									</div>
								</div>

								<table class="m-datatable" id="htable" style="width: 100%;">
									
									<thead>
										<tr style="text-align: center;">

											<th scope="col">Matricule</th>
											<th scope="col">Nom</th>
											<th scope="col">Prénoms</th>
											<th scope="col">Email</th>
											<th scope="col">Actions</th>
										</tr>
									</thead>

									<tbody>
										@foreach($professeurs as $professeur)
										<tr class="editable-row" data-professeur-id="{{ $professeur-> user->id }}" style="text-align: center;">
											<td><span  data-field-name="matricule" data-original-value="{{ $professeur->user->matricule }}">{{ $professeur->user->matricule }}</span></td>
											<td><span class="editable" data-field-name="nom" data-original-value="{{ $professeur->user->nom }}">{{ $professeur->user->nom }}</span></td>
											<td><span class="editable" data-field-name="prenom" data-original-value="{{ $professeur->user->prenom }}">{{ $professeur->user->prenom }}</span></td>
											<td><span class="editable" data-field-name="email" data-original-value="{{ $professeur->user->email }}">{{ $professeur->user->email }}</span></td>
											<td>
												<a href="" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill deleteBtn" title="Supprimer">
													<i class="fa flaticon-delete"></i>
												</a>
												
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								<!--end: Datatable -->
							
							</div>
						</div>

						

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
			<script src={{asset("assets/demo/default/custom/crud/metronic-datatable/base/html-table.js")}} type="text/javascript"></script>
			<script src={{asset("assets/demo/default/custom/crud/forms/widgets/select2.js")}} type="text/javascript"></script>
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
	
				document.getElementById("customFile").addEventListener("change", function(event) {
					const input = event.target;
					const label = input.nextElementSibling;
					const fileName = input.files[0].name;
					label.innerHTML = fileName;
				});

			</script>

			<script>

				$(document).ready(function () 
				{
					$('.deleteBtn').click(function (event) 
					{
							event.preventDefault();
							var row = $(this).closest('.editable-row');

							Swal.fire({
								title: 'Êtes-vous sûr?',
								text: "De vouloir effectuer la suppression !.",
								showCancelButton: true,
								confirmButtonColor: '#d33',
								cancelButtonColor: '#3085d6',
								confirmButtonText: 'Oui, supprimer!',
								cancelButtonText: 'Annuler'

							}).then(function (result) {
								if (result.value) {
									var professeur_id = row.data('professeur-id');

									// Send a DELETE request
									$.ajax({
										url: '/professeur/' + professeur_id,
										type: 'DELETE',  // Changed to DELETE
										data: {
											_token: $('meta[name="csrf-token"]').attr('content') // CSRF token for security
										},
										success: function (response) {
											row.remove();
											Swal.fire(
												'Supprimé!',
												'Suppression réussie.',
												'success'
											).then(function () {
												location.reload();
											});
										},
										error: function (error) {
											Swal.fire(
												'Erreur!',
												'Une erreur est survenue lors de la suppression.',
												'error'
											);
										}
									});
								}
							});
						});
					
					$('#envoyerEmail').click(function() {
						var casesProf = $('.checkbox:checked');
						
						if (casesProf.length === 0) {
							Swal.fire(
								'Infos',
								'Sélectionnez au moins un enseignant',
								'info'
							);
							return;
						}

						// Afficher la modal
						$('#envoyerEmail').attr('data-target', '#m_modal_2');
        				$('#m_modal_2').modal('show');
					});

					$('#envoyerMailBtn').click(function() {
					 	$('#loadingOverlay').show();
						var casesProf = $('.checkbox:checked');
						var emails = casesProf.map(function() {
							return $(this).data('email');
						}).get();

						// Récupérer les valeurs du formulaire
						var nameSession = $('input[name="nameSession"]').val();
						var typeSout = $('input[name="typeSout"]').val();
						var jours = $('input[name="jours"]').val();

						$.ajax({
							url: '/dispoMailProf',
							method: 'POST',
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							data: {
								emails: emails,
								nameSession: nameSession,
								typeSout: typeSout,
								jours: jours
							},
							success: function(data) {
								console.log(data)
								Swal.fire(
									'Envoi!',
									'Mail envoyé avec succès.',
									'success'
								).then(function () {
									location.reload();
								});
							},
							error: function() {
								Swal.fire(
									'Erreur!',
									'Erreur lors de l\'envoi des mails. Vérifiez votre connexion internet',
									'error'
								).then(function () {
									location.reload();
								});
							},
							complete: function() {
								$('#loadingOverlay').hide();
							}
						});
					});

				});

			</script>

		<!--end::Page Scripts -->

	</body>

	<!-- end::Body -->
</html>