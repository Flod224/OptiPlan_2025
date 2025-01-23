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
			<header id="m_header" class="m-grid__item m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop">

						<!-- BEGIN: Brand -->
						<div class="m-stack__item m-brand  m-brand--skin-dark ">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="/choiceSession"class="m-brand__logo-wrapper">
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
								<li class="m-menu__item  m-menu__item--submenu " aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users-1"></i> <span class="m-menu__link-text"> Étudiants </span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
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
								<li class="m-menu__item  m-menu__item--submenu m-menu__item--active" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-users-1"></i> <span class="m-menu__link-text"> Général</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
									<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
										<ul class="m-menu__subnav">
											<li class="m-menu__item m-menu__item--active" aria-haspopup="true"><a href="/Settings/{{ session('selected_session_id') }}" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">Paramètres</span></a></li>
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

					<div class="m-content">

						<!--begin::Portlet-->

							<div class="m-portlet" >
								<div class="m-portlet__head">
									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<h3 class="m-portlet__head-text" style="color: blue;">
											@foreach($sessions as $session)
												<p>
													<strong>{{ $session->nom }}</strong> : 
													Pré-soutenances du {{ \Carbon\Carbon::parse($session->session_start_PreSout)->format('d-m-Y') }} 
													au {{ \Carbon\Carbon::parse($session->session_end_PreSout)->format('d-m-Y') }}, 
													et soutenances du {{ \Carbon\Carbon::parse($session->session_start_Sout)->format('d-m-Y') }} 
													au {{ \Carbon\Carbon::parse($session->session_end_Sout)->format('d-m-Y') }}.
												</p>
											@endforeach

											</h3>
										</div>
									</div>
								</div>
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
							<div class="m-portlet" >
								<div class="m-portlet__head">
									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<span class="m-portlet__head-icon">
												<i class="flaticon-placeholder " style="color:blue;"></i>
											</span>
											<h3 class="m-portlet__head-text" >
												Sessions
											</h3>
										</div>
									</div>
									<div class="m-portlet__head-tools">
										<ul class="m-portlet__nav">
											<li class="m-portlet__nav-item">
											</li>
										</ul>
									</div>
								</div>

								<div class="m-portlet__body">
									@foreach ($sessions as $session)
									<form action="{{ route('sessUpdate') }}" method="POST" id="sessionForm">
											@csrf
											<div class="m-portlet__body">
												<!-- ID caché pour identifier la session -->
												<input class="form-control m-input" type="hidden" value="{{ $session->id }}" name="id">

												<!-- Nom de la session -->
												
												<div class="form-group m-form__group row mb-3">
													<div class="col-12">
														<label for="nom"><b>Nom de la session</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Nom ou description de la session, par exemple : 'Session Juin 2024'."></i></label>
														<input class="form-control m-input" id="nom" type="text" placeholder="Entrez le nom de la session" name="nom" value="{{ $session->nom ?? '' }}" required>
														<!-- Zone pour afficher les erreurs -->
														<div id="nomError" style="color: red;"></div>
													</div>
												</div>

												<!-- Début des Pré-soutenances -->
												<div class="form-group m-form__group row mb-3">
													<div class="col-6">
														<label for="session_start_PreSout"><b>Début des Pré-soutenances</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Date à laquelle les pré-soutenances commenceront."></i></label>
														<input id="session_start_PreSout" class="form-control m-input" type="date" name="session_start_PreSout" value="{{ $session->session_start_PreSout ?? '' }}" required>
													</div>

													<div class="col-6">
														<label for="session_end_PreSout"><b>Fin des Pré-soutenances</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Date de fin des pré-soutenances."></i></label>
														<input id="session_end_PreSout" class="form-control m-input" type="date" name="session_end_PreSout" value="{{ $session->session_end_PreSout ?? '' }}" required>
													</div>
												</div>

												<!-- Début et Fin des soutenances -->
												<div class="form-group m-form__group row mb-3">
													<div class="col-6">
														<label for="session_start_Sout"><b>Début des soutenances</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Date à laquelle les soutenances commenceront."></i></label>
														<input id="session_start_Sout" class="form-control m-input" type="date" name="session_start_Sout" value="{{ $session->session_start_Sout ?? '' }}" required>
													</div>

													<div class="col-6">
														<label for="session_end_Sout"><b>Fin des soutenances</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Date de fin des soutenances."></i></label>
														<input id="session_end_Sout" class="form-control m-input" type="date" name="session_end_Sout" value="{{ $session->session_end_Sout ?? '' }}" required>
													</div>
												</div>

												<!-- Limite de soutenances par enseignant -->
												<div class="form-group m-form__group row mb-3">
													<div class="col-12">
														<label for="nb_soutenance_max_prof"><b>Limite de soutenances par jour pour un enseignant</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Nombre maximum de soutenances où un enseignant peut être membre du jury par jour."></i></label>
														<input id="nb_soutenance_max_prof" class="form-control m-input" type="number" name="nb_soutenance_max_prof" placeholder="Ex : 4" min="1" value="{{ $session->nb_soutenance_max_prof ?? '' }}" required>
													</div>
												</div>

												<!-- Grade minimum pour le président du jury de licence -->
												<div class="form-group m-form__group row mb-3">
													<div class="col-12">
														<label for="grademin_licence"><b>Grade minimum pour un président du jury de licence</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Grade minimum requis pour être président du jury d'une soutenance de licence."></i></label>
														<select id="grademin_licence" class="form-control m-input" name="grademin_licence" required>
															<option value="" disabled>-- Sélectionnez un grade --</option>
															@foreach ($grades as $grade)
															<option value="{{ $grade->id }}" {{ $session->grademin_licence == $grade->id ? 'selected' : '' }}>
																{{ $grade->nom }}
															</option>
														@endforeach

														</select>
													</div>
												</div>

												<!-- Grade minimum pour le président du jury de master -->
												<div class="form-group m-form__group row mb-3">
												<div class="col-12">
													<label for="grademin_master">
														<b>Grade minimum pour un président du jury de master</b>
														<i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" 
														title="Grade minimum requis pour être président du jury d'une soutenance de master."></i>
													</label>
													<select id="grademin_master" class="form-control m-input" name="grademin_master" required>
														<option value="" disabled selected>-- Sélectionnez un grade --</option>
															@foreach ($grades as $grade)
																<option value="{{ $grade->id }}" 
																	{{ $session->grademin_master == $grade->id ? 'selected' : '' }}>
																	{{ $grade->nom }}
																</option>
															@endforeach
													</select>
												</div>
											</div>


											
											<!-- Bouton d'action -->
											<div class="modal-footer">
												<button type="submit" class="btn btn-primary">Modifier session</button>
											</div>
										</form>

											

									@endforeach
									<br><br>
									<script>
										document.getElementById('nom').addEventListener('input', function () {
											const sessionName = this.value;

											// Réinitialiser le message d'erreur
											const errorMessage = document.getElementById('nomError');
											if (errorMessage) errorMessage.textContent = '';

											// Vérifier si le champ est vide avant de faire la requête
											if (sessionName.trim() === '') return;

											// Requête AJAX pour vérifier l'existence du nom
											fetch(`/check-session-name?nom=${encodeURIComponent(sessionName)}`)
												.then(response => response.json())
												.then(data => {
													if (data.exists) {
														if (!errorMessage) {
															const errorDiv = document.createElement('div');
															errorDiv.id = 'nomError';
															errorDiv.style.color = 'red';
															errorDiv.textContent = 'Ce nom de session existe déjà.';
															document.getElementById('nom').after(errorDiv);
														} else {
															errorMessage.textContent = 'Ce nom de session existe déjà.';
														}
													}
												})
												.catch(error => console.error('Erreur lors de la vérification :', error));
										});
									</script>
								</div>
								<form id="delete-session-form-{{ $session->id }}" action="{{ route('deleteSession', ['session_id' => $session->id]) }}" method="POST" style="display: none;">
											@csrf
											@method('DELETE')
										</form>

										<!-- Bouton de suppression -->
										<button class="btn btn-danger delete-session" data-delete-url="{{ route('deleteSession', ['session_id' => $session->id]) }}">
											Supprimer
										</button>
							</div>
							



							<div class="m-portlet">
								<div class="m-portlet__head">
									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<span class="m-portlet__head-icon">
												<i class="flaticon-list" style="color:blue;"></i>
											</span>
											<h3 class="m-portlet__head-text">
												Spécialités
											</h3>
										</div>
									</div>
								</div>

								<div class="m-portlet__body">
									<!-- Formulaire d'ajout de spécialité -->
									<form class="m-form m-form--fit m-form--label-align-right" action="{{ route('specialiteAdd') }}" method="POST">
										@csrf
										<div class="m-portlet__body">
											<div class="form-group m-form__group row">
												<div class="col-6">
													<label for=""><b>Nom</b></label>
													<input class="form-control m-input" type="text" placeholder="Nom de la spécialité" name="name">
												</div>
												<div class="col-2">
													<label for=""><b>Actions</b></label><br>
													<div class="m-demo__preview m-demo__preview--btn">
														<button type="submit" class="btn btn-success">Enregistrer</button>
													</div>
												</div>
											</div>
										</div>
									</form>

									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<h5 class="m-portlet__head-text" style="color: blue; margin-left: 30px;">
												Spécialités enregistrées
											</h5>
										</div>
									</div>

									<!-- Liste des spécialités enregistrées -->
									<div class="container">
									@foreach ($specialites as $specialite)
										<div class="card mb-4 shadow-sm">
											<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
												<h5 class="mb-0">Spécialité : {{ $specialite->name }}</h5>
												
											</div>
											<div class="card-body">
												<!-- Formulaire de modification -->
												<form action="{{ route('specialiteUpdate') }}" method="POST" id="form_{{ $specialite->id }}">
													@csrf
													<input type="hidden" name="id" value="{{ $specialite->id }}">

													<div class="row">
														<!-- Champ pour modifier le nom -->
														<div class="col-md-6 mb-3">
															<label for="name_{{ $specialite->id }}" class="form-label">Nom de la spécialité :</label>
															<input 
																type="text" 
																class="form-control" 
																id="name_{{ $specialite->id }}" 
																name="name" 
																value="{{ $specialite->name }}" 
																required>
														</div>

														<!-- Sélection multiple pour les professeurs -->
														<div class="col-md-6 mb-3">
															<label for="professeurs_{{ $specialite->id }}" class="form-label">Sélectionnez/Désélectionnez les professeurs :</label>
															<select 
																class="form-control select2" 
																id="professeurs_{{ $specialite->id }}" 
																name="professeurs[]" 
																multiple>
																@foreach ($professeurs as $professeur)
																	@php
																		$specialities_ids = is_string($professeur->specialities_ids) 
																			? json_decode($professeur->specialities_ids, true) 
																			: $professeur->specialities_ids;
																	@endphp
																	<option value="{{ $professeur->id }}"
																		@if(is_array($specialities_ids) && in_array($specialite->id, $specialities_ids))
																			selected
																		@endif>
																		{{ $professeur->user->nom }} {{ $professeur->user->prenom }}
																	</option>
																@endforeach

															</select>
														</div>

													</div>

													<!-- Boutons d'actions -->
													<div class="d-flex justify-content-between">
														<button type="submit" class="btn btn-primary">Mettre à jour</button>
													</div>
												</form>

												<!-- Formulaire de suppression -->
												<form action="{{ route('specialiteDelete') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette spécialité ?')">
													@csrf
													<input type="hidden" name="id" value="{{ $specialite->id }}">
													<button type="submit" class="btn btn-danger mt-3">Supprimer</button>
												</form>
											</div>
										</div>
									@endforeach


									</div>

								</div>
							</div>
							<div class="m-portlet" >
								<div class="m-portlet__head">
									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<span class="m-portlet__head-icon">
												<i class="flaticon-time-1 " style="color:blue;"></i>
											</span>
											<h3 class="m-portlet__head-text">
												Horaires
											</h3>
										</div>
									</div>
									<div class="m-portlet__head-tools">
										<ul class="m-portlet__nav">
											<li class="m-portlet__nav-item">
											</li>
										</ul>
									</div>
								</div>

								<div class="m-portlet__body">
								<!-- 
									<form class="m-form m-form--fit m-form--label-align-right" action="{{ route('horaireAdd')}}" method="POST">
										<div class="m-portlet__body">
											
											<div class="form-group m-form__group row">
												<div class="col-4">
													<label for=""><b>Nom</b></label>
													<input class="form-control m-input" type="text" placeholder="Nom" value="{{ $newName }}" name="nom" readonly>
												</div>
												<div class="col-3">
													<label for=""><b>Heure de début</b></label>
													<input class="form-control m-input" type="time" placeholder="Début" value="00:00:00" name="debut" >
												</div>
												<div class="col-3">
													<label for=""><b>Heure de fin</b></label>
													<input class="form-control m-input" type="time" placeholder="Fin" value="00:00:00" name="fin">
												</div>
												<div class="col-2">
													<label for=""><b>Actions</b></label><br>
													<div class="m-demo__preview m-demo__preview--btn">
														<button type="submit" class="btn btn-success">Enregistrer</button>
													</div>
												</div>
											</div><br>
											@csrf
											
										</div>
										
									</form>
									-->
									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<h5 class="m-portlet__head-text" style="color: blue; margin-left: 30px;">
												Horaires enregistrés
											</h5>
										</div>
									</div>
									@foreach ($horaires as $horaire)
									<form>
										<div class="m-portlet__body" style="margin-bottom: -48px;">
											<div class="form-group m-form__group row">												
												<div class="col-2">
													<input class="form-control m-input" readonly style="background-color: rgb(223, 222, 222);" type="text" value="{{$horaire->nom}}" >
												</div>
												<div class="col-5">
													<input class="form-control m-input" readonly style="background-color: rgb(223, 222, 222);" type="text" value="{{$horaire->debut}}">
												</div>
												<div class="col-5">
													<input class="form-control m-input" readonly style="background-color: rgb(223, 222, 222);" type="text" value="{{$horaire->fin}}">
												</div>
											</div>
										</div>
									</form>	
									@endforeach
									<br><br>
								</div>
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
		<!-- CSS de Select2 -->
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<!-- JS de Select2 -->
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors -->
		<script src={{asset("assets/vendors/custom/fullcalendar/fullcalendar.bundle.js")}} type="text/javascript"></script>
		<script src={{asset("assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js")}} type="text/javascript"></script>


		<!--end::Page Vendors -->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-session');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const deleteUrl = this.getAttribute('data-delete-url'); // Récupère l'URL

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action supprimera définitivement la session et toutes ses données associées.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirige vers l'URL de suppression
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    });
</script>
		<script>
			document.addEventListener('DOMContentLoaded', () => {
				// Sélectionner tous les menus déroulants
				const dropdowns = document.querySelectorAll('select[multiple]');

				dropdowns.forEach(dropdown => {
					dropdown.addEventListener('change', () => {
						const form = dropdown.closest('form');
						// Soumettre automatiquement le formulaire pour enregistrer les changements
						form.submit();
					});
				});
			});
			$(document).ready(function() {
				$('.select2').select2({
					placeholder: "Sélectionnez des professeurs",
					allowClear: true
				});
			});

		</script>

		<!--begin::Page Scripts -->
			<script src={{asset("assets/app/js/dashboard.js")}} type="text/javascript"></script>
			<script>
				

				
				// Fonction pour activer le mode plein écran
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

				

				const addHoraire = document.getElementById('addHoraire');
				const addSession = document.getElementById('addSession');
				const addSalle = document.getElementById('addSalle');
				const horaireDiv = document.querySelector('.horaireDiv');
				const sessionDiv = document.querySelector('.sessionDiv');
				const salleDiv = document.querySelector('.salleDiv');


				addHoraire.addEventListener('click', (event) => {
					event.preventDefault();
					const newHoraireDiv = document.createElement('div');
					newHoraireDiv.classList.add('horaireDiv');
					newHoraireDiv.style.display = 'block';
					newHoraireDiv.innerHTML = horaireDiv.innerHTML;

					horaireDiv.parentNode.insertBefore(newHoraireDiv, horaireDiv.nextSibling);
				});

				addSession.addEventListener('click', (event) => {
					event.preventDefault();
					const newSessionDiv = document.createElement('div');
					newSessionDiv.classList.add('sessionDiv');
					newSessionDiv.style.display = 'block';
					newSessionDiv.innerHTML = sessionDiv.innerHTML;

					sessionDiv.parentNode.insertBefore(newSessionDiv, sessionDiv.nextSibling);
				});

				addSalle.addEventListener('click', (event) => {
					event.preventDefault();
					const newSalleDiv = document.createElement('div');
					newSalleDiv.classList.add('salleDiv');
					newSalleDiv.style.display = 'block';
					newSalleDiv.innerHTML = salleDiv.innerHTML;

					salleDiv.parentNode.insertBefore(newSalleDiv, salleDiv.nextSibling);
				});


				/**
				* Suppression
				*/

				const sectionContainers = document.querySelectorAll('.m-portlet__body');

				sectionContainers.forEach(container => {
					container.addEventListener('click', (event) => {
						event.preventDefault();
						const target = event.target;
						
						// Vérifiez si le bouton de suppression a été cliqué
						if (target.classList.contains('flaticon-delete')) {
							const itemDiv = target.closest('.sessionDiv, .salleDiv, .horaireDiv');
							if (itemDiv) {
								itemDiv.remove();
							}
						}
					});
				});

			</script>
			<script>
				var sessionStart = document.getElementById('session_start');
				var sessionEnd = document.getElementById('session_end');

				sessionStart.addEventListener('change', function () {
					var startDate = new Date(sessionStart.value);

					sessionEnd.min = formatDate(startDate);

					var endDate = new Date(sessionEnd.value);
					if (endDate < startDate) {
						sessionEnd.value = sessionStart.value;
					}
				});

				function formatDate(date) {
					var year = date.getFullYear();
					var month = (date.getMonth() + 1).toString().padStart(2, '0');
					var day = date.getDate().toString().padStart(2, '0');
					return year + '-' + month + '-' + day;
				}
			</script>
		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>