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
            text: "Departamento agregado",
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
                    <b><h1 class="text-success">ADMINISTRACIÓN DE DEPARTAMENTOS</h1></b>
                </div>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
                                        Agregar
                                    </button>

                                <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="createModalLabel">Agregar departamento</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <form action="{{route('crear.departamento')}}" method="POST">
                                                <div class="modal-body">
                                                    @csrf
                                                    <label for="nombre" class="form-label">Nombre de departamento</label>
                                                    <input type="text" name="nombre" id="nombre" class="form-control">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div><br>

                                <table class="table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nombre del departamento</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($departamentos as $departamento)
                                            <tr>
                                                <td>{{ $departamento->nombre }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-end">
                                                    <!-- Botón de Editar -->
                                                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editModal_{{$departamento->id}}">
                                                        Editar
                                                    </button>

                                                    <!-- Modal de Bootstrap -->
                                                    <div class="modal fade" id="editModal_{{$departamento->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel">Editar departamento</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                                </div>
                                                                <form action="{{ route('editar.departamento', $departamento->id) }}" method="POST">
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        <label for="nombre" class="form-label">Nombre de departamento</label>
                                                                        <input type="text" name="nombre" id="nombre" value="{{ $departamento->nombre }}" class="form-control">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const forms = document.querySelectorAll(".formEliminar");

        forms.forEach(form => {
            form.addEventListener("submit", function(e) {
                e.preventDefault(); // Evita el envío inmediato del formulario

                Swal.fire({
                    text: "¿Desea eliminar el departamento?",
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

                                                    <!-- Formulario para Eliminar -->
                                                    <form action="{{ route('eliminar.departamento', $departamento->id) }}" method="POST" class="formEliminar" style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger me-2">
                                                            Eliminar
                                                        </button>
                                                    </form>

                                                    <!-- Botón de Editar -->
                                                    <a href="{{ route('gestion', ['id' => $departamento->id] ) }}"><button type="button" class="btn btn-warning me-2">
                                                        Gestionar
                                                    </button></a>
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



