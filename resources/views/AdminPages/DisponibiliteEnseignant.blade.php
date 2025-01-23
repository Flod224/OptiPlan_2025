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
				<div class="m-grid__item m-grid__item--fluid m-wrapper">

{{-- Tableau --}}

<div class="m-content">

	<!--begin::Portlet-->

		<div class="m-portlet" >
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-calendar-with-a-clock-time-tools" style="color:blue;"></i>
						</span>
						<h3 class="m-portlet__head-text">
							Gestion de la salle
						</h3>
					</div>
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
				<form class="m-form m-form--fit m-form--label-align-right" action="{{ route('addDisponibiliteEnseignant') }}" method="POST">
					
					<div class="m-portlet__body">

						<div class="form__group m-form-group row">
							<div class="col-4">
								<label for=""><b>Session</b></label><br><br>
								<select class="form-control m-select2" id="m_select2_4" name="session_id">
	
									<option value="{{ $sessions->id }}" data-start="{{ $sessions->session_start_PreSout }}" data-end="{{ $sessions->session_end_Sout }}">
											{{ $sessions->nom }}
										</option>
							
								</select>
								@error('session_id')
									<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
							<div class="col-4">
								<label for=""><b>Type</b></label><br><br>
								<select class="form-control m-select2" id="m_select2_2" name="type_soutenance">
									<option value=""></option>
									<option value="Pre-Soutenance">Pré-Soutenance</option>
									<option value="Soutenance">Soutenance</option>
								</select>
							@error('type_soutenance')
								<div class="text-danger">{{ $message }}</div>
							@enderror
							</div>
							<div class="col-4">
								<label for=""><b>Salle</b></label><br><br>
								<select class="form-control m-select2" id="m_select2_1" placeholder="Salle" multiple="multiple" name="salle_id[]">
									<option value=""></option>
									@foreach ($salles as $salle)
										<option value="{{ $salle->id }}">{{ $salle->nom}} </option>
									@endforeach
								</select>
								@error('salle_id')
									<div class="text-danger">{{ $message }}</div>
								@enderror
							</div>
						</div><br>

						<div class="form__group m-form-group row">

							<div class="col-4">
								<label for=""><b>Jour</b></label><br><br>
								<input class="form-control m-input" id="datePicker" type="date" placeholder="Jour" name="jour">
							</div>

							@csrf
							<div class="col-4">
								<label for=""><b>Début - Fin</b></label><br><br>
								<select class="form-control m-select2" id="m_select2_3" multiple="multiple" name="horaire_id[]">
								<option value=""></option>
									@foreach ($horaire as $horaires)
										<option value="{{ $horaires->id }}">{{ $horaires->debut}} - {{ $horaires->fin}}</option>
									@endforeach
								</select>
								@error('horaire_id')
									<div class="text-danger">{{ $message }}</div>
								@enderror
															</div>
							<div class="col-4">
									<label for=""><b>Toute la journée</b></label><br><br>
									<input type="checkbox" name="all_day" value="1" @if(old('all_day', false)) checked @endif>
									@error('all_day')
										<div class="text-danger">{{ $message }}</div>
									@enderror
								</div>

							<div class="col-2">
								<label for=""><b>Actions</b></label><br><br>
								<div class="m-demo__preview m-demo__preview--btn">
									<button type="submit" class="btn btn-primary">Enregistrer</button>
								</div>
							</div>
						</div><br>
					</div>
				
				</form>
				@if(session('success'))
					<script>
						Swal.fire({
							title: 'Succès!',
							text: '{{ session('success') }}',
							icon: 'success'
						});
					</script>
				@endif
			</div>
		</div>

	<!--end::Portlet-->
	@if(session('error'))
		<script>
			Swal.fire({
				title: 'Erreur!',
				text: '{{ session('error') }}',
				icon: 'error'
			});
		</script>
	@endif
	<div class="m-portlet">
		<div class="m-portlet__body">
				
			<!--begin: Search Form -->

				<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
					<div class="row align-items-center">
						<div class="col-xl-8 order-2 order-xl-1">
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
					<div class="m-demo__preview m-demo__preview--btn" style="display: flex; margin-top: -1.2cm; margin-left: 85.5%;">
						<button type="submit" class="btn btn-primary" id="viderSallesDispo" style="width: 2.6cm;"> Vider </button>
					</div>
				</div>

			<!--end: Search Form -->

<!--begin: Datatable -->
		<table class="m-datatable" id="html_table" width="100%">
			<thead>
				<tr style="text-align: center;">
					<th>Salle</th>
					<th>Jour</th>
					<th>Disponibilités (Heures)</th>
					<th>Type</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				@foreach($disponibilites as $disponibilite)
				@if($disponibilite->horaire_id !== null) <!-- Vérifier si un horaire est associé -->
				<tr class="editable-row" data-dispo-id="{{ $disponibilite->id }}" style="text-align: center;">
					<td>
						<!-- Afficher le nom de la salle -->
						{{ $disponibilite->salle->nom }}
					</td>
					<td>{{ $disponibilite->jour }}</td>
					<td>
						<!-- Afficher l'heure associée à l'horaire -->
						@if ($disponibilite->horaire_id)
							{{ $disponibilite->horaires->debut }} - {{ $disponibilite->horaires->fin }} <!-- Vous pouvez ajuster cette ligne en fonction de la structure de votre modèle Horaires -->
						@else
							-
						@endif
					</td>
					<td>
						<!-- Afficher le type de soutenance -->
						@if($disponibilite->type_soutenance === 'Pre-Soutenance')
							Pré-soutenance
						@elseif($disponibilite->type_soutenance === 'Soutenance')
							Soutenance
						@endif
					</td>
					<td>
						<a href="#" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill deleteBtn" title="Supprimer">
							<i class="fa flaticon-delete"></i>
						</a>
					</td>
				</tr>
				@endif
				@endforeach
			</tbody>
		</table>
		<!--end: Datatable -->

		
		</div>
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
		<script src={{asset("assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js")}} type="text/javascript"></script>


		<!--end::Page Vendors -->

		<!--begin::Page Scripts -->
		<script src={{asset("assets/app/js/dashboard.js")}} type="text/javascript"></script>
		<script src={{asset("assets/demo/default/custom/crud/forms/widgets/select2.js")}} type="text/javascript"></script>
		<script src={{asset("assets/demo/default/custom/crud/metronic-datatable/base/html-table.js")}} type="text/javascript"></script>

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
					// function sessionDate() {
					// 	var selectedOption = $('#m_select2_4 option:selected');
					// 	var startDate = selectedOption.data('start');
					// 	var endDate = selectedOption.data('end');

					// 	$('#datePicker').attr('min', startDate);
					// 	$('#datePicker').attr('max', endDate);
					// }

					// $('#m_select2_4').on('change', sessionDate);

					// sessionDate();

					var $selectElement = $('#m_select2_3');
					var $allHoursOption = $selectElement.find('option[value="08H-18H"]');

					$selectElement.on('change', function () {
						if ($allHoursOption.is(':selected')) {
							// Sélectionnez toutes les heures H1 à H10
							$selectElement.find('option[value!="08H-18H"]').prop('selected', true);
						}
					});

					$('.deleteBtn').click(function (event) {
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
								var dispo_id = row.data('dispo-id');
								$.ajax({
									url: '/disponibilite/' + dispo_id,
									type: 'GET',
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
										console.log(error)
										Swal.fire(
											'Supprimé!',
											'Suppression non réussie.',
											'error'
										);
									}
								});
							}
						});

					});

					$('#viderEnsDispo').click(function() {

						var csrfToken = $('meta[name="csrf-token"]').attr('content');
						Swal.fire({

							title: 'Êtes-vous sûr?',
							text: "De vouloir tout supprimer !.",
							showCancelButton: true,
							confirmButtonColor: '#d33',
							cancelButtonColor: '#3085d6',
							confirmButtonText: 'Oui, supprimer!',
							cancelButtonText: 'Annuler'

						}).then(function (result) {
							if (result.value) {
								$.ajax({
									url: '/dispoProfsEmpty',
									method: 'POST',
									headers: {
										'X-CSRF-TOKEN': csrfToken
									},
									success: function(data) {
										Swal.fire(
											'Supprimé!',
											'Suppression réussie.',
											'success'
										).then(function () {
											location.reload();
										});
									},
									error: function(error) {
										Swal.fire(
											'Supprimé!',
											'Suppression non réussie.',
											'error'
										);
									}
								});
							}
						});

					});
				});
			</script>
		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>