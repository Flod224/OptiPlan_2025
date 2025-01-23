<!DOCTYPE html>
<html lang="fr">
 
<head>
    <meta charset="utf-8" />
    <title>SchedulerDefense | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
 
        .dashboard-content {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 30px;
        }
 
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
        }
 
        .form-title {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 500;
            font-size: 1.5rem;
            color: #3498db;
        }
 
        label {
            font-weight: bold;
        }
 
        .btn-primary {
            background-color: #3498db;
            border: none;
        }
 
        .btn-primary:hover {
            background-color: #2980b9;
        }
 
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--multiple {
        height: auto;
        padding: 5px;
        border-radius: 8px;
        border: 1px solid #ced4da;
    }
 
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 3px 10px;
        margin-right: 5px;
    }
</style>
 
</head>
 
<body>
    <!-- Header conservé -->
    <header id="m_header" class="m-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center py-3">
                <a href="/AdminDashboard">
                    <img src="{{ asset('assets/app/media/img/logos/OPTIMAID1.png') }}" alt="Logo" style="height: 50px;">
                </a>
                <nav>
                    <a href="{{ route('deconnexion') }}" class="btn btn-secondary">Déconnexion</a>
                </nav>
            </div>
        </div>
    </header>
 
    <div class="dashboard-content">
    <div class="form-container">
        <h2 class="form-title">Saisie de Disponibilité</h2>
        <form class="m-form m-form--fit" action="{{ route('addDisponibiliteEnseignant') }}" method="POST">
    @csrf

    <!-- Sélection de session -->
    <div class="mb-3">
        <label for="session_id" class="form-label">Session</label>
        <select class="form-select" id="session_id" name="session_id" required onchange="updateSessionDetails()">
            <option value="" disabled selected>Choisir une session</option>
            @foreach($sessions as $session)
            <option value="{{ $session->id }}"
                    data-name="{{ $session->nom }}"
                    data-start-presout="{{ \Carbon\Carbon::parse($session->session_start_PreSout)->format('Y-m-d') }}"
                    data-end-presout="{{ \Carbon\Carbon::parse($session->session_end_PreSout)->format('Y-m-d') }}"
                    data-start-sout="{{ \Carbon\Carbon::parse($session->session_start_Sout)->format('Y-m-d') }}"
                    data-end-sout="{{ \Carbon\Carbon::parse($session->session_end_Sout)->format('Y-m-d') }}">
                {{ $session->nom }}
            </option>
            @endforeach
        </select>
        @error('session_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Sélection du type de soutenance -->
    <div class="mb-3">
        <label for="type_soutenance" class="form-label">Type</label>
        <select class="form-select" id="type_soutenance" name="type_soutenance" required onchange="updateDateRange()">
            <option value="" disabled selected>Choisir un type</option>
            <option value="Pre-Soutenance">Pré-Soutenance</option>
            <option value="Soutenance">Soutenance</option>
        </select>
        @error('type_soutenance')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Sélection de la date -->
    <div class="mb-3">
        <label for="jour" class="form-label">Jour</label>
        <input type="date" id="jour" name="jour" class="form-control" required>
        @error('jour')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Sélection des horaires -->
    <div class="col-md-6 mb-3">
        <label for="horaire_id" class="form-label">Sélectionnez/Désélectionnez les horaires :</label>
        <select
            class="form-control select2"
            id="horaire_id"
            name="horaire_id[]"
            multiple>
            @foreach ($horaire as $horaires)
                <option value="{{ $horaires->id }}">
                    {{ $horaires->debut }} - {{ $horaires->fin }}
                </option>
            @endforeach
        </select>
        @error('horaire_id')
        <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Toute la journée -->
    <div class="mb-3 form-check">
        <input type="checkbox" id="all_day" name="all_day" class="form-check-input" value="1">
        <label for="all_day" class="form-check-label">Toute la journée</label>
    </div>

    <!-- Script pour Select2 et gestion des dates -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#horaire_id').select2({
                placeholder: 'Sélectionnez les horaires',
                allowClear: true,
                width: '100%'
            });
        });

        // Met à jour la plage de dates pour le champ "jour"
        function updateDateRange() {
            const sessionSelect = document.getElementById('session_id');
            const typeSelect = document.getElementById('type_soutenance');
            const dateInput = document.getElementById('jour');

            const selectedSession = sessionSelect.options[sessionSelect.selectedIndex];
            const selectedType = typeSelect.value;

            if (selectedSession && selectedType) {
                // Récupérer les dates en fonction du type de session
                let startDate = '';
                let endDate = '';

                if (selectedType === 'Pre-Soutenance') {
                    startDate = selectedSession.getAttribute('data-start-presout');
                    endDate = selectedSession.getAttribute('data-end-presout');
                } else if (selectedType === 'Soutenance') {
                    startDate = selectedSession.getAttribute('data-start-sout');
                    endDate = selectedSession.getAttribute('data-end-sout');
                }

                // Mettre à jour les attributs min et max
                dateInput.min = startDate;
                dateInput.max = endDate;

                // Réinitialiser la valeur du champ date si elle n'est plus valide
                if (dateInput.value && (dateInput.value < startDate || dateInput.value > endDate)) {
                    dateInput.value = '';
                }
            }
        }

        // Met à jour les détails de la session
        function updateSessionDetails() {
            updateDateRange();
        }
    </script>

    <!-- Bouton de soumission -->
    <div class="text-center">
        <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
    </div>
</form>

    </div>
</div>
 
<!-- JavaScript -->
<script>
    function updateSessionDetails() {
        // Récupérer l'élément sélectionné
        const select = document.getElementById('session_id');
        const selectedOption = select.options[select.selectedIndex];
       
        // Récupérer les données associées à l'option sélectionnée
        const sessionName = selectedOption.getAttribute('data-name');
        const startPreSout = selectedOption.getAttribute('data-start-presout');
        const endPreSout = selectedOption.getAttribute('data-end-presout');
        const startSout = selectedOption.getAttribute('data-start-sout');
        const endSout = selectedOption.getAttribute('data-end-sout');
 
        // Mettre à jour le contenu de la section des détails
        const sessionDetails = document.getElementById('sessionDetails');
        if (sessionName) {
            sessionDetails.style.display = 'block'; // Afficher la section
            sessionDetails.innerHTML = `
                <p>
                    <strong>${sessionName}</strong> :
                    Pré-soutenances du ${startPreSout}
                    au ${endPreSout}, et soutenances du
                    ${startSout} au ${endSout}.
                </p>
            `;
        } else {
            sessionDetails.style.display = 'none'; // Cacher si aucune session n'est sélectionnée
        }
    }
</script>
<!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- JS de Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 
<script>
    $(document).ready(function () {
        // Initialisation de Select2
        $('#horaire_id').select2({
            placeholder: 'Sélectionnez des horaires',
            allowClear: true,
            width: '100%'
        });
    });
</script>
 
</body>
 
</html>