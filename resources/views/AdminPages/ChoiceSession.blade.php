<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>SchedulerDefense | Dashboard</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: { "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"] },
            active: function () {
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

.container {
    display: flex;
	flex-direction: column;
    justify-content: center; /* Centre horizontalement */
    align-items: center; /* Centre verticalement */
    height: 100vh; /* Adapte la hauteur de la page */
    text-align: center;
    margin-top: 0; /* Supprime le décalage en haut */
}
.create-session-container {
    width: 100%;
    display: flex;
    justify-content: center;
    margin-bottom: 20px; /* Espacement avec les autres sessions */
}

.sessions-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; /* Centrer les sessions */
    gap: 20px; /* Espace entre les boîtes */
    width: 100%;
}
a{
			text-decoration: none;
			color: black;
			font-weight: 500;
		}
a:hover{
	text-decoration: none;
}
.box, .session-box {
    flex: 1 1 calc(33.33% - 20px); /* Occupe environ un tiers de la largeur */
    max-width: calc(33.33% - 20px); /* Limite la largeur */
    min-width: 250px; /* Taille minimale */
    width: 25%; /* Taille ajustée pour 4 par ligne */
    height: 2cm;
    background-color: #D7D7D7;
    padding: 40px 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.box.create-session {
    width: auto; /* Largeur adaptée au contenu */
    padding: 10px 20px; /* Ajustement des marges */
    cursor: pointer;
}

@media screen and (max-width: 768px) {
    .box, .session-box {
        flex: 1 1 100%; /* Prend toute la largeur */
        max-width: 100%; /* Largeur maximum pour mobiles */
    }
}


</style>

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-footer--push">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">

        <!-- BEGIN: Header -->
        <header id="m_header" class="m-grid__item m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
            <div class="m-container m-container--fluid m-container--full-height">
                <div class="m-stack m-stack--ver m-stack--desktop">
                    <!-- BEGIN: Brand -->
                    
					<div class="m-stack__item m-brand" style="background-color: white;">
						<div class="m-stack__item m-stack__item--middle m-brand__logo" style="display: flex; align-items: center;">
							<a href="/choiceSession" class="m-brand__logo-wrapper" style="margin-right: 10px;">
								<img alt="" src={{asset("assets/app/media/img/logos/OPTIMAID1.png")}} style="height: 1.65cm;" />
							</a>
							<span style="font-size: 18px; font-weight: 500; color: gray;">DefenseScheduler</span>
						</div>
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
		

        <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Créer une session</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
							<form class="m-form m-form--fit" method="POST" action="{{ route('sessionAdd') }}" id="sessionForm">
										@csrf
										<div class="row mb-3">
											<div class="col-12">
												<label for="nom"><b>Nom de la session</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Nom ou description de la session, par exemple : 'Session Juin 2024'."></i></label>
												<input class="form-control m-input" id="nom" type="text" placeholder="Entrez le nom de la session" name="nom" required>
												<!-- Zone pour afficher les erreurs -->
												<div id="nomError" style="color: red;"></div>
											</div>
										</div>

										<div class="row mb-3">
											<div class="col-12">
												<label for="session_start_PreSout"><b>Début des Pré-soutenances</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Date à laquelle les pré-soutenances commenceront."></i></label>
												<input id="session_start_PreSout" class="form-control m-input" type="date" name="session_start_PreSout" required>
											</div>
										</div>

										<div class="row mb-3">
											<div class="col-12">
												<label for="session_end_PreSout"><b>Fin des Pré-soutenances</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Date de fin des pré-soutenances."></i></label>
												<input id="session_end_PreSout" class="form-control m-input" type="date" name="session_end_PreSout" required>
											</div>
										</div>

										<div class="row mb-3">
											<div class="col-12">
												<label for="session_start_Sout"><b>Début des soutenances</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Date à laquelle les soutenances commenceront."></i></label>
												<input id="session_start_Sout" class="form-control m-input" type="date" name="session_start_Sout" required>
											</div>
										</div>

										<div class="row mb-3">
											<div class="col-12">
												<label for="session_end_Sout"><b>Fin des soutenances</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Date de fin des soutenances."></i></label>
												<input id="session_end_Sout" class="form-control m-input" type="date" name="session_end_Sout" required>
											</div>
										</div>

										<div class="row mb-3">
											<div class="col-12">
												<label for="nb_soutenance_max_prof"><b>Limite de soutenances par jour pour un enseignant</b> <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Nombre maximum de soutenances où un enseignant peut être membre du jury par jour."></i></label>
												<input id="nb_soutenance_max_prof" class="form-control m-input" type="number" name="nb_soutenance_max_prof" placeholder="Ex : 4" min="1" required>
											</div>
										</div>

										
									<div class="row mb-3">
										<div class="col-12">
											    <label for="grademin_licence"><b>Grade minimum pour un président du jury de licence</b><i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Grade minimum requis pour être président du jury d'une soutenance de licence."></i></label>
												<select id="grademin_licence" class="form-control m-input" name="grademin_licence" required>
													<option value="" disabled selected>-- Sélectionnez un grade --</option>
													@foreach ($grades as $grade)
													<option value="{{$grade ->id}}">{{$grade->nom}}</option>
				
													@endforeach
												</select>
											</div>
									</div>


										<div class="row mb-3">
											<div class="col-12">
												<label for="grademin_master"><b>Grade minimum pour un président du jury de master</b><i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Grade minimum requis pour être président du jury d'une soutenance de master."></i></label>
												<select id="grademin_master" class="form-control m-input" name="grademin_master" required>
													<option value="" disabled selected>-- Sélectionnez un grade --</option>
													@foreach ($grades as $grade)
													<option value="{{$grade ->id}}">{{$grade->nom}}</option>
				
													@endforeach
													
												</select>
											</div>
										</div>

										<div class="modal-footer">
										<a href="/choiceSession" ><button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Fermer </button></a>
											<button type="submit" class="btn btn-primary">Créer la session</button>
										</div>
							</form>

									<script>
										
										// Active les tooltips Bootstrap
										document.addEventListener('DOMContentLoaded', function () {
											var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
											var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
												return new bootstrap.Tooltip(tooltipTriggerEl);
											});
											});
										document.getElementById('sessionForm').addEventListener('submit', function (event) {
										const preStart = new Date(document.getElementById('session_start_PreSout').value);
										const preEnd = new Date(document.getElementById('session_end_PreSout').value);
										const soutStart = new Date(document.getElementById('session_start_Sout').value);
										const soutEnd = new Date(document.getElementById('session_end_Sout').value);

										// Vérifier si les dates sont correctes
										if (preEnd < preStart) {
											alert('La date de fin des pré-soutenances doit être postérieure à la date de début.');
											event.preventDefault();
										} else if (soutStart <= preEnd) {
											alert('La date de début des soutenances doit être postérieure à la date de fin des pré-soutenances.');
											event.preventDefault();
										} else if (soutEnd < soutStart) {
											alert('La date de fin des soutenances doit être postérieure à la date de début.');
											event.preventDefault();
										}
											});
									</script>
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


								<script>
									@if(session('success'))
									Swal.fire({
										title: 'Succès!',
										text: '{{ session('success') }}',
										icon: 'success'
									});
									@endif
									@if(session('error'))
									Swal.fire({
										title: 'erreur!',
										text: '{{ session('error') }}',
										icon: 'error'
									});
									@endif

								</script>
							</div>
							
						</div>
					</div>
				</div>
				<!-- END: Left Aside -->

				<div class="m-grid__item m-grid__item--fluid m-wrapper container">
					<div class="container">
						<div class="create-session-container">
						<a href="#" data-toggle="modal" data-target="#m_modal_1">
							<div class="box create-session">
								
									<span>Créer une nouvelle session</span>
							</div>
							</a>
						</div>
						<div class="sessions-container">
							@foreach($sessions as $session)
							<div class="session-box d-flex justify-content-between align-items-center my-3 p-3 border rounded shadow-sm">
								<a href="{{ route('infos', ['session_id' => $session->id]) }}" class="text-decoration-none text-dark">
									<span class="fw-bold">{{ $session->nom }}</span>
								</a>
								<!-- Formulaire de suppression avec SweetAlert2 -->
									<form id="delete-session-form-{{ $session->id }}" action="{{ route('deleteSession', ['session_id' => $session->id]) }}" method="POST" style="display: none;">
										@csrf
										@method('DELETE')
									</form>

									<!-- Bouton de suppression -->
									<button class="btn btn-danger delete-session" data-delete-url="{{ route('deleteSession', ['session_id' => $session->id]) }}">
										Supprimer
									</button>
							</div>

							
							@endforeach
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

    <script src={{asset("assets/vendors/base/vendors.bundle.js")}} type="text/javascript"></script>
    <script src={{asset("assets/demo/default/base/scripts.bundle.js")}} type="text/javascript"></script>
	<!--begin::Page Scripts -->
	<script src={{asset("assets/demo/default/custom/crud/forms/widgets/bootstrap-maxlength.js")}} type="text/javascript"></script>
	<script src={{asset("assets/demo/default/custom/crud/forms/widgets/select2.js")}} type="text/javascript"></script>


	<!--begin::Page Scripts -->
	<script src={{asset("assets/app/js/dashboard.js")}} type="text/javascript"></script>
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