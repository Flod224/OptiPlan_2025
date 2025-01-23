<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="utf-8" />
		<title>SchedulerDefense | Mémoires Supervisés</title>
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


        <style>

:root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --bg-light: #f4f6f7;
            --text-dark: #2c3e50;
            --sidebar-width: 250px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%);
            display: flex;
            min-height: 100vh;
            line-height: 1.6;
        }

        .body {
            display: flex;
            width: 100%;

        }

        .sidebar {
            /* width: var(--sidebar-width); */
            width: 255px;
            background-color: #282a3c;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            padding-top: 7%;
        }

        .sidebar-logo {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.5em;
            color: white;
            font-weight: bold;
        }

        .sidebar-menu {
            list-style-type: none;
        }

        .sidebar-menu li {
            margin-bottom: 15px;
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: rgba(255,255,255,0.2);
        }

        .sidebar-menu a i {
            margin-right: 10px;
        }

        .main-content {

            padding: 20px;
            padding-top: 6%;
            background-color: #ffffff;
            min-height: 100vh;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* width: 85vw; */
            width: 1670px;

        }

    /* Tableau des mémoires */
    .memos-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .memos-table thead {
        background-color: #6c63ff;
        color: #fff;
        text-align: left;
    }

    .memos-table th,
    .memos-table td {
        padding: 10px 15px;
        border: 1px solid #ddd;
    }

    .memos-table tbody tr:hover {
        background-color: #f4f4f4;
    }

    /* Bouton de téléchargement */
    .btn-download {
        display: inline-block;
        padding: 8px 15px;
        background-color: #00b894;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background 0.3s;
    }

    .btn-download:hover {
        background-color: #6c63ff;
    }

	</style>

	</head>




	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop">

						<!-- BEGIN: Brand -->
						<div class="m-stack__item m-brand  m-brand--skin-dark">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="/AdminDashboard" class="m-brand__logo-wrapper">
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

							<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
								<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
									<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"><span class="m-menu__link-text" style="font-size: 18px;">DefenseScheduler</span></li>
								</ul>
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
            <br>

			<!-- END: Header -->

			<!-- begin::Body -->

            <div class="body">

                    <div class="sidebar">
                        <div class="sidebar-logo">
                            Menu de l'enseignant
                        </div>
                        <ul class="sidebar-menu">
                            <li>
                                <a href="#" >
                                    <i class="fas fa-calendar-plus"></i>
                                    Ajouter Disponibilité
                                </a>
                            </li>
                            <li>
                                <a href="#" class="active">
                                    <i class="fas fa-book"></i>
                                    Mémoires Supervisés
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fas fa-chart-pie"></i>
                                    Statistiques
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fas fa-cog"></i>
                                    Paramètres
                                </a>
                            </li>
                        </ul>
            </div>

			<main class="main-content">
				<h1>Mes Mémoires Supervisés</h1>
				<div class="supervisions">
					<table class="memos-table">
						<thead>
							<tr>
								<th>Étudiant</th>
								<th>Filière</th>
								<th>Date de Soutenance</th>
								<th>Document</th>
							</tr>
						</thead>
						<tbody>
							<!-- Exemple de contenu dynamique -->
							<tr>
								<td>Jean HODONOU</td>
								<td>Génie logiciel</td>
								<td>2024-12-15</td>
								<td><a href="/documents/memoire_jean.pdf" class="btn-download">Télécharger</a></td>
							</tr>
							<tr>
								<td>Marie AITNDE</td>
								<td>Internet et multimédia</td>
								<td>2024-12-20</td>
								<td><a href="/documents/memoire_marie.pdf" class="btn-download">Télécharger</a></td>
							</tr>
							<tr>
								<td>Paul AHOLOU</td>
								<td>Sécurité informatique</td>
								<td>2024-12-22</td>
								<td><a href="/documents/memoire_paul.pdf" class="btn-download">Télécharger</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</main>


            </div>
	</body>

	<!-- end::Body -->
</html>
