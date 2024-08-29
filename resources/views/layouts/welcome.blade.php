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
                position: absolute;
                top: 1rem;
                left: 1rem;
            }

        </style>

	</head>

	<body class="is-preload">

	
		<!-- Header -->
        <section id="header">
		<nav class="navbar-nav">
        <li><i class="fas fa-globe fa-fw"></i>
		
	<a  href="{{ route('change.welcome', ['lang' => 'en']) }}">
      En /
 </a>
	<a  href="{{ route('change.welcome', ['lang' => 'ar']) }}">
      Ar
</a>
	</li>
</nav>

            <div class="inner">
                <span class="icon solid major fa-cloud"></span>
                <h1>@lang('welcome.welcome_message')<br />
               </h1>
                <p>@lang('welcome.welcome_description')</p>
                <ul class="actions special">
                    <li><a href="#one" class="button scrolly">@lang('welcome.discover')</a></li>
                </ul>
            </div>
        </section>

		<!-- One -->
        <section id="one" class="main style1 center-content">
    <div class="container">
        <div class="row gtr-150 justify-content-center">
            <div class="col-6 col-12-medium">
                <header class="major">
                    <h2>@lang('welcome.do_you_have_account')</h2>
                </header>
                <ul class="actions special">
                    <li><a href="/login" class="button wide primary">@lang('welcome.login')</a></li>
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
								<h2>@lang('welcome.about_company') </h2>
							</header>
							<p>@lang('welcome.about_us')
							</p>
							<p>
							@lang('welcome.vision')
							</p>
							<p>@lang('welcome.message')</p>
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

<script>
document.getElementById('language-toggle').addEventListener('click', function() {
    var dropdown = document.getElementById('language-dropdown');
    dropdown.classList.toggle('show');
});
</script>