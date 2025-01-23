			
			
			
			@extends('app')
			
			
			
			
			@section('content')
				<div class="m-grid__item m-grid__item--fluid m-wrapper">

					<!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="m-content">
							<div class="row">
								<div class="col-lg-12">
									<!--begin:: Widgets/Stats-->

										<div class="m-portlet ">
											<div class="m-portlet__body  m-portlet__body--no-padding">
												<div class="row m-row--no-padding m-row--col-separator-xl">
													<div class="col-md-12 col-lg-6 col-xl-3">

														<!--begin::Total Profit-->
														<div class="m-widget24">
															<div class="m-widget24__item">
																<h4 class="m-widget24__title">
																	Total des étudiants
																</h4><br>
																<span class="m-widget24__desc">
																	Total
																</span>
																<span class="m-widget24__stats m--font-brand">
																	{{ $nombreTotalEtudiants }}
																</span>
															</div>
														</div>

														<!--end::Total Profit-->
													</div>
													<div class="col-md-12 col-lg-6 col-xl-3">

														<!--begin::New Users-->
														<div class="m-widget24">
															<div class="m-widget24__item">
																<h4 class="m-widget24__title">
																	Professeurs
																</h4><br>
																<span class="m-widget24__desc">
																	Professeurs
																</span>
																<span class="m-widget24__stats m--font-success">
																	{{ $nombreTotalProfesseurs }}
																</span>
																<div class="m--space-10"></div>
																<span class="m-widget24__change">
																</span>
																<span class="m-widget24__number">
																</span>
															</div>
														</div>

														<!--end::New Users-->
													</div>
													<div class="col-md-12 col-lg-6 col-xl-3">

														<!--begin::New Feedbacks-->
														<div class="m-widget24">
															<div class="m-widget24__item">
																<h4 class="m-widget24__title">
																	Étudiants
																</h4><br>
																<span class="m-widget24__desc">
																	En pré - Soutenance
																</span>
																<span class="m-widget24__stats m--font-info">
																	{{ $nombreTotalEtudiantsEnPre }}
																</span>
															</div>
														</div>

														<!--end::New Feedbacks-->
													</div>
													<div class="col-md-12 col-lg-6 col-xl-3">

														<!--begin::New Orders-->
														<div class="m-widget24">
															<div class="m-widget24__item">
																<h4 class="m-widget24__title">
																	Étudiants
																</h4><br>
																<span class="m-widget24__desc">
																	En Soutenance
																	@error('lien_whatsapp')
																		<script>
																			Swal.fire({
																			icon: 'error',
																			title: 'Erreur de validation',
																			text: 'Veuillez entrer un lien valide',
																		});
																		</script>
																	@enderror
																</span>
																<span class="m-widget24__stats m--font-danger">
																	{{ $nombreTotalEtudiantsEnSout }}
																</span>
																<div class="m--space-10"></div>
																<span class="m-widget24__change">
																</span>
																<span class="m-widget24__number">
																</span>
															</div>
														</div>

														<!--end::New Orders-->
													</div>
													
												</div>
											</div>
										</div>
										<div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Envoi du programme aux Étudiants </h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<form class="m-form m-form--fit" method="POST" action="/programmeSendEtudiants">
															<div class="col-12 row">
																<label for=""><b>Lien du groupe whatsapp</b></label><br>
																<input class="form-control m-input" name="lien_whatsapp" placeholder="Ex: htpps://" required type="text">
															</div><br>
															<input type="hidden" class="form-control m-input" name="idSess" readonly value="{{$idSess}}">
															<input type="hidden" class="form-control m-input" name="type" readonly value="{{$type}}">
															<input type="hidden" class="form-control m-input" name="year" readonly value="{{ $year }}">
															<input type="hidden" class="form-control m-input" name="month" readonly value="{{ $month }}">
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
									<!--end:: Widgets/Stats-->
									@if($type !== '' & $idSess !== '')
										<div class="m-portlet__head">
											<div class="m-portlet__head-caption">
												<div style="display: flex; justify-content: center; gap: 10px">
													<div class="m-demo__preview m-demo__preview--btn" style="display: flex; justify-content: right; gap: 15px;" >
														<button data-toggle="modal" data-target="#m_modal_1" class="btn btn-primary">Envoyez programme {{$value}} Etudiants</button>
													</div>
													{{-- <div class="m-demo__preview m-demo__preview--btn" style="display: flex; justify-content: right; gap: 15px;" >
														<button class="btn btn-primary"><a href="/programmeSendEnseignants/{{$idSess}}/{{$type}}/{{$year}}/{{$month}}" style="color: white; text-decoration: none;"> Envoyez programme {{$value}} Enseignants </a></button>
													</div> --}}
													<div class="m-demo__preview m-demo__preview--btn" style="display: flex; justify-content: right; gap: 15px;">
														<button class="btn btn-primary" onclick="confirmSendProgram()">
															Envoyer programme {{$value}} Enseignants
														</button>
													</div>
													
													<script>
														function confirmSendProgram() {
															Swal.fire({
																title: 'Confirmation',
																text: 'Êtes-vous sûr de vouloir envoyer le programme des enseignants ?',
																icon: 'question',
																showCancelButton: true,
																confirmButtonText: 'Oui',
																cancelButtonText: 'Non',
															}).then((result) => {

																if (result) {
																	window.location.href = "/programmeSendEnseignants/{{$idSess}}/{{$type}}/{{$year}}/{{$month}}";
																}
															});
														}
													</script>
												</div>
											</div>
										</div><br>
									@endif
									<div class="m-portlet">
										<div class="m-portlet__head">
											<div class="m-portlet__head-caption">
												<div class="m-portlet__head-title">
													<h3 style="margin-right: 10px;" class="m-portlet__head-text">
														Sessions
													</h3>
													<select class="form-control m-select2" id="m_select2_3" style="width: 5cm;">
														<option value=""></option>
														<option value="{{ $sessionActive->id }}" data-start="{{ $sessionActive->session_start }}" data-end="{{ $sessionActive->session_end }}">
															{{ $sessionActive->description}} du {{ \Carbon\Carbon::parse($sessionActive->session_start)->format('d-m-Y') }} au {{ \Carbon\Carbon::parse($sessionActive->session_end)->format('d-m-Y') }}
														</option>
													</select>

													<h3 style="margin-right: 10px;  margin-left: 25px;" class="m-portlet__head-text" id="sessionType">
														Type
													</h3>
													<select class="form-control m-select2" id="m_select2_4" style="width:5cm;">
														<option value=""></option>
														<option value="pre">Pre - Soutenance</option>
														<option value="sout">Soutenance</option>
													</select>
												</div>
											</div>
										</div>

										<div class="m-demo__preview m-demo__preview--btn" style="display: flex; margin-top: 1cm; justify-content: center; gap: 35px;" >
											@if($type === 'pre')
												<button class="btn btn-success"><a href="/preSoutenancePdfAvecJury/{{$idSess}}/{{$type}}" style="color: white; text-decoration: none;"> ProgrammeAvecJury </a></button>
												<button class="btn btn-success"><a href="/preSoutenancePdf/{{$idSess}}/{{$type}}" style="color: white; text-decoration: none;"> ProgrammeSansJury </a></button>

											@elseif($type === 'sout')
												<button class="btn btn-success"><a href="/soutenancePdfAvecJury/{{$idSess}}/{{$type}}" style="color: white; text-decoration: none;"> ProgrammeAvecJury </a></button>
												<button class="btn btn-success"><a href="/soutenancePdf/{{$idSess}}/{{$type}}" style="color: white; text-decoration: none;"> ProgrammeSansJury </a></button>
												<button class="btn btn-success"><a href="/pgDetaille/{{$idSess}}" style="color: white; text-decoration: none;"> ProgrammeDétaillé </a></button>
												<button class="btn btn-success"><a href="/pgByEns/{{$idSess}}" style="color: white; text-decoration: none;"> Programme par enseignants </a></button>
												<button class="btn btn-success"><a href="/pgByRooms/{{$idSess}}" style="color: white; text-decoration: none;"> Programme par salles </a></button>

											@endif
										</div>
										
										<div class="m-portlet__body">
											<div class="tab-content">
												<header class="entete">
													<div class="logo" >
														<img style="height: 6em;" src={{asset("logo_uac.png")}} alt="logo_uac" />
													</div>
											
													<div class="textSection">
														<h6> INSTITUT DE FORMATON ET DE RECHERCHE EN INFORMATIQUE DE L'UNIVERSITÉ D'ABOMEY-CALAVI <br><br> ************ <br><br> <h5> {{ $value }} DE MEMOIRES DE LICENCE ET DE MASTER SESSION DE {{ $month }} {{ $year }} </h5></h6>
													</div>
													
													<div class="logo">
														<img src={{asset("ifri1_logo.png")}} alt="logo_ifri" />
													</div>
												</header>
												<br><br>
												<main style="tableau">
													<table class="content-table">
														<thead>
															@if($type === 'pre')
															<tr>
																<th>Jury</th>
																<th>Nom & Prénoms</th>
																<th>Spécialité</th>
																<th>Date & Horaire</th>
																<th>Salle</th>
															</tr>
															@elseif($type === 'sout')
															<tr>
																<th>N°</th>
																<th>Matricule</th>
																<th>Nom & Prénoms</th>
																<th>Grade <br> Spécialité</th>
																<th>Jury</th>
																<th>Date - Horaire -<br> Salle</th>
																<th>Encadreur</th>
															</tr>
															@endif
														</thead>
														<tbody>
															@if($type === 'pre')
																@foreach ($soutenancesGroupedByExaminateurPresident as $examinateurPresident => $soutenancesExaminateurPresident)
																	<tr>
																		<td>
																			Président : 
																			@switch($filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['president']['grade'])
																				@case('Professeur')
																					Prof.
																					@break
																		
																				@case('Docteur')
																					Dr
																					@break
												
																				@case('Ingénieur')
																					Ing.
																					@break
																					
																				@default
																					{{$filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['president']['grade'] ?? 'M.' }}
																			@endswitch
																			{{-- {{ $filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['president']['grade'] }} --}}

																			{{ $filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['president']['prenom'] }} {{ $filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['president']['nom'] }}<br>
																			Examinateur : 
																			@switch($filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['examinateur']['grade'])
																				@case('Professeur')
																					Prof
																					@break
																		
																				@case('Docteur')
																					Dr
																					@break

																				@case('Ingénieur')
																					Ing
																					@break
																					
																				@default
																					{{$filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['examinateur']['grade'] ?? 'M.' }}
																			@endswitch
																			{{-- {{ $filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['examinateur']['grade'] }}  --}}
																			{{ $filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['examinateur']['prenom'] }} {{ $filieresParExaminateurPresident[$examinateurPresident]['juryInfo']['examinateur']['nom'] }} <br>
																		</td>
																		<td>
																			
																			@foreach ($soutenancesExaminateurPresident as $soutenance)
																			<a>
																				- {{ $soutenance->etudiant->user->prenom }} {{ $soutenance->etudiant->user->nom }} <br>
																			</a>
																			@endforeach
																		</td>
																		<td>
																			@php
																				$filieres = $filieresParExaminateurPresident[$examinateurPresident]['filieres']->implode(' ; ');
																				$niveaux_etude = $filieresParExaminateurPresident[$examinateurPresident]['niveau_etude']->implode(' ; ');
																				// if($niveaux_etude === 'Licence'){
																				// 	$niveaux_etude = 'LP';
																				// } else if($niveaux_etude === 'Master') {
																				// 	$niveaux_etude = 'MP';
																				// }
																				// Concaténer les deux chaînes de caractères avec un séparateur
																				$filieres_et_niveaux = $niveaux_etude . ' - ' . $filieres;
																			@endphp
												
																			{{ $filieres_et_niveaux }}
																		</td>                        
																		<td>
																			{{ \Carbon\Carbon::parse($soutenancesExaminateurPresident->first()->jour)->format('d/m/Y') }} <br><br>
																			@if ($soutenance->horaire->nom == "H1")
																			{{-- {{ \Carbon\Carbon::parse($soutenance->horaire->debut)->format('h') }} H -  {{ \Carbon\Carbon::parse($soutenance->horaire->fin)->format('h') }} H  --}}
																			08H - 13H
																			@else
																			13H - 18H
																			@endif
																		</td>

																		<td>{{ $soutenancesExaminateurPresident->first()->salle->nom }}</td>
																	</tr>
																@endforeach

															@elseif($type === 'sout')
																@foreach ($soutenances as $index => $soutenance)
																	<tr>
																		<td>{{ $index + 1 }}</td>
																		<td>{{ $soutenance->etudiant->user->matricule }}</td>
																		<td><a href="{{ route('StudentsInfos', ['id' => $soutenance->etudiant->id ]) }}">{{ $soutenance->etudiant->user->nom }} {{ $soutenance->etudiant->user->prenom }}</a></td>
																		<td>
																			@switch($soutenance->etudiant->niveau_etude)
																				@case('Licence')
																					LP
																					@break
																		
																				@case('Master')
																					MP
																					@break
																		
																				@default
																					{{ $soutenance->etudiant->niveau_etude }}
																			@endswitch - {{ $soutenance->etudiant->filiere }}
																		</td>
																		<td>
                            
																			<span style="text-decoration: underline;">Président: </span>
																			@switch($soutenance->jury->presidents->gradeProfesseur->nom)
																				@case('Professeur')
																					Prof.
																					@break
																		
																				@case('Docteur')
																					Dr
																					@break
												
																				@case('Ingénieur')
																					Ing.
																					@break
																				@default
																				{{$soutenance->jury->presidents->gradeProfesseur->nom ?? 'M.'  }}
																			@endswitch
																			{{$soutenance->jury->presidents->prenom}} {{$soutenance->jury->presidents->nom}} <br>
												
																			<span style="text-decoration: underline;">Examinateur: </span>
																			@switch($soutenance->jury->examinateurs->gradeProfesseur->nom)
																				@case('Professeur')
																					Prof.
																					@break
																		
																				@case('Docteur')
																					Dr
																					@break
												
																				@case('Ingénieur')
																					Ing.
																					@break
																				@default
																				{{$soutenance->jury->examinateurs->gradeProfesseur->nom ?? 'M.' }}
																			@endswitch
																			{{$soutenance->jury->examinateurs->prenom}} {{$soutenance->jury->examinateurs->nom}} <br>
												
																			<span style="text-decoration: underline;">Rapporteur: </span>
																			@switch($soutenance->jury->rapporteurs->gradeProfesseur->nom)
																				@case('Professeur')
																					Prof.
																					@break
																		
																				@case('Docteur')
																					Dr
																					@break
												
																				@case('Ingénieur')
																					Ing.
																					@break
																				@default
																				{{$soutenance->jury->rapporteurs->gradeProfesseur->nom ?? 'M.'}}
																			@endswitch
																			{{$soutenance->jury->rapporteurs->prenom}} {{$soutenance->jury->rapporteurs->nom}} <br>
																		</td>
																		<td>
																			{{ ucfirst(\Carbon\Carbon::parse($soutenance->jour)->isoFormat('dddd D MMMM Y', 'Do MMMM Y')) }}
																			<br> 
																			@switch($soutenance->horaire->nom)
																				@case('H1')
																					08H - 09H
																					@break
																				@case('H2')
																					09H - 10H
																					@break
																				@case('H3')
																					10H - 11H
																					@break
																				@case('H4')
																					11H - 12H
																					@break
																				@case('H5')
																					12H - 13H
																					@break
																				@case('H6')
																					13H - 14H
																					@break
																				@case('H7')
																					14H - 15H
																					@break
																				@case('H8')
																					15H - 16H
																					@break
																				@case('H9')
																					16H - 17H
																					@break
																				@case('H10')
																					17H - 18H
																					@break
																				@default
																					{{ $soutenance->horaire->nom }}
																			@endswitch
																			<br> 
																			{{ $soutenance->salle->nom }}
																		</td>
																		<td> 
																			@switch($soutenance->etudiant->professeur->gradeProfesseur->nom)
																				@case('Professeur')
																					Prof.
																					@break
																		
																				@case('Docteur')
																					Dr
																					@break
												
																				@case('Ingénieur')
																					Ing.
																					@break
																				@default
																				{{$soutenance->etudiant->professeur->gradeProfesseur->nom ?? 'M.' }}
																			@endswitch
																			{{ $soutenance->etudiant->professeur->prenom }} {{ $soutenance->etudiant->professeur->nom }}
																		</td>
																	</tr>
																@endforeach
															@endif
														</tbody>
											
													</table>
												</main>
											</div>
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

								</div>
							</div>
						</div>
					</div>

					<!-- END: Subheader -->
					
				</div>
			@endsection