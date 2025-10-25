<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comisión Federal de Electricidad | División Bajío') }}
        </h2>
    </x-slot>

    @if (session()->has('message') && session('message') == 'ok')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            text: "Archivo agregado",
            icon: "success",
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

                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <b><h1 class="text-success">GESTIÓN DE DIAGRAMAS UNIFILARES</h1></b>

                        </div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createArchivo">Agregar</button>
                                            <div class="modal fade" id="createArchivo" tabindex="-1" aria-labelledby="createArchivoLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="createArchivoLabel">Agregar archivo</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                        </div>
                                                        <form action="{{route('crear.archivo')}}" method="POST" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                @csrf

                                                                <div class="mb-3">
                                                                    <label for="zona" class="form-label">Subestación</label>
                                                                    <select name="zona" id="zona" class="form-select" required>
                                                                        <option selected disabled>Seleccione la subestación</option>
                                                                        @foreach ($zonas as $zona)
                                                                            <option value="{{ $zona->id }}">{{ $zona->nombre }}</option>
                                                                        @endforeach
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

                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre de la Subestación</th>
                                <th>Archivos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subestaciones as $subestacion)
                                <tr>
                                    <td class="align-middle">
                                        {{ $subestacion['nombre'] }}
                                    </td>
                                    <td>
                                        <ul class="list-unstyled m-0 p-0">
                                            @foreach($subestacion['archivos'] as $archivo)
                                            <li class="archivo-item d-flex justify-content-between align-items-center border-bottom py-2 px-3">
                                                <span>📂 {{ $archivo['nombre'] }}</span>

                                                <div class="d-flex gap-2">
                                                    <!-- Botón Abrir -->
                                                    <a href="{{ route('archivo.abrir', $archivo) }}" target="_blank" class="btn btn-primary btn-sm">
                                                        Abrir
                                                    </a>

                                                    <!-- Botón Eliminar -->
                                                    <form action="{{ route('archivo.eliminar', $archivo['id']) }}" method="POST" class="formEliminar d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </li>
                                        @endforeach

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
    </div>
</x-app-layout>
