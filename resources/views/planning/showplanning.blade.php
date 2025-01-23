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
        <h1 class="text-center">Planning de {{$type}}</h1>
        <div class="action-buttons d-flex justify-content-end">
            <button id="openAll" class="btn btn-success">Open All</button>
            <button id="closeAll" class="btn btn-danger">Close All</button>
            
        </div>
        
       
       
        <div class="container mt-4">
            <!-- Afficher un message d'erreur -->
            @if(session()->has('success'))
                <script>
                    alert('{{ session('success') }}');
                </script>
            @endif

            @if(session()->has('error'))
                <script>
                    alert('{{ session('error') }}');
                </script>
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
                                        
                                        <div class="dropdown card mb-3">
                                            <!-- Titre cliquable -->
                                            <div class="dropdown-title card-body">
                                                    <h5 class="card-title ">Soutenance : {{ $soutenance['theme']}}</h5>
                                                    </div>
                                                    <div class="dropdown-content ">
                                                            <p class="card-text">
                                                                <strong>Étudiant :</strong> {{ $soutenance['etudiant_nom'] }}<br>
                                                                <strong>Niveau d'étude :</strong> {{ $soutenance['niveau_etude'] }}<br>
                                                                <strong>Plage Horaire :</strong> {{ $soutenance['Plage Horaire'] }}<br>
                                                                <strong>Salle :</strong> {{ $soutenance['salle_nom'] }}
                                                            </p>
                                                            <p><strong>Jury :</strong></p>
                                                            <ul>
                                                                <strong>Président :</strong> {{ $soutenance['president_nom'] }}<br>
                                                                <strong>Examinateur :</strong> {{ $soutenance['examinateur_nom'] }}<br>
                                                                <strong>Rapporteur :</strong> {{ $soutenance['rapporteur_nom'] }}
                                                        
                                                            </ul>
                                                        </div>    
                                                
                                            </div>
                                        @endforeach
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                    
                        
                        <div class="dropdown card mb-4">
                                            <!-- Titre cliquable -->
                                <div class="dropdown-title card-header">
                                <h5>Statistiques des soutenances</h5>
                                </div>
                                <div class="card-body dropdown-content">
                                @if (isset($metrics) && !empty($metrics))
                                    <ul class="list-group">
                                        @foreach ($metrics as $key => $value)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>{{ ucfirst($key) }} :</strong>
                                                <span>{{ $value }}</span>
                                            </li>
                                        @endforeach
                                       
                                    </ul>
                                @endif
                                @if (isset($totalSoutenances)&& !empty($totalSoutenances))
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <strong>Nombre de soutenances totales :</strong>
                                                <span>{{ $totalSoutenances }}</span>
                                            </li>
                                                @endif
                                </div>
                            
                        </div>
                  
                    
                    @if (isset($names) && !empty($names))
                        
                            <div class="dropdown card mb-4">
                                            <!-- Titre cliquable -->
                                <div class="dropdown-title card-header">
                                <h5>Étudiants non programmés</h5>
                            </div>
                            <div class="card-body dropdown-content">
                            <ul class="list-group">
                                    @foreach ($names as $name)
                                        <li class="list-group-item">
                                            {{ $name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                        </div>
                    @endif
                             <!-- Conteneur principal pour les boutons -->
                              
                                    <div class="d-flex justify-content-around align-items-center my-3">
                                        <!-- Formulaire d'enregistrement -->
                                        <form action="{{ route('savePlanning') }}" method="POST" id="planningSave">
                                            @csrf
                                            <input type="hidden" name="plannings" value="{{ json_encode($plannings) }}" />
                                            <input type="hidden" name="type" value="{{ $type }}" />
                                            <input type="hidden" name="session_id" value="{{ $selectedSessionId }}" />
                                            <button type="button" class="btn btn-primary" id="saveButton">Enregistrer le planning</button>
                                        </form>

                                        <!-- Formulaire de modification -->
                                        <form action="{{ route('ModifierPlanning') }}" method="POST" id="planningModifier">
                                            @csrf <!-- Assurez-vous que le jeton CSRF est inclus -->
                                            
                                            <!-- Transmission de l'ID de session -->
                                            <input type="hidden" name="session_id" value="{{ $selectedSessionId }}" />
                                            <input type="hidden" name="type" value="{{ $type }}" />
                                            <input type="hidden" name="names" value="{{ json_encode($names) }}" />

                                            <button type="button" class="btn btn-primary" id="modifyButton">Modifier le planning</button>
                                        </form>

                                        <!-- Formulaire d'envoi -->
                                        <form id="envoyerPlanning" action="{{ route('envoyerPlanning') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="session_id" value="{{ $selectedSessionId }}">
                                            <input type="hidden" name="type" value="{{ $type }}">
                                            <button id="sendButton" class="btn btn-primary" type="button">Envoyer le planning</button>
                                        </form>
                                    </div>


                                </div>
                </div>
           
        </div>
        

<!-- SCRIPT START -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Récupérer les boutons
        const saveButton = document.getElementById('saveButton');
        const modifyButton = document.getElementById('modifyButton');
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

                        const sessionId = formData.get('session_id');
                        const type = formData.get('type');
                        // Créer un formulaire HTML pour soumettre une requête POST
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = 'afficherPlanning';

                            // Ajouter les champs nécessaires
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                            form.innerHTML = `
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="session_id" value="${sessionId}">
                                <input type="hidden" name="type" value="${type}">
                            `;

                            // Ajouter et soumettre le formulaire
                            document.body.appendChild(form);
                            form.submit();
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

        // Bouton "Enregistrer le planning"
        saveButton.addEventListener('click', function (e) {
                e.preventDefault();

                // Afficher une confirmation avant de sauvegarder
                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Vous êtes sur le point d'enregistrer le planning.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, enregistrer !',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const saveForm = document.getElementById('planningSave');
                        const formData = new FormData(saveForm);

                        sendAjaxRequest(
                            saveForm.action,
                            'POST',
                            formData,
                            "Planning enregistré avec succès.",
                            "Erreur lors de l'enregistrement du planning."
                        ).then(() => {
                            // Récupérer les données nécessaires à partir du formulaire
                            const sessionId = saveForm.querySelector('input[name="session_id"]').value;
                            const type = saveForm.querySelector('input[name="type"]').value;
                        // Créer un formulaire HTML pour soumettre une requête POST
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = 'afficherPlanning';

                            // Ajouter les champs nécessaires
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                            form.innerHTML = `
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="session_id" value="${sessionId}">
                                <input type="hidden" name="type" value="${type}">
                            `;

                            // Ajouter et soumettre le formulaire
                            document.body.appendChild(form);
                            form.submit();
                        });
                    }
                });
            });


        

        // Bouton "Modifier le planning"
        modifyButton.addEventListener('click', function (e) {
            e.preventDefault();

            const modifyForm = document.getElementById('planningModifier').submit();
            const formData = new FormData(modifyForm);

            sendAjaxRequest(
                modifyForm.action,
                'POST',
                formData,
                "Planning modifié avec succès.",
                "Erreur lors de la modification du planning."
            );
        });

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

<!-- SCRIPT END -->
        
 
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
</body>
</html>
 