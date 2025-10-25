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
                @if ($departamento->id !== 1)
                    DEPARTAMENTO DE <br>
                    {{ $departamento->nombre }}
                @else
                {{ $departamento->nombre }}
                @endif
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
				<div class="row row-bottom-padded-md">
					<div class="col-md-6 animate-box" data-animate-effect="fadeInLeft">
						<img class="img-responsive" src="{{ asset($principal->img) }}" alt="Imagen">
					</div>
					<div class="col-md-6 animate-box" data-animate-effect="fadeInLeft">
						<h2 class="fh5co-heading">{{ $principal->nombre }}</h2>
						<p>{!! nl2br(e($principal->descripcion)) !!}</p>
                        <br>
					</div>
				</div>
			</div>

			<div class="fh5co-narrow-content">
					<div class="row">
                        @if ($colaboradores->isNotEmpty())
                        <h2 class="fh5co-heading animate-box" data-animate-effect="fadeInLeft">Organigrama</h2>
                        <div style="display: flex; justify-content: center; flex-direction: column; align-items: center;">

                            @php
                            $cargo1 = collect($colaboradores)->contains(fn($colaborador) => $colaborador->id_rol == '1');
                        @endphp
                        @if($cargo1)
                            <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                                <h3 style="text-align: left; margin-left: -10px;">SUBGERENTE</h3>
                            </div>
                        @endif
                        @foreach($colaboradores as $colaborador)
    @if($colaborador->id_rol == 1)
    <div class="card text-center d-flex align-items-center" style="width: 18rem; margin: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <i class="{{ $colaborador->genero }} fa-2x mt-3" style="color: #007bff;"></i>
        <br>
        <div class="card-body p-3">
            <h1 class="card-title mb-2 text-truncate" style="font-size: 1.25rem;">{{ $colaborador->nombre }}</h1>
        </div>
    </div>
    @endif
@endforeach

                            @php
                            $cargo2 = collect($colaboradores)->contains(fn($colaborador) => $colaborador->id_rol == '2');
                        @endphp
                        @if($cargo2)
                        <br>
                            <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                                <h3 style="text-align: left; margin-left: -10px;">JEFE DE DEPARTAMENTO</h3>
                            </div>
                        @endif
                        @foreach($colaboradores as $colaborador)
    @if($colaborador->id_rol == 2)
    <div class="card text-center d-flex align-items-center" style="width: 18rem; margin: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <i class="{{ $colaborador->genero }} fa-2x mt-3" style="color: #007bff;"></i>
        <br>
        <div class="card-body p-3">
            <h1 class="card-title mb-2 text-truncate" style="font-size: 1.25rem;">{{ $colaborador->nombre }}</h1>
        </div>
    </div>
    @endif
@endforeach




@php
$cargo3 = collect($colaboradores)->contains(fn($colaborador) => $colaborador->id_rol == 3);
@endphp
@if($cargo3)
<br>
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <h3 style="text-align: left; margin-left: -10px;">JEFES DE OFICINA</h3>
</div>
@endif
<div style="display: flex; justify-content: center; gap: 20px;">
  @foreach($colaboradores as $colaborador)
  @if($colaborador->id_rol == 3)
      <div class="card text-center d-flex align-items-center" style="width: 18rem; margin: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <i class="{{ $colaborador->genero }} fa-2x mt-3" style="color: #007bff;"></i>
        <br>
        <div class="card-body p-3">
            <h1 class="card-title mb-2 text-truncate" style="font-size: 1.25rem;">{{ $colaborador->nombre }}</h1>
        </div>
    </div>
      @endif
  @endforeach
</div>



@php
$cargo4 = collect($colaboradores)->contains(fn($colaborador) => $colaborador->id_rol == 4);
@endphp
@if($cargo4)
<br>
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <h3 style="text-align: left; margin-left: -10px;">SUPERVISORES</h3>
</div>
@endif
<div style="display: flex; justify-content: center; gap: 20px;">
  @foreach($colaboradores as $colaborador)
  @if($colaborador->id_rol == 4)
      <div class="card text-center d-flex align-items-center" style="width: 18rem; margin: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <i class="{{ $colaborador->genero }} fa-2x mt-3" style="color: #007bff;"></i>
        <br>
        <div class="card-body p-3">
            <h1 class="card-title mb-2 text-truncate" style="font-size: 1.25rem;">{{ $colaborador->nombre }}</h1>
        </div>
    </div>
      @endif
  @endforeach
</div>


@php
$cargo5 = collect($colaboradores)->contains(fn($colaborador) => $colaborador->id_rol == 5);
@endphp
@if($cargo5)
<br>
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <h3 style="text-align: left; margin-left: -10px;">PROFESIONISTAS</h3>
</div>
@endif
<div style="display: flex; justify-content: center; gap: 20px;">
  @foreach($colaboradores as $colaborador)
  @if($colaborador->id_rol == 5)
      <div class="card text-center d-flex align-items-center" style="width: 18rem; margin: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <i class="{{ $colaborador->genero }} fa-2x mt-3" style="color: #007bff;"></i>
        <br>
        <div class="card-body p-3">
            <h1 class="card-title mb-2 text-truncate" style="font-size: 1.25rem;">{{ $colaborador->nombre }}</h1>
        </div>
    </div>
      @endif
  @endforeach
</div>



@php
$cargo6 = collect($colaboradores)->contains(fn($colaborador) => $colaborador->id_rol == 6);
@endphp
@if($cargo6)
<br>
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <h3 style="text-align: left; margin-left: -10px;">OFICINISTAS</h3>
</div>
@endif
<div style="display: flex; justify-content: center; gap: 20px;">
  @foreach($colaboradores as $colaborador)
  @if($colaborador->id_rol == 6)
      <div class="card text-center d-flex align-items-center" style="width: 18rem; margin: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <i class="{{ $colaborador->genero }} fa-2x mt-3" style="color: #007bff;"></i>
        <br>
        <div class="card-body p-3">
            <h1 class="card-title mb-2 text-truncate" style="font-size: 1.25rem;">{{ $colaborador->nombre }}</h1>
        </div>
    </div>
      @endif
  @endforeach
</div>




@php
$cargo7 = collect($colaboradores)->contains(fn($colaborador) => $colaborador->id_rol == 7);
@endphp
@if($cargo7)
<br>
<div style="display: flex; justify-content: center; margin-bottom: 20px;">
    <h3 style="text-align: left; margin-left: -10px;">AUXILIARES</h3>
</div>
@endif
<div style="display: flex; justify-content: center; gap: 20px;">
  @foreach($colaboradores as $colaborador)
  @if($colaborador->id_rol == 7)
      <div class="card text-center d-flex align-items-center" style="width: 18rem; margin: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <i class="{{ $colaborador->genero }} fa-2x mt-3" style="color: #007bff;"></i>
        <br>
        <div class="card-body p-3">
            <h1 class="card-title mb-2 text-truncate" style="font-size: 1.25rem;">{{ $colaborador->nombre }}</h1>
        </div>
    </div>
      @endif
  @endforeach
</div>




</div>
@endif

<BR></BR>
<BR></BR>
@if ($enlaces->isNotEmpty())
<h2 class="fh5co-heading animate-box" data-animate-effect="fadeInLeft">Sitios de interés</h2>
<div class="container mt-4">
    <div class="row">
       @foreach($enlaces->chunk(ceil($enlaces->count() / 2)) as $columna)
       <div class="col-md-6">
           <ul class="list-unstyled">
               @foreach($columna as $enlace)
                   <li class="mb-2">
                       <i class="bi bi-link-45deg text-primary"></i>
                       <a href="{{ $enlace->enlace }}" target="_blank" class="text-decoration-none">
                           {{ $enlace->descripcion }}
                       </a>
                   </li>
               @endforeach
           </ul>
       </div>
   @endforeach
    </div>
</div>
@endif

<BR></BR>
<BR></BR>
@if ($extensiones->isNotEmpty())
<h2 class="fh5co-heading animate-box" data-animate-effect="fadeInLeft">Extensiones telefónicas</h2>
<div class="d-flex flex-column gap-3 mb-5">
    @foreach($extensiones as $extension)
    <div class="border p-3 rounded shadow-sm d-flex align-items-center gap-3">
        <!-- Icono -->
        <i class="bi bi-telephone-plus-fill text-primary fs-4"></i>

        <!-- Extensión -->
        <span class="text-muted fs-5">{{ $extension->extension }}</span>

        <!-- Nombre -->
        <h4 class="mb-0">{{ $extension->nombre }}</h4>
    </div>
    @endforeach
</div>
@endif
<BR></BR>
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


    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.easing.1.3.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('js/jquery.flexslider-min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
	</body>
</html>
