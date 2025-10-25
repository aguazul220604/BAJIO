<!DOCTYPE html>
<html class="no-js">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Subgerencia de distribución</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="FreeHTML5.co" />

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


	<!-- Animate.css -->
    @vite('resources/css/animate.css')
    @vite('resources/css/icomoon.css')
    @vite('resources/css/bootstrap.css')
    @vite('resources/css/flexslider.css')
    @vite('resources/css/style.css')

	<!-- Modernizr JS -->
    <script src="{{asset('js/modernizr-2.6.2.min.js')}}"></script>

	</head>
	<body>
	<div id="fh5co-page">

		<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
		<aside id="fh5co-aside" role="complementary" class="border js-fullheight">
			   <div id="tittle">
        SUBGERENCIA DE<br>DISTRIBUCIÓN
    </div>

    <br>
    <div class="contenedor-departamentos">
        @foreach($departamentos as $departamento)
            <p class="fh5co-tittle-colored">
                <a href="{{ route('about', ['id' => $departamento->id] ) }}">{{ $departamento->nombre }}</a>
            </p>
        @endforeach
    </div>
	<div class="fh5co-footer">
        <p><small>&copy; 2025 Subgerencia de Distribución Bajío</span> <span> <a href="obras y materiales" target="_blank"></a> </span> <span>Pastita #55 Guanajuato, Gto <a href="https://www.cfe.mx/Pages/default.aspx" target="_blank">CFE Nacional</a> </span></small></p>

        <ul class="d-flex list-inline m-0 p-0">
            <li class="list-inline-item mx-2">
                <a href="https://www.facebook.com/CFENacional/?locale=es_LA"><i class="bi bi-facebook"></i></a>
            </li>
            <li class="list-inline-item mx-2">
                <a href="https://x.com/CFEmx?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor&mx=2"><i class="bi bi-twitter"></i></a>
            </li>
            <li class="list-inline-item mx-2">
                <a href="https://www.instagram.com/cfe_nacional/?hl=es"><i class="bi bi-instagram"></i></a>
            </li>
            <li class="list-inline-item mx-2">
                <a href="https://mx.linkedin.com/company/comisi-n-federal-de-electricidad"><i class="bi bi-linkedin"></i></a>
            </li>
        </ul>
    </div>
		</aside>

		<div id="fh5co-main">

			<aside id="fh5co-hero" class="js-fullheight">
				<div class="flexslider js-fullheight">
					<ul class="slides">


                        @foreach($lugares as $lugar)
                        <li style="background-image: url('{{ asset($lugar->img) }}');">
                            <div class="overlay"></div>

				   		<div class="container-fluid">
				   			<div class="row">
					   			<div class="col-md-8 col-md-offset-2 text-center js-fullheight slider-text">
					   				<div class="slider-text-inner">
					   					<h1><strong>{{ $lugar->lugar}}</strong></h1>
                                        <br>
                                        <h2>{{$lugar->ubicacion}}</h2>
					   				</div>
					   			</div>
					   		</div>
				   		</div>
				   	</li>
                          @endforeach

				  	</ul>
			  	</div>
			</aside>

            <BR></BR>
            <BR></BR>
            <div class="fh5co-narrow-content">
                <h2 class="fh5co-heading animate-box text-center" data-animate-effect="fadeInLeft">Anexos informativos</h2>
                <BR></BR>
                <BR></BR>
  <div class="container d-flex justify-content-center">
    <div class="row text-center">
      <div class="col-12 col-md-4">
        <div class="p-3 border bg-light">
            <a href="{{route('guardias')}}">
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="mb-2">
                        <i class="bi bi-person-check-fill" style="font-size: 80px;"></i>
                    </div>
                    <div>
                        <p class="fh5co-heading-colored">GUARDIAS</p>
                        <p class="text-muted">Calendario Divisional</p>
                    </div>
                </div>
            </a>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="p-3 border bg-light">
            <a href="{{route('diagramas')}}">
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="mb-2">
                    <i class="bi bi-diagram-3" style="font-size: 80px;"></i>
                    </div>
                    <div>
                        <p class="fh5co-heading-colored">DIAGRAMAS UNIFILARES</p>
                        <p class="text-muted">División Bajío</p>
                    </div>
                </div>
            </a>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="p-3 border bg-light">
            <a href="{{route('noticias')}}">
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="mb-2">
                    <i class="bi bi-newspaper" style="font-size: 80px;"></i>
                    </div>
                    <div>
                        <p class="fh5co-heading-colored">NOVEDADES</p>
                        <p class="text-muted">Noticias Bajío</p>
                    </div>
                </div>
            </a>
        </div>
      </div>
    </div>
  </div>
<br>
  <div class="container d-flex justify-content-center align-items-center" style="height: 50vh;">
    <div class="row w-100 text-center">
      <div class="col-12 col-md-6 mb-3">
        <div class="p-4 border bg-light">
            <a href="{{route('sitios')}}">
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="mb-2">
                    <i class="bi bi-globe2" style="font-size: 80px;"></i>
                    </div>
                    <div>
                        <p class="fh5co-heading-colored">SITIOS DE INTERÉS</p>
                        <p class="text-muted">Portales Web</p>
                    </div>
                </div>
            </a>
        </div>
      </div>
      <div class="col-12 col-md-6 mb-3">
        <div class="p-4 border bg-light">
            <a href="{{route('directorio')}}">
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="mb-2">
                    <i class="bi bi-telephone-plus-fill" style="font-size: 80px;"></i>
                    </div>
                    <div>
                        <p class="fh5co-heading-colored">DIRECTORIO TELEFÓNICO</p>
                        <p class="text-muted">Extensiones Telefónicas</p>
                    </div>
                </div>
            </a>
        </div>
      </div>
    </div>
  </div>

<div class="fh5co-narrow-content">
    <div id="get-in-touch">
        <div class="fh5co-narrow-content">
            <div class="row">
                <div class="col-md-4 animate-box" data-animate-effect="fadeInLeft">
             <h1 class="fh5co-heading-colored">¡CFE, está contigo!</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-md-pull-3 animate-box" data-animate-effect="fadeInLeft">
                    <p class="fh5co-lead">Subgerencia de Distribución, Sitio Oficial</p>
                    <p><a href="https://www.cfe.mx/Pages/default.aspx" class="btn btn-primary">Ir a Portal Bajío</a></p>
                    <p><small><span>&copy; 2025 Subgerencia de Distribución Bajío. Pastita #55 Guanajuato, Gto.</span></small></p>

                </div>
                <div>
                    <ul class="d-flex list-inline m-0 p-0">
                        <li class="list-inline-item mx-2">
                            <a href="https://www.facebook.com/CFENacional/?locale=es_LA"><i class="bi bi-facebook"></i></a>
                        </li>
                        <li class="list-inline-item mx-2">
                            <a href="https://x.com/CFEmx?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor&mx=2"><i class="bi bi-twitter"></i></a>
                        </li>
                        <li class="list-inline-item mx-2">
                            <a href="https://www.instagram.com/cfe_nacional/?hl=es"><i class="bi bi-instagram"></i></a>
                        </li>
                        <li class="list-inline-item mx-2">
                            <a href="https://mx.linkedin.com/company/comisi-n-federal-de-electricidad"><i class="bi bi-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
		</div>
	</div>

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.easing.1.3.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('js/jquery.flexslider-min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>

	</body>
</html>
