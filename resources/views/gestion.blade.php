<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comisión Federal de Electricidad | División Bajío') }}
        </h2>
    </x-slot>

    @if (session()->has('message') && session('message') == 'ok2')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                text: "Colaborador agregado",
                icon: "success",
                confirmButtonColor: "#00532C",
                showConfirmButton: true
            });
        </script>
    @endif

    @if (session()->has('message') && session('message') == 'ok3')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                text: "Enlace agregado",
                icon: "success",
                confirmButtonColor: "#00532C",
                showConfirmButton: true
            });
        </script>
    @endif

    @if (session()->has('message') && session('message') == 'ok4')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            text: "Extensión agregada",
            icon: "success",
            confirmButtonColor: "#00532C",
            showConfirmButton: true
        });
    </script>
@endif

    @if(session()->has('message') && session('message') == 'update')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            text: "Datos actualizados",
            icon: "success",
            confirmButtonColor: "#00532C",
            showConfirmButton: true
        });
    </script>
@endif

@if (session()->has('message') && session('message') == 'error')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            text: "Error",
            icon: "error",
            confirmButtonColor: "#00532C",
            showConfirmButton: true
        });
    </script>
@endif

@if($errors->any())
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            text: "{{ $errors->first() }}",
            icon: 'warning',
            confirmButtonColor: '#00532C',
            showConfirmButton: true
        });
    </script>
@endif


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <b>
                        <h1 class="text-success mb-5">GESTIÓN Y ADMINISTRACIÓN: {{ $departamento->nombre }} </h1>
                    </b>

                    <BR></BR>

                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <b>
                                <h3>Gestión de personal</h3>
                            </b>
                        </div>
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#createColaborador">Agregar</button>

                        <div class="modal fade" id="createColaborador" tabindex="-1"
                            aria-labelledby="createColaboradorLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createColaboradorLabel">Agregar colaborador</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Cerrar"></button>
                                    </div>
                                    <form action="{{ route('crear.colaborador') }}" method="POST" enctype="multipart/form-data">

                                        <div class="modal-body">
                                            @csrf

                                            <input type="hidden" name="departamento" value="{{ $departamento->id }}">

                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre completo</label>
                                                <input type="text" name="nombre" id="nombre" class="form-control"
                                                    required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="cargo" class="form-label">Cargo</label>
                                                <select name="cargo" id="cargo" class="form-select" required>
                                                    <option value="" disabled selected>Seleccione un cargo</option>
                                                    @foreach ( $personal as $cargo )
                                                        <option value="{{$cargo->id}}">{{$cargo->puesto}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div id="campo-img" class="mb-3"  style="display: none;">
                                                <label for="img" class="form-label">Fotografía</label>
                                                <input type="file" name="img" id="img" class="form-control">
                                            </div>

                                            <script>
                                                document.getElementById("cargo").addEventListener("change", function() {
                                                    var cargoSeleccionado = this.value;
                                                    if (cargoSeleccionado == 1 || cargoSeleccionado == 2) {
                                                        document.getElementById("campo-img").style.display = "block";
                                                    } else {
                                                        document.getElementById("campo-img").style.display = "none";
                                                    }
                                                });
                                            </script>



<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea name="descripcion" id="descripcion" class="form-control" rows="5"></textarea>
</div>


                                            <div class="mb-3">
                                                <label for="genero" class="form-label">Género</label>
                                                <select name="genero" id="genero" class="form-select" required>
                                                    <option value="" disabled selected>Seleccione un género
                                                    </option>
                                                    <option value="bi bi-person-standing">Masculino</option>
                                                    <option value="bi bi-person-standing-dress">Femenino</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre del colaborador</th>
                                <th>Cargo</th>
                                <th>Gestión</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colaboradores as $colaborador)
                                <tr>
                                    <td>{{ $colaborador->nombre }}</td>
                                    <td>{{ $colaborador->puesto }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                            data-bs-target="#editColaborador_{{ $colaborador->id }}">Editar</button>

                                        <div class="modal fade" id="editColaborador_{{ $colaborador->id }}"
                                            tabindex="-1" aria-labelledby="editColaboradorLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editColaboradorLabel">Editar
                                                            colaborador</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Cerrar"></button>
                                                    </div>
                                                    <form action="{{ route('editar.colaborador') }}" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            @csrf

                                                            <input type="hidden" name="colaborador"
                                                                value="{{ $colaborador->id }}">

                                                            <div class="mb-3">
                                                                <label for="nombre" class="form-label">Nombre
                                                                    completo</label>
                                                                <input type="text" name="nombre" id="nombre"
                                                                    class="form-control" value="{{ $colaborador->nombre }}" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="cargo2_{{ $colaborador->id }}" class="form-label">Cargo</label>
                                                                <select name="cargo2" id="cargo2_{{ $colaborador->id }}" class="form-select" required onchange="mostrarCampoImg({{ $colaborador->id }})">
                                                                    <option value="{{ $colaborador->id_rol }}">{{ $colaborador->puesto }}</option>
                                                                    @foreach ($personal as $cargo)
                                                                        <option value="{{ $cargo->id }}">{{ $cargo->puesto }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <!-- Campo de imagen oculto por defecto -->
                                                            <div id="campo-img2_{{ $colaborador->id }}" class="mb-3" style="display: none;">
                                                                <label for="img" class="form-label">Fotografía</label>
                                                                <input type="file" name="img" id="img_{{ $colaborador->id }}" class="form-control">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="descripcion"
                                                                    class="form-label">Descripción</label>
                                                                    <textarea name="descripcion" id="descripcion" class="form-control" rows="5">{{ $colaborador->descripcion }}</textarea>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="genero"
                                                                    class="form-label">Género</label>
                                                                <select name="genero" id="genero"
                                                                    class="form-select" required>
                                                                    <option value="{{$colaborador->genero}}">
                                                                        @if ($colaborador->genero == 'bi bi-person-standing')
                                                                            Masculino
                                                                        @elseif ($colaborador->genero == 'bi bi-person-standing-dress')
                                                                            Femenino
                                                                        @else
                                                                            No especificado
                                                                        @endif
                                                                    </option>
                                                                    <option value="bi bi-person-standing">Masculino
                                                                    </option>
                                                                    <option value="bi bi-person-standing-dress">
                                                                        Femenino</option>
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                const forms = document.querySelectorAll(".formEliminarColaborador");

                                                forms.forEach(form => {
                                                    form.addEventListener("submit", function(e) {
                                                        e.preventDefault(); // Evita el envío inmediato del formulario

                                                        Swal.fire({
                                                            text: "¿Desea eliminar el registro?",
                                                            icon: "warning",
                                                            showCancelButton: true,
                                                            confirmButtonColor: "red",
                                                            cancelButtonColor: "grey",
                                                            confirmButtonText: "Eliminar"
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                Swal.fire({
                                                                    text: "Registro eliminado",
                                                                    icon: "success",
                                                                    confirmButtonColor: "#00532C",
                                                                    showConfirmButton: true
                                                                }).then(() => {
                                                                    form.submit();
                                                                });
                                                            }
                                                        });
                                                    });
                                                });
                                            });
                                        </script>
                                        <form action="{{ route('eliminar.colaborador', $colaborador->id) }}" method="POST" class="formEliminarColaborador" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                            <script>
                                function mostrarCampoImg(colaboradorId) {
                                    let selectCargo = document.getElementById("cargo2_" + colaboradorId);
                                    let campoImg = document.getElementById("campo-img2_" + colaboradorId);
                                    let valorSeleccionado = parseInt(selectCargo.value);

                                    if (valorSeleccionado === 1 || valorSeleccionado === 2) {
                                        campoImg.style.display = "block";
                                    } else {
                                        campoImg.style.display = "none";
                                    }
                                }

                                // Ejecutar al cargar la página para verificar si se debe mostrar el campo para cada colaborador
                                document.addEventListener("DOMContentLoaded", function() {
                                    @foreach ($colaboradores as $colaborador)
                                        mostrarCampoImg({{ $colaborador->id }});
                                    @endforeach
                                });
                            </script>
                        </tbody>
                    </table>
                    <BR></BR>
                    <hr>
                    <BR></BR>
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <b>
                                <h3>Sitios de interés</h3>
                            </b>
                        </div>
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#createEnlace">Agregar</button>
                        <div class="modal fade" id="createEnlace" tabindex="-1" aria-labelledby="createEnlaceLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createEnlaceLabel">Agregar enlace</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Cerrar"></button>
                                    </div>
                                    <form action="{{ route('crear.enlace') }}" method="POST">
                                        <div class="modal-body">
                                            @csrf

                                            <input type="hidden" name="departamento"
                                                value="{{ $departamento->id }}">

                                            <div class="mb-3">
                                                <label for="descripcion" class="form-label">Descripción</label>
                                                <input type="text" name="descripcion" id="descripcion"
                                                    class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="enlace" class="form-label">Enlace</label>
                                                <input type="text" name="enlace" id="enlace"
                                                    class="form-control" required>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Descripción</th>
                                <th>Gestión</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enlaces as $enlace)
                                <tr>
                                    <td>{{ $enlace->descripcion }}</td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                            data-bs-target="#editEnlace_{{ $enlace->id }}">Editar</button>

                                        <div class="modal fade" id="editEnlace_{{ $enlace->id }}"
                                            tabindex="-1" aria-labelledby="editEnlaceLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editEnlaceLabel">Editar
                                                            enlace</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Cerrar"></button>
                                                    </div>
                                                    <form action="{{ route('editar.enlace') }}" method="POST">
                                                        <div class="modal-body">
                                                            @csrf

                                                            <input type="hidden" name="enlace"
                                                                value="{{ $enlace->id }}">

                                                            <div class="mb-3">
                                                                <label for="descripcion" class="form-label">Descripción
                                                                    completa</label>
                                                                <input type="text" name="descripcion" id="descripcion"
                                                                    class="form-control" value="{{ $enlace->descripcion }}">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="link" class="form-label">Enlace
                                                                    completo</label>
                                                                <input type="text" name="link" id="link"
                                                                    class="form-control" value="{{ $enlace->enlace }}">
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                const forms = document.querySelectorAll(".formEliminarEnlace");

                                                forms.forEach(form => {
                                                    form.addEventListener("submit", function(e) {
                                                        e.preventDefault(); // Evita el envío inmediato del formulario

                                                        Swal.fire({
                                                            text: "¿Desea eliminar el registro?",
                                                            icon: "warning",
                                                            showCancelButton: true,
                                                            confirmButtonColor: "red",
                                                            cancelButtonColor: "grey",
                                                            confirmButtonText: "Eliminar"
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                Swal.fire({
                                                                    text: "Registro eliminado",
                                                                    icon: "success",
                                                                    confirmButtonColor: "#00532C",
                                                                    showConfirmButton: true
                                                                }).then(() => {
                                                                    form.submit();
                                                                });
                                                            }
                                                        });
                                                    });
                                                });
                                            });
                                        </script>
                                        <form action="{{ route('eliminar.enlace', $enlace->id) }}" method="POST" class="formEliminarEnlace" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                Eliminar
                                            </button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <BR></BR>
                    <hr>
                    <BR></BR>
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <b>
                                <h3>Directorio telefónico</h3>
                            </b>
                        </div>
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#createDirectorio">Agregar</button>
                        <div class="modal fade" id="createDirectorio" tabindex="-1" aria-labelledby="createDirectorioLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createDirectorioLabel">Agregar extensión</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Cerrar"></button>
                                    </div>
                                    <form action="{{ route('crear.directorio') }}" method="POST">
                                        <div class="modal-body">
                                            @csrf

                                            <input type="hidden" name="departamento"
                                                value="{{ $departamento->id }}">

                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre completo</label>
                                                <input type="text" name="nombre" id="nombre"
                                                    class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="extension" class="form-label">Extensión</label>
                                                <input type="number" name="extensión" id="extension"
                                                    class="form-control" required>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Descripción</th>
                                <th>Extensión</th>
                                <th>Gestión</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($directorios as $directorio)
                                <tr>
                                    <td>{{ $directorio->nombre }}</td>
                                    <td>{{ $directorio->extension }} </td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary me-2" data-bs-toggle="modal"
                                        data-bs-target="#editDirectorio_{{ $directorio->id }}">Editar</button>

                                    <div class="modal fade" id="editDirectorio_{{ $directorio->id }}"
                                        tabindex="-1" aria-labelledby="editEnlaceLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editEnlaceLabel">Editar
                                                        contacto</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Cerrar"></button>
                                                </div>
                                                <form action="{{ route('editar.directorio') }}" method="POST">
                                                    <div class="modal-body">
                                                        @csrf

                                                        <input type="hidden" name="directorio"
                                                            value="{{ $directorio->id }}">

                                                        <div class="mb-3">
                                                            <label for="nombre" class="form-label">Nombre completo</label>
                                                            <input type="text" name="nombre" id="nombre"
                                                                class="form-control" value="{{ $directorio->nombre }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="extension" class="form-label">Extensión</label>
                                                            <input type="number" name="extensión" id="extension"
                                                                class="form-control" value="{{ $directorio->extension }}">
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit"
                                                            class="btn btn-primary">Guardar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            const forms = document.querySelectorAll(".formEliminarExtension");

                                            forms.forEach(form => {
                                                form.addEventListener("submit", function(e) {
                                                    e.preventDefault(); // Evita el envío inmediato del formulario

                                                    Swal.fire({
                                                        text: "¿Desea eliminar el registro?",
                                                        icon: "warning",
                                                        showCancelButton: true,
                                                        confirmButtonColor: "red",
                                                        cancelButtonColor: "grey",
                                                        confirmButtonText: "Eliminar"
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            Swal.fire({
                                                                text: "Registro eliminado",
                                                                icon: "success",
                                                                confirmButtonColor: "#00532C",
                                                                showConfirmButton: true
                                                            }).then(() => {
                                                                form.submit();
                                                            });
                                                        }
                                                    });
                                                });
                                            });
                                        });
                                    </script>
                                    <form action="{{ route('eliminar.directorio', $directorio->id) }}" method="POST" class="formEliminarExtension" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
