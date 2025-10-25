<!DOCTYPE html>
<html class="no-js">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>GERENCIA</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Website Template by FreeHTML5.co" />
	<meta name="keywords" content="free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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
            <div id="return-home" class="d-flex justify-content-center align-items-center w-100">
                <a href="{{ route('index')}}">
                    <button class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="bi bi-house-door-fill"></i> Regresar a Inicio
                    </button>
                </a>
            </div>
			<br><br>
            <div id="tittle">
                DIRECTORIO <br> TELEFÓNICO
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

			<div class="fh5co-narrow-content">
				<h2 class="fh5co-heading animate-box" data-animate-effect="fadeInLeft">Extensiones Telefónicas</h2>
					<div class="row">

  <!-- Navbar horizontal -->
  <div class="navbar-container">
    <div class="navbar" id="navbar">
        @foreach ($directorio as $id => $departamento)
            <div class="nav-item" onclick="showContent('{{ $id }}')">{{ $departamento['nombre'] }}</div>
        @endforeach
    </div>
</div>

<!-- Contenedor para mostrar información del departamento seleccionado -->
<div class="content" id="content-box">
    <h2 id="content-title"></h2>
    <ul class="extensiones" id="content-list"></ul>
</div>

<script>
    const navbar = document.getElementById("navbar");
    const contentBox = document.getElementById("content-box");
    const contentTitle = document.getElementById("content-title");
    const contentList = document.getElementById("content-list");

    // Objeto con la información de los departamentos (se llena con Blade)
    const departamentosData = @json($directorio);

    function showContent(id) {
        let departamento = departamentosData[id];

        if (departamento) {
            contentTitle.textContent = departamento.nombre;
            contentList.innerHTML = "";

            if (departamento.extensiones.length > 0) {
                departamento.extensiones.forEach(ext => {
                    let li = document.createElement("li");
                    li.innerHTML = `<i class="bi bi-telephone-plus-fill text-primary fs-4"></i> ${ext.nombre}  <strong>${ext.extension}</strong>`;
                    contentList.appendChild(li);
                });
            } else {
                contentList.innerHTML = "<li>No hay extensiones registradas</li>";
            }

            contentBox.style.display = "block"; // Mostrar el div de contenido
        }
    }
</script>
                      <BR></BR>
				<div class="fh5co-narrow-content">
				<div class="row">
					<div class="col-md-4 animate-box" data-animate-effect="fadeInLeft">
						<h1 class="fh5co-heading-colored">Más información</h1>
					</div>
				</div>
				<div class="row">
					<div class="col-md-7 col-md-offset-3 col-md-pull-3 animate-box" data-animate-effect="fadeInLeft">
                        <p><a href="https://www.cfe.mx/Pages/default.aspx" class="btn btn-primary">Ir a Portal Bajío</a></p>
                        <p><small><span>&copy; 2025 Subgerencia de Distribución Bajío. Pastita #55 Guanajuato, Gto.</span></small></p>
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
