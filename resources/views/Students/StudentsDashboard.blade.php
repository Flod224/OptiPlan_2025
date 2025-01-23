
<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="utf-8" />
		<title>OPTIMAID | Dashboard</title>
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
		{{-- <link href={{asset("assets/vendors/custom/datatables/datatables.bundle.css")}} rel="stylesheet" type="text/css" /> --}}

		<link href={{asset("assets/vendors/base/vendors.bundle.css")}} rel="stylesheet" type="text/css" />
		<link href={{asset("assets/demo/default/base/style.bundle.css")}} rel="stylesheet" type="text/css" />
        
		<link rel="shortcut icon" href={{asset("assets/app/media/img/logos/OPTIMAID1.png")}} />

	</head>
    <style>
        .initials-avatar
        {
            width: 100px;
            height: 100px;
            background-color: #4995e7;
            color: #fff;
            text-align: center;
            padding-top: 0.5em;
            line-height: 50px;
            border-radius: 50%;
            font-size: 50px;
        }

    </style>
	
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
									<a href="#" class="m-brand__logo-wrapper">
										<img alt="" src={{asset("assets/app/media/img/logos/OPTIMAID1.png")}} style="height: 1.3cm;" />
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
									
								</ul>
							</div>
							<!-- BEGIN: Topbar -->
							<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
								
								<div class="m-stack__item m-topbar__nav-wrapper">
									<ul class="m-topbar__nav m-nav m-nav--inline">
                                        <li id="m_quick_sidebar_toggle" class="m-nav__item">
											<a href="#" class="m-nav__link m-dropdown__toggle">
                                                <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
												<span class="m-nav__link-icon"><i class="flaticon-alarm"></i></span>
											</a>
										</li>
                                        <li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light" m-dropdown-toggle="click" id="fullscreen-button"
										 m-fullscreen-mode="dropdown" m-dropdown-persistent="1">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-nav__link-icon"><i class="flaticon-arrows "></i></span>
											</a>
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
							<li class="m-menu__item  m-menu__item--active" aria-haspopup="true"><a href="/StudentsDashboard" class="m-menu__link "><i class="m-menu__link-icon flaticon-line-graph"></i> <span class="m-menu__link-text"> Mon mémoire</span></a><br><br><br>
						</ul>
					</div>

					<!-- END: Aside Menu -->
				</div>
				<!-- END: Left Aside -->
				<div class="m-grid__item m-grid__item--fluid m-wrapper">
					<!--begin table -->
						<br>
						<!--begin::Portlet-->
                        <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Mot de passe</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form  id ="formpassword" class="m-form m-form--fit" method="POST" action="{{route('changePassword')}}">
                                            <div class="col-12 row">
                                            <input type="hidden" name="id" value="{{ auth()->user()->id }}">

                                                <label><b>E-mail</b></label><br>
                                                <input class="form-control m-input" type="text" style="background-color: rgb(205, 205, 205);" value="{{ auth()->user()->email }}" placeholder="Email" readonly>
                                            </div><br>
                                            <div class="col-12 row">
                                                <label><b>Ancien mot de passe</b></label><br>
                                                <input class="form-control m-input" type="password" name="old_password" placeholder="Ancien" >
                                            </div><br>
                                            <div class="col-12 row">
                                                <label><b>Nouveau mot de passe</b></label><br>
                                                <input class="form-control m-input" type="password" name="password" id="password" placeholder="Nouveau">
                                                <div id="nomError" style="color: red;"></div>
                                            </div>><br>  
                                            @csrf
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Modifier</button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xl-1 col-lg-1"></div>

                            <div class="col-xl-4 col-lg-4">

                                <div class="m-portlet m-portlet--full-height">

                                    <div class="m-portlet__body">

                                        <div class="m-card-profile">

                                            <div class="m-card-profile__pic">
                                                <div class="m-card-profile__pic-wrapper">
                                                    @if (auth()->check())
                                                        @php
                                                            $nom = auth()->user()->nom;
                                                            $prenom = auth()->user()->prenom;
                                                            $initiales = strtoupper(substr($prenom, 0, 1) . substr($nom, 0, 1));
                                                        @endphp
                                                        <div class="initials-avatar">{{ $initiales }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="m-card-profile__details">
                                                @auth
                                                    <span class="m-card-profile__name">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</span>
                                                    <a class="m-card-profile__email m-link"> {{ auth()->user()->email }} </a>
                                                @endauth
                                            </div>
                                        </div>

                                        <div class="m-portlet__body-separator"></div>

                                        <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                                            
                                            <li class="m-nav__item">
                                                <a class="m-nav__link" style="display: flex; justify-content: center; font-size: 50px;">
                                                    <i style="font-weight: bold; color: #4995e7;" class="m-nav__link-icon flaticon-profile-1"></i>
                                                    <span class="m-nav__link-title" >
                                                        <span class="m-nav__link-wrap">
                                                            <span class="m-nav__link-text" style="font-weight: bold; color: #4995e7;">Mes informations </span>
                                                        </span>
                                                    </span>
                                                </a><br>
                                            </li>
                                            <div style="padding-top: 15px; display: flex; justify-content: center;">
                                                <div>
                                                    <p>Nom : </p>
                                                    <p>Prénom(s) : </p>
                                                    <p>Matricule : </p>
                                                    <p>Cycle - Filière : </p>
                                                </div>
                                                <div style="margin-left: 3em; color: black;">
                                                    @auth
                                                        <p> {{ auth()->user()->nom }}</p>
                                                        <p> {{ auth()->user()->prenom }}</p>
                                                        <p> {{ auth()->user()->matricule }}</p>
                                                        <p> {{ auth()->user()->etudiant->niveau_etude }} - {{ auth()->user()->etudiant->filiere }}</p>
                                                    @endauth 
                                                </div>                                     
                                            </div>
                                        </ul>

                                        <div class="m-portlet__body-separator"></div>

                                        <div class="m-widget1 m-widget1--paddingless" style="display:flex; justify-content: center; gap: 30px">
                                            <a href="{{ route('changePassword')}}" data-toggle="modal" data-target="#m_modal_1" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder" style="background-color: rgb(174, 228, 174);">Modifier mot de passe</a>
                                            <a href="{{ route('deconnexion') }}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder" style="background-color: rgb(174, 228, 174);">Déconnexion</a>
                                        </div>
                                        
                                    </div>

                                </div>

                            </div>
                            
                            <div class="col-xl-6 col-lg-6">
                                <div class="m-portlet m-portlet--full-height">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-tools">
                                            <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                                        <i class="flaticon-share m--hide"></i>
                                                        Mémoire
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content">
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
                                        <div class="tab-pane active">
                                            <form class="m-form m-form--fit m-form--label-align-right" action="{{ route('infosStudents') }}" method="POST" enctype="multipart/form-data">
                                                <div class="m-portlet__body">
                                                    <div class="form-group m-form__group">
                                                        <h6 class="m-form__section">Thème de mémoire</h6>
                                                        <div style="width: 12cm">
                                                            <textarea class="form-control" maxlength="500" placeholder="Votre thème..." name="theme" rows="4">{{ auth()->user()->etudiant->theme ?? '' }}</textarea>
                                                        </div>
                                                    </div><br>
                                                    @csrf
                                                    <div class="form-group m-form__group">
                                                        <h6 class="m-form__section">Maitre mémoire</h6>
                                                        <div style="width: 12cm">
                                                            
                                                            <select class="form-control m-select2" id="m_select2_1" name="maitre_memoire">
                                                        <option value="">Sélectionnez un maître mémoire</option>
                                                        @foreach ($prof as $professeur)
                                                            <option value="{{ $professeur->id }}">
                                                                {{ $professeur->user->nom }} {{ $professeur->user->prenom }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                                                                                </select>                                                                
                                                        </div>
                                                        {{-- <p style="font-size: 10px;padding: 15px;">* Un mail sera envoyé au maitre mémoire *</p> --}}
                                                    </div>
                                                    <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>

                                                    <div class="form-group m-form__group row">
                                                        <div class="col-12 ml-auto">
                                                            <h6 class="m-form__section">Uploader le document de mémoire</h6>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group">
                                                        <div class="custom-file" style="width: 12cm">
                                                            <input type="file" name="file" id="customFile" accept=".pdf">
                                                            <label class="custom-file-label" for="customFile">Uploader votre mémoire</label>
                                                        </div> 
                                                    </div>

                                                </div>
                                                <script>
													@if(session('error'))
													Swal.fire({
														title: 'Erreur!',
														text: '{{ session('error') }}',
														icon: 'error'
													});
													@endif
												</script>
                                                <div class="m-portlet__foot m-portlet__foot--fit">
                                                    <div class="m-form__actions">
                                                        <div class="row">
                                                            <div class="col-12" style="display: flex; justify-content: right;">
                                                                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Soumettre</button>&nbsp;&nbsp;
                                                                @if(auth()->user()->etudiant->file)
                                                                    <button><a href="{{ route('docPDF', ['filename' => auth()->user()->etudiant->file]) }}" target="_blank">Voir le PDF</a></button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
                                    </div>
                                </div>
                            </div>

                        </div>
							
						<!--end::Portlet-->		
                        	
                        <div class="row">
                            <div class="col-xl-1 col-lg-1"></div>

                            <div class="col-xl-10 col-lg-10">

                                <div class="m-portlet m-portlet--full-height">

                                    <div class="m-demo__preview" style="padding: 50px 0px 20px 0px; ">
                                        <div class="m-list-timeline">
                                            <div class="m-list-timeline__item" style="display: flex; justify-content: space-around;">
                                                <div>
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                    <span class="m-list-timeline__text" style="color: #4995e7; font-weight: 400; font-size: 15px">Fichier uploadé </span>
                                                </div> 
                                                <div>
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                    <span class="m-list-timeline__text" style="color: #4995e7; font-weight: 400; font-size: 15px">Mise en ligne </span>
                                                </div>
                                                <div>
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                    <span class="m-list-timeline__text" style="color: #4995e7; font-weight: 400; font-size: 15px">Mise à jour </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-demo__preview" style="padding: 0px 0px 50px 0px; ">
                                        <div class="m-list-timeline">
                                            @if(auth()->user()->etudiant->file)
                                                <div class="m-list-timeline__item" style="display: flex; justify-content: space-around;">
                                                    <div>
                                                        <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                        <span class="m-list-timeline__text"> 
                                                            <a href="{{ route('docPDF', ['filename' => auth()->user()->etudiant->file]) }}" target="_blank">
                                                                {{ strlen(auth()->user()->etudiant->file) > 20 ? substr(auth()->user()->etudiant->file, 0, 20) . '...' : auth()->user()->etudiant->file }}
                                                            </a>
                                                        </span>
                                                    </div> 
                                                    <div>
                                                        <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                        <span class="m-list-timeline__text" style="font-weight: 400;"> {{auth()->user()->etudiant->created_at}} </span>
                                                    </div>
                                                    <div>
                                                        <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                        <span class="m-list-timeline__text" style="font-weight: 400;"> {{auth()->user()->etudiant->updated_at}} </span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                        </div>

					</div>

					<!--end table -->

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
        <div id="m_quick_sidebar" class="m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light">
			<div class="m-quick-sidebar__content m--hide">
				<span id="m_quick_sidebar_close" class="m-quick-sidebar__close"><i class="la la-close"></i></span>
				<ul id="m_quick_sidebar_tabs" class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
					<li class="nav-item m-tabs__item">
						<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_quick_sidebar_tabs_messenger" role="tab">Notifications</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="m_quick_sidebar_tabs_messenger" role="tabpanel">
						<div class="m-messenger m-messenger--message-arrow m-messenger--skin-light">
							<div class="m-messenger__messages m-scrollable">
								<div class="m-messenger__wrapper">
									<div class="m-messenger__message m-messenger__message--in">
										<div class="m-messenger__message-body">
											<div class="m-messenger__message-arrow"></div>
											<div class="m-messenger__message-content">
												<div class="m-messenger__message-username">
													DefenseScheduler
												</div>
                                                @if($programmation === null)
                                                    <div class="m-messenger__message-text">
                                                        Aucune notification
                                                    </div>
                                                @else
                                                    @if($programmation->state === "pre")
                                                        <div class="m-messenger__message-text">
                                                            Cher(e) {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                                                            @if($programmation->horaire_id === 1)
                                                            <br>Votre pré-soutenance a été programmée pour le {{$programmation->jour}} de 08h à 13h dans la salle {{$programmation->salle->nom}}.
                                                            Veuillez vous assurer d'être présent à l'heure précise et bien préparé pour votre présentation.
                                                            Le programme vous sera envoyer par mail.
                                                            <br>L'équipe DefenseScheduler"
                                                            @else
                                                            <br>Votre pré-soutenance a été programmée pour le {{$programmation->jour}} de 13h à 18h dans la salle {{$programmation->salle->nom}}.
                                                            Veuillez vous assurer d'être présent à l'heure précise et bien préparé pour votre présentation.
                                                            Le programme vous sera envoyer par mail.
                                                            <br>L'équipe DefenseScheduler"
                                                            @endif
                                                        </div>
                                                        @elseif($programmation->state === 'soutenance')
                                                        Félicitations! <br>Votre soutenance a été programmée avec succès pour le {{$programmation->jour}} de {{$programmation->horaire->debut}} à {{$programmation->horaire->fin}} dans la salle {{$programmation->salle->nom}}.
                                                        Veuillez vous assurer d'être présent à l'heure précise et bien préparé pour votre soutenance. Nous vous souhaitons beaucoup de succès!
                                                        Le programme vous sera envoyer par mail.
                                                        <br>L'équipe DefenseScheduler"
                                                    @endif
                                                @endif
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- begin::Scroll Top -->
			<div id="m_scroll_top" class="m-scroll-top">
				<i class="la la-arrow-up"></i>
			</div>

		<!-- end::Scroll Top -->

		<!--begin::Global Theme Bundle -->
			<script src={{asset("assets/vendors/base/vendors.bundle.js")}} type="text/javascript"></script>
			<script src={{asset("assets/demo/default/base/scripts.bundle.js")}} type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts -->
		    <script src={{asset("assets/demo/default/custom/crud/forms/widgets/bootstrap-maxlength.js")}} type="text/javascript"></script>
            <script src={{asset("assets/demo/default/custom/crud/forms/widgets/select2.js")}} type="text/javascript"></script>

			<script src={{asset("assets/app/js/dashboard.js")}} type="text/javascript"></script>

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
	
                document.getElementById("customFile").addEventListener("change", function(event) {
                    const input = event.target;
                    const label = input.nextElementSibling;
                    const fileName = input.files[0].name;
                    label.innerHTML = fileName;
                });
			</script>
            <script>
                document.getElementById('formpassword').addEventListener('submit', function (e) {
                    const password = document.getElementById('password').value;
                    const passwordError = document.getElementById('nomError');

                    // Définir les règles du mot de passe
                    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

                    if (!passwordRegex.test(password)) {
                        e.preventDefault(); // Empêcher l'envoi du formulaire
                        passwordError.textContent = 
                            "Le mot de passe doit contenir au moins 8 caractères, " +
                            "une majuscule, une minuscule, un chiffre et un caractère spécial.";
                    } else {
                        passwordError.textContent = ''; // Supprimer les erreurs si tout est correct
                    }
                });
            </script>


		<!--end::Page Scripts -->

	</body>

	<!-- end::Body -->
</html>