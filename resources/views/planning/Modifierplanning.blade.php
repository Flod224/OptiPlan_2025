<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Planning </title>
 
    <!-- Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
 
    <!-- CSS Libraries -->
    <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{ asset('assets/app/media/img/logos/OPTIMAID1.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
 
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>
 
    <style>
        .dropdown-content {
            display: none;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
        }
        .dropdown-title {
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .action-buttons {
            margin-bottom: 20px;
        }
        table thead th {
            text-align: center;
            font-weight: bold;
        }
        .btn {
            margin-left: 10px;
        }
    </style>
</head>
 
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-footer--push">
 
    <!-- Header -->
    <header id="m_header" class="m-grid__item m-header" m-minimize-offset="200" m-minimize-mobile-offset="200">
        <div class="m-container m-container--fluid m-container--full-height">
            <div class="m-stack m-stack--ver m-stack--desktop">
                <div class="m-stack__item m-brand" style="background-color: white;">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo" style="display: flex; align-items: center;">
                        <a href="/AdminDashboard" class="m-brand__logo-wrapper" style="margin-right: 10px;">
                            <img alt="" src="{{ asset('assets/app/media/img/logos/OPTIMAID1.png') }}" style="height: 1.65cm;" />
                        </a>
                        <span style="font-size: 18px; font-weight: 500; color: gray;">DefenseScheduler</span>
                    </div>
                </div>
                <div id="m_header_topbar" class="m-topbar m-stack m-stack--ver m-stack--general m-stack--fluid">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item">
                                <a href="{{ route('deconnexion') }}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder" style="background-color: rgb(174, 228, 174); margin-top: 18px;">Déconnexion</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <br><br><br>

    <div class="container mt-5">
        <h1 class="text-center">Modification du Planning de {{$type }}</h1>
        <div class="action-buttons d-flex justify-content-end">
            <button id="openAll" class="btn btn-success">Open All</button>
            <button id="closeAll" class="btn btn-danger">Close All</button>
            
        </div>
        
       
       
        <div class="container mt-4">
            <!-- Afficher un message d'erreur -->
            @if (isset($error))
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        
            <!-- Afficher les plannings s'ils existent -->
            
                <div class="table-responsive">
                    
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                @foreach ($soutenances as $jour => $soutenances_jour)
                                    <th scope="col">{{ ucfirst($jour) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @foreach ($soutenances as $jour => $soutenances_jour)
                                <td>
                                    @foreach ($soutenances_jour as $soutenance)
                                    <form action="{{ route('updateSoutenance') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="soutenance_id" value="{{$soutenance['id']}}" />
                                        
                                        <div class="dropdown card mb-3">
                                            <div class="dropdown-title card-body">
                                                <h5 class="card-title">Modifier la soutenance de {{ $soutenance['etudiant_nom'] }} : </h5>
                                            </div>
                                            <div class="dropdown-content">
                                                <p class="card-text">
                                                    <label for="theme-{{ $soutenance['id'] }}"><strong>Thème :</strong></label>
                                                    <input type="text" id="theme-{{ $soutenance['id'] }}" name="theme" class="form-control" value="{{ $soutenance['theme'] }}" required>
                                                    
                                                    <label for="etudiant_nom-{{ $soutenance['id'] }}"><strong>Étudiant :</strong></label>
                                                    <input type="text" id="etudiant_nom-{{ $soutenance['id'] }}" name="etudiant_nom" class="form-control" value="{{ $soutenance['etudiant_nom'] }}" required>
                                                    
                                                    <!-- Jour -->
                                                    <label for="jour_id-{{ $soutenance['id']  }}"><strong>Jour :</strong></label>
                                                            <select id="jour_id-{{ $soutenance['id'] }}" name="jour" class="form-control" required>
                                                                
                                                                @foreach ($days as $jour)
                                                                    <option value="{{ $jour }}" {{ $jour == $soutenance['jour'] ? 'selected' : '' }}>{{ $jour}}</option>
                                                                @endforeach
                                                            </select>

                                                    <label for="plage_horaire-{{ $soutenance['id'] }}"><strong>Plage Horaire :</strong></label>

                                                        <select id="plage_horaire-{{ $soutenance['id'] }}" name="plage_horaire" class="form-control" required>
                                                            @foreach ($horaire as $plagehoraire)
                                                                <option value="{{ $plagehoraire['id'] }}" {{ $plagehoraire['id'] == $soutenance['horaire_id'] ? 'selected' : '' }}>
                                                                    {{ $plagehoraire['debut'] }} - {{ $plagehoraire['fin'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    <label for="salle_nom-{{ $soutenance['id'] }}"><strong>Salle :</strong></label>
                                                    <select id="salle_nom-{{ $soutenance['id'] }}" name="salle_id" class="form-control" required>
                                                            @foreach ($salles as $salle)
                                                                <option value="{{ $salle['id'] }}" {{ $salle['nom'] == $soutenance['salle_nom'] ? 'selected' : '' }}>
                                                                    {{ $salle['nom'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                </p>
                                                <p><strong>Jury :</strong></p>
                                                <ul>
                                                    <li>
                                                        <label for="president_nom-{{ $soutenance['id'] }}"><strong>Président :</strong></label>
                                                        <select id="president_nom-{{ $soutenance['id'] }}" name="president" class="form-control" required>
                                                            @foreach ($enseignants as $enseignant)
                                                                <option value="{{ $enseignant->id }}" {{ $soutenance['president']== $enseignant->id ? 'selected' : '' }}>
                                                                    {{ $enseignant->user->nom }} {{ $enseignant->user->prenom }}    {{ $enseignant->grade }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <label for="examinateur_nom-{{ $soutenance['id'] }}"><strong>Examinateur :</strong></label>
                                                        <select id="examinateur_nom-{{ $soutenance['id'] }}" name="examinateur" class="form-control" required>
                                                            @foreach ($enseignants as $enseignant)
                                                                <option value="{{ $enseignant->id }}" {{ $soutenance['examinateur']== $enseignant->id ? 'selected' : '' }}>
                                                                    {{ $enseignant->user->nom }} {{ $enseignant->user->prenom }} {{ $enseignant->grade }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </li>
                                                    <li>
                                                        <label for="rapporteur_nom-{{ $soutenance['id'] }}"><strong>Rapporteur :</strong></label>
                                                        <select id="rapporteur_nom-{{ $soutenance['id'] }}" name="rapporteur" class="form-control" required>
                                                            @foreach ($enseignants as $enseignant)
                                                                <option value="{{ $enseignant->id }}" {{$soutenance['rapporteur']== $enseignant->id ? 'selected' : '' }}>
                                                                    {{ $enseignant->user->nom }} {{ $enseignant->user->prenom }}   {{ $enseignant->grade }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </li>
                                                </ul>
                                                <input type="hidden" name="type" value="{{ $type }}">
                                                <input type="hidden" name="session_id" value="{{ $selectedSessionId }}" />
                                                <div class="text-center mt-3">
                                                  <button type="submit" class="btn btn-success" id="submitFormButton">Enregistrer les modifications</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </form>
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                    </tbody>


                    </table>
                   
                    
                    @if (isset($etudiants_nonProgrammes) && !empty($etudiants_nonProgrammes))
                        
                            <div class="dropdown card mb-4">
                                            <!-- Titre cliquable -->
                                <div class="dropdown-title card-header">
                                <h5>Étudiants non programmés</h5>
                            </div>
                            <div class="card-body dropdown-content">
                            <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col">Étudiant</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($etudiants_nonProgrammes as $etudiant)
                                            <tr>
                                                <!-- Nom de l'étudiant -->
                                                <td>
                                                    <strong>
                                                    @if ($etudiant->user)
                                                        <a href="javascript:void(0)" onclick="toggleForm('{{ $etudiant->id }}')">
                                                            {{ $etudiant->user->nom }} {{ $etudiant->user->prenom }}
                                                        </a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="toggleForm('{{ $etudiant->id }}')">
                                                        <span>Utilisateur non associé</span>
                                                        </a>
                                                    @endif
                                                    </strong>
                                                </td>

                                                <!-- Formulaire masqué initialement -->
                                                <td>
                                                    <div id="form-{{ $etudiant->id }}" style="display: none;">
                                                    <form action="{{ route('storeSoutenance') }}" method="POST" id="juryForm-{{ $etudiant->id }}">
                                                            @csrf
                                                            <input type="hidden" name="etudiant_id" value="{{ $etudiant->id }}">
                                                            <input type="hidden" name="type" value="{{ $type }}">
                                                            <input type="hidden" name="session_id" value="{{ $selectedSessionId }}" />
                                                            
                                                            <!-- Thème -->
                                                            <label for="theme-{{ $etudiant->id }}"><strong>Thème :</strong></label>
                                                            <input type="text" id="theme-{{ $etudiant->id }}" name="theme" class="form-control"
                                                                value="{{ old('theme', $etudiant->theme) }}" required>
                                                            
                                                            <!-- Jour -->
                                                            <label for="jour_id-{{ $etudiant->id }}"><strong>Jour :</strong></label>
                                                            <select id="jour_id-{{ $etudiant->id }}" name="jour" class="form-control" required>
                                                                <option value="" disabled {{ old('jour') ? '' : 'selected' }}>Sélectionnez un jour</option>
                                                                @foreach ($days as $jour)
                                                                    <option value="{{ $jour }}" {{ old('jour') == $jour ? 'selected' : '' }}>{{ $jour }}</option>
                                                                @endforeach
                                                            </select>

                                                            <!-- Plage Horaire -->
                                                            <label for="horaire_id-{{ $etudiant->id }}"><strong>Plage Horaire :</strong></label>
                                                            <select id="horaire_id-{{ $etudiant->id }}" name="horaire_id" class="form-control" required>
                                                                <option value="" disabled {{ old('horaire_id') ? '' : 'selected' }}>Sélectionnez une plage horaire</option>
                                                                @foreach ($horaire as $plagehoraire)
                                                                    <option value="{{ $plagehoraire['id'] }}" {{ old('horaire_id') == $plagehoraire['id'] ? 'selected' : '' }}>
                                                                        {{ $plagehoraire['debut'] }} - {{ $plagehoraire['fin'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            
                                                            <!-- Salle -->
                                                            <label for="salle_id-{{ $etudiant->id }}"><strong>Salle :</strong></label>
                                                            <select id="salle_id-{{ $etudiant->id }}" name="salle_id" class="form-control" required>
                                                                <option value="" disabled {{ old('salle_id') ? '' : 'selected' }}>Sélectionnez une salle</option>
                                                                @foreach ($salles as $salle)
                                                                    <option value="{{ $salle->id }}" {{ old('salle_id') == $salle->id ? 'selected' : '' }}>
                                                                        {{ $salle->nom }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            
                                                            <!-- Jury -->
                                                            <label for="jury-{{ $etudiant->id }}"><strong>Président :</strong></label>
                                                            <select id="president-{{ $etudiant->id }}" name="president" class="form-control" required>
                                                                <option value="" disabled {{ old('president') ? '' : 'selected' }}>Sélectionnez un président</option>
                                                                @foreach ($enseignants as $enseignant)
                                                                    <option value="{{ $enseignant->id }}" {{ old('president') == $enseignant->id ? 'selected' : '' }}>
                                                                        {{ $enseignant->user->nom }} {{ $enseignant->user->prenom }} ({{ $enseignant->grade }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            
                                                            <!-- Examinateur -->
                                                            <label for="examinateur-{{ $etudiant->id }}"><strong>Examinateur :</strong></label>
                                                            <select id="examinateur-{{ $etudiant->id }}" name="examinateur" class="form-control" required>
                                                                <option value="" disabled {{ old('examinateur') ? '' : 'selected' }}>Sélectionnez un examinateur</option>
                                                                @foreach ($enseignants as $enseignant)
                                                                    <option value="{{ $enseignant->id }}" {{ old('examinateur') == $enseignant->id ? 'selected' : '' }}>
                                                                        {{ $enseignant->user->nom }} {{ $enseignant->user->prenom }} ({{ $enseignant->grade }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            
                                                            <!-- Rapporteur -->
                                                            <label for="rapporteur-{{ $etudiant->id }}"><strong>Rapporteur :</strong></label>
                                                            <select id="rapporteur-{{ $etudiant->id }}" name="rapporteur" class="form-control" required>
                                                                <option value="" disabled {{ old('rapporteur') ? '' : 'selected' }}>Sélectionnez un rapporteur</option>
                                                                @foreach ($enseignants as $enseignant)
                                                                    <option value="{{ $enseignant->id }}" {{ old('rapporteur') == $enseignant->id ? 'selected' : '' }}>
                                                                        {{ $enseignant->user->nom }} {{ $enseignant->user->prenom }} ({{ $enseignant->grade }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="session_id" value="{{ $selectedSessionId }}" />
                                                                <input type="hidden" name="type" value="{{ $type }}" />
                                                                


                                                            <!-- Bouton de soumission -->
                                                            <div class="mt-3">
                                                            <button type="button" class="btn btn-primary submitFormButton" data-student-id="{{ $etudiant->id }}">
                                                                Ajouter la soutenance
                                                            </button>
                                                            </div>
                                                            
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Script JavaScript -->
                                <script>
                                    function toggleForm(id) {
                                        const form = document.getElementById(`form-${id}`);
                                        if (form.style.display === "none") {
                                            form.style.display = "block";
                                        } else {
                                            form.style.display = "none";
                                        }
                                    }
                                </script>

                            </div>
                            
                        </div>
                    @endif
                                                <!-- Formulaire d'enregistrement -->
                            <!-- Formulaire d'envoi -->
                            <form id="envoyerPlanning" action="{{ route('envoyerPlanning') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="session_id" value="{{ $selectedSessionId }}">
                                            <input type="hidden" name="type" value="{{ $type }}">
                                            <button id="sendButton" class="btn btn-primary" type="button">Envoyer le planning</button>
                             </form>

                            <br>

                           

                        


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
<!-- Bootstrap JS & Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdowns = document.querySelectorAll('.dropdown');
            const openAllButton = document.getElementById('openAll');
            const closeAllButton = document.getElementById('closeAll');
            

            // Fonction pour ouvrir tous les contenus
            function openAll() {
                dropdowns.forEach(dropdown => {
                    const content = dropdown.querySelector('.dropdown-content');
                    content.style.display = 'block';
                });
            }

            // Fonction pour fermer tous les contenus
            function closeAll() {
                dropdowns.forEach(dropdown => {
                    const content = dropdown.querySelector('.dropdown-content');
                    content.style.display = 'none';
                });
            }

            // Ajouter des événements aux boutons Open All / Close All
            openAllButton.addEventListener('click', openAll);
            closeAllButton.addEventListener('click', closeAll);

            // Gestion des clics individuels pour chaque dropdown
            dropdowns.forEach(dropdown => {
                const title = dropdown.querySelector('.dropdown-title');
                const content = dropdown.querySelector('.dropdown-content');

                title.addEventListener('click', () => {
                    if (content.style.display === 'block') {
                        content.style.display = 'none';
                    } else {
                        content.style.display = 'block';
                    }
                });
            });
        });
        </script>
        
        <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Récupérer les boutons
        const sendButton = document.getElementById('sendButton');

        // Fonction générique pour envoyer une requête AJAX
        async function sendAjaxRequest(url, method, formData, successMessage, errorMessage) {
            try {
                const response = await fetch(url, {
                    method: method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    Swal.fire(
                        'Succès !',
                        successMessage || result.message || 'Opération réussie.',
                        'success'
                    ).then(() => {
                        location.reload(); // Recharge la page après succès
                    });
                } else {
                    const errorResult = await response.text(); // Récupère les détails en cas d'erreur
                    console.error("Erreur serveur : ", errorResult);
                    Swal.fire(
                        'Erreur !',
                        errorMessage || 'Une erreur est survenue.',
                        'error'
                    );
                }
            } catch (error) {
                console.error("Erreur inattendue : ", error);
                Swal.fire(
                    'Erreur !',
                    errorMessage || 'Erreur de communication avec le serveur.',
                    'error'
                );
            }
        }
        // Bouton "Envoyer le planning"
        sendButton.addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Vous êtes sur le point d'envoyer les soutenances.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, envoyer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    const sendForm = document.getElementById('envoyerPlanning');
                    const formData = new FormData(sendForm);

                    sendAjaxRequest(
                        sendForm.action,
                        'POST',
                        formData,
                        "Planning envoyé avec succès.",
                        "Erreur lors de l'envoi du planning."
                    );
                }
            });
        });
    });
</script>


        <script>
            document.querySelectorAll('.submitFormButton').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault(); // Empêche la soumission par défaut du formulaire
        

        // Récupérer l'ID de l'étudiant associé à ce bouton
        const studentId = this.getAttribute('data-student-id');
        console.log(studentId);
        console.log(studentId);
        // Récupérer les données spécifiques à ce formulaire
        const jour = document.getElementById(`jour_id-${studentId}`).value;
        const horaire_id = document.getElementById(`horaire_id-${studentId}`).value;
        const president = document.getElementById(`president-${studentId}`).value;
        const examinateur = document.getElementById(`examinateur-${studentId}`).value;
        const rapporteur = document.getElementById(`rapporteur-${studentId}`).value;

        // Envoyer une requête AJAX pour vérifier les disponibilités
        fetch('{{ route("checkJuryAvailability") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                jour: jour,
                horaire_id: horaire_id,
                president: president,
                examinateur: examinateur,
                rapporteur: rapporteur
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'warning') {
                Swal.fire({
                    title: 'Attention',
                    text: data.message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Continuer',
                    cancelButtonText: 'Annuler'
                }).then(result => {
                    if (result.isConfirmed) {
                        document.getElementById(`juryForm-${studentId}`).submit();
                    }
                });
            } else if (data.status === 'success') {
                document.getElementById(`juryForm-${studentId}`).submit();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la vérification des disponibilités.');
        });
    });
});


    </script>
</body>
</html>
 