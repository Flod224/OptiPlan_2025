<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="utf-8" />
		<title> DefenseScheduler - Login</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<link rel="shortcut icon" href={{asset("assets/app/media/img/logos/defensescheduler.png")}} />
		
	</head>

	<style>

		@import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400');

		body, html {
			font-family: 'Source Sans Pro', sans-serif;
			background-color: #15dd3d; 
			padding: 0;
			margin: 0;
		}

		#particles-js {
			position: absolute;
			width: 100%;
			height: 100%;
		}

		.container{
			margin: 0;
			top: 50px;
			left: 50%;
			position: absolute;
			text-align: center;
			transform: translateX(-50%);
			background-color: #1d243d; 
			border-radius: 9px;
			border-top: 10px solid #79a6fe;
			border-bottom: 10px solid #79a6fe;
			width: 400px;
			height: 500px;
			box-shadow: 1px 1px 108.8px 19.2px rgb(25,31,53);
		}

		.box h4 {
			font-weight: lighter;
			color: white;
			font-size: 18px;
			font-weight: bold;
			margin-top: -8px;
			margin-bottom: 25px
		}

		.box input[type = "text"],.box input[type = "password"] {
			display: block;
			margin: 20px auto;
			background: #262e49;
			border: 0;
			border-radius: 5px;
			padding: 14px 10px;
			width: 320px;
			outline: none;
			color: #fff;
			-webkit-transition: all .2s ease-out;
			-moz-transition: all .2s ease-out;
			-ms-transition: all .2s ease-out;
			-o-transition: all .2s ease-out;
			transition: all .2s ease-out;
		}

		::-webkit-input-placeholder {
			color: #565f79;
		}

		.box input[type = "text"]:focus,.box input[type = "password"]:focus {
			border: 1px solid #79A6FE;
		}

		a{
			color: #5c7fda;
			text-decoration: none;
		}

		a:hover {
			text-decoration: underline;
		}

		.btn1 {
			border:0;
			background: #7f5feb;
			color: #fff;
			border-radius: 100px;
			width: 340px;
			height: 49px;
			font-size: 16px;
			position: absolute;
			top: 80%;
			left: 8%;
			transition: 0.3s;
			cursor: pointer;
		}

		.btn1:hover {
			background: #5d33e6;
		}

		.error {
			background: #ff3333;
			text-align: center;
			padding: 10px 15px 10px 15px;
			border: 0;
			border-radius: 5px;
			left: 7.2%;
			color: white;
		}

		.footer {
			position: relative;
			left: 0;
			bottom: 0;
			top: 605px;
			width: 100%;
			color: #78797d;
			font-size: 14px;
			text-align: center;
		}

		.footer .fa {
		color: #7f5feb;;
		}
	</style>

	<body id="particles-js"></body>
		<div class="container">
			<form action="{{ route('loginUser')}}" method="POST" class="box">
				<br><br>
				<img style="height: 4cm;" src="{{asset("assets/app/media/img/logos/defensescheduler.png")}} " alt="Logo">
				{{-- <h4> DefenseScheduler </h4> --}}
				<br><br>
				@if(session('error'))
					<span class="error">{{ session('error') }}</span>
				@endif
				<input type="text" name="email" placeholder="Email" autocomplete="off">
				<input type="password" name="password" placeholder="Mot de passe" autocomplete="off">
				@csrf
				<button type="submit" class="btn1">Connexion</button>
			</form>
		</div>
		
	</body>

	<script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

	<script>
		
		// ParticlesJS Config.

		particlesJS("particles-js", {
			"particles": {
				"number": {
				"value": 60,
				"density": {
					"enable": true,
					"value_area": 800
				}
				},
				"color": {
				"value": "#ffffff"
				},
				"shape": {
				"type": "circle",
				"stroke": {
					"width": 0,
					"color": "#000000"
				},
				"polygon": {
					"nb_sides": 5
				},
				"image": {
					"src": "img/github.svg",
					"width": 100,
					"height": 100
				}
				},
				"opacity": {
				"value": 0.1,
				"random": false,
				"anim": {
					"enable": false,
					"speed": 1,
					"opacity_min": 0.1,
					"sync": false
				}
				},
				"size": {
				"value": 6,
				"random": false,
				"anim": {
					"enable": false,
					"speed": 40,
					"size_min": 0.1,
					"sync": false
				}
				},
				"line_linked": {
				"enable": true,
				"distance": 150,
				"color": "#ffffff",
				"opacity": 0.1,
				"width": 2
				},
				"move": {
				"enable": true,
				"speed": 1.5,
				"direction": "top",
				"random": false,
				"straight": false,
				"out_mode": "out",
				"bounce": false,
				"attract": {
					"enable": false,
					"rotateX": 600,
					"rotateY": 1200
				}
				}
			},
			"interactivity": {
				"detect_on": "canvas",
				"events": {
				"onhover": {
					"enable": false,
					"mode": "repulse"
				},
				"onclick": {
					"enable": false,
					"mode": "push"
				},
				"resize": true
				},
				"modes": {
				"grab": {
					"distance": 400,
					"line_linked": {
					"opacity": 1
					}
				},
				"bubble": {
					"distance": 400,
					"size": 40,
					"duration": 2,
					"opacity": 8,
					"speed": 3
				},
				"repulse": {
					"distance": 200,
					"duration": 0.4
				},
				"push": {
					"particles_nb": 4
				},
				"remove": {
					"particles_nb": 2
				}
				}
			},
			"retina_detect": true
		});
	</script>

</html>
