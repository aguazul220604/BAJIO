<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comisión Federal de Electricidaad | División Bajío') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-success mb-5" data-bs-toggle="modal" data-bs-target="#createModal">
                                Agregar colaborador
                            </button>
                        </div>

                        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createModalLabel">Agregar coalborador</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <form action="{{ route('crear.colaborador') }}" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="nombre" class="form-label">Nombre completo</label>
                                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="departamento" class="form-label">Departamento</label>
                                                <select name="departamento" id="departamento" class="form-select" required>
                                                    <option value="" disabled selected>Seleccione un departamento</option>
                                                    @foreach ($departamentos as $departamento)
                                                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="descripcion" class="form-label">Descripción</label>
                                                <input type="text" name="descripcion" id="descripcion" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label for="foto" class="form-label">Fotografía</label>
                                                <input type="file" name="foto" id="foto" class="form-control">
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

                           <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-left" colspan="2">Jefe de departamento</th>
                                    <th class="text-left" colspan="2">Colaboradores</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($colaboradoresPorJefe as $idJefe => $colaboradores)
                                    @php
                                        // Filtrar los colaboradores que tienen datos válidos
                                        $colaboradoresValidos = collect($colaboradores)->filter(function($colaborador) {
                                            return !is_null($colaborador->id) && !is_null($colaborador->nombre_colaborador);
                                        });
                                    @endphp

                                    @foreach ($colaboradores as $index => $colaborador)
                                        <tr>
                                            @if ($index == 0)
                                                <td rowspan="{{ max(1, $colaboradoresValidos->count()) }}">
                                                    {{ $colaborador->nombre_jefe }}
                                                </td>
                                                <td rowspan="{{ max(1, $colaboradoresValidos->count()) }}"><button class="btn btn-primary">Editar</button></td>
                                            @endif
                                            <td>
                                                {{ $colaborador->nombre_colaborador ?? 'No hay colaboradores' }}
                                            </td>
                                            <td class="text-center">
                                                @if ($colaboradoresValidos->isNotEmpty())
                                                <a href="{{ route('editar.colaborador', $colaborador->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('colaboradores.destroy', $colaborador->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este colaborador?')">
                                                        <i class="fas fa-trash-alt"></i> Eliminar
                                                    </button>
                                                </form>
                                                @else
                                                    <p>No hay colaboradores</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
