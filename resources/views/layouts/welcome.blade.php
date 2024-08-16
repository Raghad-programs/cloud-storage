<!DOCTYPE HTML>
<!--
	Photon by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
    
	<head>
		<title>Photon by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="{{ asset('welcome/assets/css/main.css') }}" />
<noscript><link rel="stylesheet" href="{{ asset('welcome/assets/css/noscript.css') }}" /></noscript>

<style>
            .center-content {
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
            }

            .justify-content-center {
                justify-content: center;
            }
			.navbar-nav {
				visibility: hidden;
				display: none;
				background: transparent;
			}

        </style>
	</head>

	<body class="is-preload">

		<!-- Header -->
        <section id="header">
		<nav class="navbar-nav">
	<li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" type="submit" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-globe fa-fw"></i>
         @if (session('locale') == 'ar')
            Ar
         @else
            En
         @endif
          </a>
            <div class="dropdown-menu dropdown-menu-left shadow animated--grow-in" aria-labelledby="languageDropdown">
                <a class="dropdown-item" href="{{ route('change.language', ['lang' => 'en']) }}">
                    <i class="fas fa-language fa-sm fa-fw mr-2 text-gray-400"></i>
                    English
                </a>
                <a class="dropdown-item" href="{{ route('change.language', ['lang' => 'ar']) }}">
                <html xmlns="/lang/{$lang}" lang="ar" xml:lang="ar"> </html>
                    <i class="fas fa-language fa-sm fa-fw mr-2 text-gray-400"></i>
                    العربية
                </a>
            </div>
        </li>
		</nav>
            <div class="inner">
                <span class="icon solid major fa-cloud"></span>
                <h1>Hi, Welcome to the <strong>Archive Cloud!</strong><br />
               </h1>
                <p>Your powerful, on-demand computing resource is ready to help you achieve your goals.</p>
                <ul class="actions special">
                    <li><a href="#one" class="button scrolly">Discover</a></li>
                </ul>
            </div>
        </section>

		<!-- One -->
        <section id="one" class="main style1 center-content">
    <div class="container">
        <div class="row gtr-150 justify-content-center">
            <div class="col-6 col-12-medium">
                <header class="major">
                    <h2>Do you have an account?</h2>
                </header>
                <ul class="actions special">
                    <li><a href="/login" class="button wide primary">Login</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

            

		<!-- Two -->
			<section id="two" class="main style2">
				<div class="container">
					<div class="row gtr-150">
						<div class="col-6 col-12-medium">
							<ul class="major-icons">
								<li><span class="icon solid style1 major fa-code"></span></li>
								<li><span class="icon solid style2 major fa-bolt"></span></li>
								<li><span class="icon solid style3 major fa-camera-retro"></span></li>
								<li><span class="icon solid style4 major fa-cog"></span></li>
								<li><span class="icon solid style5 major fa-desktop"></span></li>
								<li><span class="icon solid style6 major fa-calendar"></span></li>
							</ul>
						</div>
						<div class="col-6 col-12-medium">
							<header class="major">
								<h2>About our company </h2>
							</header>
							<p>About us
							Qassim Technical Association aims to enrich technical content, and create an environment and forum for those interested in technology. It was initially an association supervised by the Emirate of Qassim Region, and was launched by His Highness Prince Dr. Faisal bin Mishaal, may God protect him and his family, on June 24, 2020. It was then transformed into a registered association with License 2074 from the Ministry of Human Resources and Social Development.
							</p>
							<p>Vision
							To be a leading technical reference in the Qassim region, and a stimulating environment for exchanging knowledge and experiences and building partnerships
							</p>
							<p>Message
							To enhance the culture of technical giving and raise the level of capabilities, skills and technical awareness</p>
						</div>
					</div>
				</div>
			</section>

		

		<!-- Footer -->
			<section id="footer">
				<ul class="icons">
					<li><a href="#" class="icon brands alt fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="#" class="icon brands alt fa-facebook-f"><span class="label">Facebook</span></a></li>
					<li><a href="#" class="icon brands alt fa-instagram"><span class="label">Instagram</span></a></li>
					<li><a href="#" class="icon brands alt fa-github"><span class="label">GitHub</span></a></li>
					<li><a href="#" class="icon solid alt fa-envelope"><span class="label">Email</span></a></li>
				</ul>
				<ul class="copyright">
					<li>&copy; Untitled</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
				</ul>
			</section>

		<!-- Scripts -->
			<script src="welcome/assets/js/jquery.min.js"></script>
			<script src="welcome/assets/js/jquery.scrolly.min.js"></script>
			<script src="welcome/assets/js/browser.min.js"></script>
			<script src="welcome/assets/js/breakpoints.min.js"></script>
			<script src="welcome/assets/js/util.js"></script>
			<script src="welcome/assets/js/main.js"></script>

	</body>
</html>