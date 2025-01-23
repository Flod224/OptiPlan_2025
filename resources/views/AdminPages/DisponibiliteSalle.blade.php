@extends('app')

@section('content')
				<div class="m-grid__item m-grid__item--fluid m-wrapper">

				{{-- Tableau --}}

				<div class="m-content">
				<div class="m-portlet" >
								<div class="m-portlet__head">
									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<span class="m-portlet__head-icon">
												<i class="flaticon-placeholder " style="color:blue;"></i>
											</span>
											<h3 class="m-portlet__head-text" >
												Salles
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
									<form class="m-form m-form--fit m-form--label-align-right" action="{{ route('salleAdd') }}" method="POST">
										<div class="m-portlet__body">
											
											<div class="form-group m-form__group row">
												<div class="col-4">
													<label for=""><b>Nom</b></label>
													<input class="form-control m-input" type="text" placeholder="Nom" name="nom">
												</div>
												<div class="col-3">
													<label for=""><b>Description</b></label>
													<input class="form-control m-input" type="text" placeholder="Description" name="description">
												</div>
												<div class="col-3">
													<label for=""><b>Localisation</b></label>
													<input class="form-control m-input" type="text" placeholder="Localisation" name="localisation">
												</div>
												<div class="col-2">
													<label for=""><b>Actions</b></label><br>
													<div class="m-demo__preview m-demo__preview--btn">
														<button type="submit" class="btn btn-success">Enregistrer</button>
													</div>
												</div>
											</div>
											@csrf
											
										</div>
									</form>

									<div class="m-portlet__head-caption">
										<div class="m-portlet__head-title">
											<h5 class="m-portlet__head-text" style="color: blue; margin-left: 30px;">
												Salles enregistrées
											</h5>
										</div>
									</div>
									@foreach ($salles as $salle)
									<form action="{{ route('salleUpdate') }}" method="POST">
										@csrf
										<div class="m-portlet__body" style="margin-bottom: -48px;">
											<div class="form-group m-form__group row">
												<input class="form-control m-input" style="display: none;" type="text" value="{{$salle->id}}" name="id">
												
												<div class="col-4">
													<input class="form-control m-input" type="text" value="{{$salle->nom}}" name="nom">
												</div>
												<div class="col-3">
													<input class="form-control m-input" type="text" value="{{ $salle->description ?? '' }}" name="description" placeholder="Description de la salle">
												</div>
												<div class="col-3">
													<input class="form-control m-input" type="text" value="{{$salle->localisation ?? '' }}" placeholder="Localisation de la salle" name="localisation">
												</div>
												<div class="col-2">
													<div class="m-demo__preview m-demo__preview--btn">
														<button type="submit" class="btn btn-primary">Modifier salle</button>
													</div>
												</div>
											</div>
										</div>
									</form>	
									@endforeach
									<script>
											// Active les tooltips Bootstrap
											document.addEventListener('DOMContentLoaded', function () {
												var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
												tooltipTriggerList.map(function (tooltipTriggerEl) {
													return new bootstrap.Tooltip(tooltipTriggerEl);
												});
											});

											// Validation des dates
											document.getElementById('sessionForm').addEventListener('submit', function (event) {
												const preStart = new Date(document.getElementById('session_start_PreSout').value);
												const preEnd = new Date(document.getElementById('session_end_PreSout').value);
												const soutStart = new Date(document.getElementById('session_start_Sout').value);
												const soutEnd = new Date(document.getElementById('session_end_Sout').value);

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
									<br><br>
								</div>
							</div>

					<!--begin::Portlet-->

						<div class="m-portlet" >
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon">
											<i class="flaticon-calendar-with-a-clock-time-tools" style="color:blue;"></i>
										</span>
										<h3 class="m-portlet__head-text">
											Disponibilité de la salle
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
								<form class="m-form m-form--fit m-form--label-align-right" action="{{ route('addDisponibiliteSalle') }}" method="POST">
									
									<div class="m-portlet__body">

										<div class="form__group m-form-group row">
											<div class="col-4">
												<label for=""><b>Session</b></label><br><br>
                                                <select class="form-control m-select2" id="m_select2_4" name="session_id">
					
													<option value="{{ $session->id }}" data-start="{{ $session->session_start_PreSout }}" data-end="{{ $session->session_end_Sout }}">
															{{ $session->nom }}
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

		
		<!-- end:: Page -->


		

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
								url: '/disponibiliteSalle/' + dispo_id,
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

				$('#viderSallesDispo').click(function() {

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
								url: '/dispoSallesEmpty',
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
		@endsection