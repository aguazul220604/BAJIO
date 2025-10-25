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
            text: "Datos agregados",
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
                            <b><h1 class="text-success">GESTIÓN DE NOVEDADES</h1></b>

                        </div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal1">Agregar</button>
                        <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="text-base">Crear nuevo anuncio</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('noticias.createNovedades') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="container">
                                                <div class="mb-3">
                                                    <label for="Descripcion" class="form-label">Descripción</label>
                                                    <textarea name="Descripcion" id="Descripcion" class="form-control" rows="5"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="Imagen" class="form-label">Imagen</label>
                                                    <input type="file" class="form-control" name="Imagen" id="Imagen">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger text-white"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary text-white" id="confirmButton">Registrar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Imagen</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($noticias as $noticia)
                            <tr>
                                <td><img src="{{ asset($noticia->img) }}" alt="novedades" class="img-fluid" style="max-width: 150px;"></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop_{{ $noticia->id }}">
                                            Editar
                                        </button>
                                        <div class="modal fade" id="staticBackdrop_{{ $noticia->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="text-base" id="escanerLabel">Editar novedad</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('noticias.editNovedades') }}" method="POST"  enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="container">
                                                                @csrf
                                                                <input type="hidden" name="ID" value="{{ $noticia->id }}">
                                                                <div class="mb-3">
                                                                    <label for="Descripcion" class="form-label">Descripción</label>
                                                                    <textarea name="Descripcion" id="Descripcion" class="form-control" rows="5">{{ $noticia->descripcion }}</textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="Imagen" class="form-label">Imagen</label>
                                                                    <input type="file" class="form-control" name="Imagen" id="Imagen">
                                                                    <img src="{{ asset($noticia->img) }}" alt="novedades" class="img-fluid" style="max-width: 150px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger text-white"
                                                                data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-primary text-white"
                                                                id="confirmButton">Actualizar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('noticias.deleteNovedades', $noticia->id) }}" method="POST"
                                            class="formEliminar">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Eliminar
                                            </button>
                                        </form>
                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                const forms = document.querySelectorAll(".formEliminar");

                                                forms.forEach(form => {
                                                    form.addEventListener("submit", function(e) {
                                                        e.preventDefault();

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

