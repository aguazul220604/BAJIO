<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comisión Federal de Electricidad | División Bajío') }}
        </h2>
    </x-slot>

    @if(session()->has('message') && session('message') == 'ok')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            text: "Calendario agregado",
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

@if(session()->has('message') && session('message') == 'error')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            text: "Error de actualización",
            icon: "error",
            confirmButtonColor: "#00532C",
            showConfirmButton: true
        });
    </script>
@endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <b><h1 class="text-success">GESTIÓN DE CALENDARIOS DE GUARDIAS</h1></b>

                        </div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createArchivo">Agregar</button>
                                            <div class="modal fade" id="createArchivo" tabindex="-1" aria-labelledby="createArchivoLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="createArchivoLabel">Agregar archivo</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <form action="{{route('crear.calendario')}}" method="POST" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                @csrf

                                                                <div class="mb-3">
                                                                    <label for="fecha" class="form-label">Fecha</label>
                                                                    <input type="date" name="fecha" id="fecha" class="form-control">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="tipo" class="form-label">Categoría</label>
                                                                    <select name="tipo" id="tipo" class="form-select" required>
                                                                        <option selected disabled>Seleccione la categoría</option>
                                                                        <option value="nacional">Nacional</option>
                                                                        <option value="divisional">Divisional</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="archivo" class="form-label">Archivo</label>
                                                                    <input type="file" name="archivo" id="archivo" class="form-control" required accept=".pdf">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                    </div> <br>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Fecha</th>
                                <th>Categoría</th>
                                <th>Archivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $calendarios as $calendario )
                            <tr>
                                <td>{{$calendario->fecha}}</td>

                                <td>{{ ucfirst(Str::lower($calendario->tipo)) }}</td>
                                <td>
                                    <ul class="list-unstyled m-0 p-0">
                                        <li class="archivo-item d-flex justify-content-between align-items-center border-bottom py-2 px-3">
                                    <span>📂 {{$calendario->archivo}}</span>

                                    <div class="d-flex gap-2">
                                    <a href="{{ route('calendario.abrir', $calendario->archivo) }}" target="_blank" class="btn btn-primary btn-sm">
                                        Abrir
                                    </a>

                                    <form action="{{ route('calendario.eliminar', $calendario->id) }}" method="POST" class="formEliminar d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </li>
                            </ul>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const forms = document.querySelectorAll(".formEliminar");

                            forms.forEach(form => {
                                form.addEventListener("submit", function(e) {
                                    e.preventDefault();

                                    Swal.fire({
                                        text: "¿Desea eliminar el archivo?",
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "red",
                                        cancelButtonColor: "grey",
                                        confirmButtonText: "Eliminar"
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            Swal.fire({
                                                text: "Archivo eliminado",
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
            </div>
        </div>
    </div>
</x-app-layout>








