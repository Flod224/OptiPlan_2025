@extends('app')
	<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	</head>
	@section('content')
				<div class="m-grid__item m-grid__item--fluid m-wrapper">
					
					<!--begin table -->
					<br>
					<div class="m-content">
						<!--begin::Portlet-->

						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon">
											<i class="flaticon-avatar"></i>
										</span>
										<h3 class="m-portlet__head-text">
											Ajouter un étudiant
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
								@csrf
									<form  action="{{ route('ajoutEtudiant') }}" method="POST">
									@csrf
										<div class="form-group m-form__group row" >
											<div class="col-3">
												<label for=""><b>Matricule</b></label>
												<input class="form-control m-input" type="text" name="matricule" placeholder="Matricule" >
											</div>
											<div class="col-3">
												<label for=""><b>Nom</b></label>
												<input class="form-control m-input" type="text" name="nom" placeholder="Nom" >
											</div>
											<div class="col-3">
												<label for=""><b>Prénoms</b></label>
												<input class="form-control m-input" type="text" name="prenom" placeholder="Prénoms" >
											</div>
											<div class="col-3">
												<label for=""><b>Email</b></label>
												<input class="form-control m-input" type="email" name="email" placeholder="Email" >
											</div>
											
											<div class="col-3">
												<label for=""><b>Télephone</b></label>
												<input class="form-control m-input" type="tel" placeholder="+229 12345678" name="phone">

											</div>
										
											<div class="col-3">
												<label for=""><b>Cycle </b></label>
												<select class="form-control m-select2" name="cycle" id="m_select2_1" placeholder="Cycle">
													<option value=""></option>
													<option value="Licence">Licence</option>
													<option value="Master">Master</option>

												</select>
											</div>
											<div class="col-3">
												<label for=""><b>Spécialités</b></label>
												<select class="form-control m-select2" id="m_select2_2" placeholder="Spécialités" name="specialitie_id">
													@foreach ($specialities as $specialitie)
														<option value="{{ $specialitie->id }}">{{ $specialitie->name }}</option>
													@endforeach
												</select>  
											</div>

											<div class="col-3">
												<label for=""><b>Action </b></label>
												<div class="m-demo__preview m-demo__preview--btn">
													<button type="submit" class="btn btn-primary">Ajouter un étudiant</button>
												</div>
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
						</div>

						<!--end::Portlet-->

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
											<a href="#" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill m-btn--air" data-skin="dark" data-placement="bottom" data-toggle="modal" data-target="#m_modal_1" title="Importer le fichier">
												<i class="fa flaticon-file-2"></i>
											</a>
										</li>
									</ul>
								</div>
	
								<!--begin::Modal-->
									<div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											@if(session('error'))
												<script>
													Swal.fire({
														title: 'Erreur!',
														text: '{{ session('error') }}',
														icon: 'error'
													});
												</script>
											@endif
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Importer le fichier</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
																						
													<!--begin::Form-->
													<form class="m-form m-form--fit m-form--label-align-right" action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
														<div class="custom-file">
															<input type="file" name="fileStudents" id="customFile" accept=".xls, .xlsx, .csv">
															<label class="custom-file-label" for="customFile">Choisir un fichier</label>
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
								</div>

								<!--end: Search Form -->
								<!--begin: Datatable -->
								<table class="m-datatable" id="htable" width="100%">
									<thead>
										<tr style="text-align: center;">
											<th scope="col">#</th>
											<th scope="col">Matricule</th>
											<th scope="col">Nom</th>
											<th scope="col">Prénoms</th>
											<th scope="col">Cycle</th>
											<th scope="col">Filière</th>
											<th scope="col">Email</th>
											<th scope="col">Actions</th>
										</tr>
									</thead>
									
									<tbody>
										@foreach($etudiants as $etudiant)
										<tr class="editable-row" data-etudiant-id="{{ $etudiant->user->id }}" style="text-align: center;">

											<td><span >{{ $loop->iteration }}</span></td>
											<td><span class="editable" data-field-name="matricule" data-original-value="{{ $etudiant->user->matricule }}">{{ $etudiant->user->matricule }}</span></td>
											<td><span class="editable" data-field-name="nom" data-original-value="{{ $etudiant->user->nom }}">{{ $etudiant->user->nom }}</span></td>
											<td><span class="editable" data-field-name="prenom" data-original-value="{{ $etudiant->user->prenom }}">{{ $etudiant->user->prenom }}</span></td>
											<td><span class="editable" data-field-name="niveau_etude" data-original-value="{{ $etudiant->niveau_etude }}">{{ $etudiant->niveau_etude }}</span></td>
											<td>
												<span class="editable" data-field-name="speciality_id" data-original-value="{{ $etudiant->specialities ? $etudiant->specialities->name : 'Non défini' }}">
													{{ $etudiant->specialities ? $etudiant->specialities->name : 'Non défini' }}
												</span>
											</td>


											<td><span class="editable" data-field-name="email" data-original-value="{{ $etudiant->user->email }}">{{ $etudiant->user->email }}</span></td>
											<td>
											<a href="#"
													class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill editBtn"
													title="Modifier"
													data-toggle="modal"
													data-target="#editStudentModal"
													data-etudiant-id="{{ $etudiant->id }}"
													data-nom="{{ $etudiant->user->nom }}"
													data-prenom="{{ $etudiant->user->prenom }}"
													data-email="{{ $etudiant->user->email }}"
													data-matricule="{{ $etudiant->user->matricule }}"
													data-niveau-etude="{{ $etudiant->niveau_etude }}"
													data-speciality-id="{{ $etudiant->speciality_id }}">
													<i class="fa flaticon-edit"></i>
													</a>

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

						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				<!--end table -->
				</div>
			</div>
			<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('updateEtudiant', ['id' => ':id']) }}" id="edit-student-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Modifier les informations de l'étudiant</h5>
					<button type="button" class="close" aria-label="Close" onclick="window.location.href='/Etudiant'">
						<span aria-hidden="true">&times;</span>
					</button>

									</div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="modal-nom" class="col-sm-4 col-form-label">Nom :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="modal-nom" name="nom" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="modal-prenom" class="col-sm-4 col-form-label">Prénom :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="modal-prenom" name="prenom" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="modal-email" class="col-sm-4 col-form-label">Email :</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="modal-email" name="email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="modal-matricule" class="col-sm-4 col-form-label">Matricule :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="modal-matricule" name="matricule" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="modal-niveau-etude" class="col-sm-4 col-form-label">Cycle :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="modal-niveau-etude" name="niveau_etude" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="modal-speciality-id" class="col-sm-4 col-form-label">Spécialité :</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="modal-speciality-id" name="speciality_id" required>
                                @foreach($specialities as $speciality)
                                    <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
					<a href="/Etudiant" ><button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Annuler </button></a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end:: Body -->

			

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

		<!--end::Page Vendors -->

		

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
			isInFullscreen = !isInFullscreen; // Inverser l'état du mode plein écran
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
				$(document).ready(function () {
					/**
					 * Bouton de modification (mode inline) : Passe les champs de la ligne en mode éditable.
					 */
					$('.editBtn').click(function (event) {
						event.preventDefault();

						var row = $(this).closest('.editable-row');
						row.find('.editable').each(function () {
							var originalValue = $(this).data('original-value');
							var fieldName = $(this).data('field-name');

							// Créer un champ input pour la saisie
							var input = $('<input>', {
								type: 'text',
								class: 'edit-input form-control m-input',
								value: originalValue,
								style: 'height:1cm; width:4cm; text-align:center;',
								'data-field-name': fieldName
							});

							// Remplacer l'élément original par l'input
							$(this).replaceWith(input);
						});

						// Afficher/Masquer les boutons Modifier et Sauvegarder
						row.find('.editBtn').hide();
						row.find('.saveBtn').show();
					});

					/**
					 * Bouton de sauvegarde : Envoie les modifications au serveur.
					 */
					$(document).on('click', '.saveBtn', function (event) {
					event.preventDefault();

					// Récupérer l'ID de l'étudiant depuis le champ caché ou data attribut
					let etudiantId = $('#modal-etudiant-id').val();

					// Construire l'URL dynamique
					let url = `/etudiants/${etudiantId}`;

					console.log('URL générée pour la mise à jour:', url); // Vérifiez ici que l'ID est bien correct

					// Envoyer les données du formulaire via AJAX
					$.ajax({
						url: url,
						type: 'POST',
						data: $('#edit-student-form').serialize(), // Sérialiser les données du formulaire
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ajouter le token CSRF
						},
						success: function (response) {
							console.log('Réponse du serveur:', response);
							Swal.fire('Succès!', 'Modification effectuée avec succès.', 'success')
								.then(function () {
									location.reload(); // Recharger la page pour voir les mises à jour
								});
						},
						error: function (error) {
							console.log('Erreur serveur:', error);
							Swal.fire('Erreur!', 'La modification a échoué.', 'error');
						}
					});
				});


						

						// Stop si une validation échoue
						if (!valid) return;

						// Requête AJAX pour sauvegarder les données
						$.ajax({
							url: '/etudiants/' + etudiant_id,
							type: 'POST',
							data: newData,
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							success: function (response) {
								Swal.fire(
									'Succès!',
									'Modification effectuée avec succès.',
									'success'
								).then(function () {
									location.reload();
								});
							},
							error: function (error) {
								Swal.fire(
									'Erreur!',
									'La modification a échoué.',
									'error'
								).then(function () {
									location.reload();
								});
							}
						});

						// Afficher/Masquer les boutons Modifier et Sauvegarder
						row.find('.editBtn').show();
						row.find('.saveBtn').hide();
					});

					/**
					 * Pré-remplir les champs de la modale avec les données existantes.
					 */
					$(document).on('click', '.editBtn', function () {
					// Récupérer l'ID de l'étudiant
					let etudiantId = $(this).data('etudiant-id');
					
					// Mettre à jour dynamiquement l'attribut action du formulaire
					let formAction = `/etudiants/${etudiantId}`;
					$('#edit-student-form').attr('action', formAction);
					
					// Log pour vérifier
					console.log('Form action mis à jour :', formAction);

					// Pré-remplir les champs de la modale
					$('#modal-etudiant-id').val(etudiantId);
					$('#modal-nom').val($(this).data('nom'));
					$('#modal-prenom').val($(this).data('prenom'));
					$('#modal-email').val($(this).data('email'));
					$('#modal-matricule').val($(this).data('matricule'));
					$('#modal-niveau-etude').val($(this).data('niveau-etude'));
					$('#modal-speciality-id').val($(this).data('speciality-id'));
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
									var etudiant_id = row.data('etudiant-id');

									// Send a DELETE request
									$.ajax({
										url: '/etudiant/' + etudiant_id,
										type: 'DELETE',  
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

				});

		</script>

		@endsection
			

		