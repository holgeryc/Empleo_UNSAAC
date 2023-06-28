@section('title', __('Institutos'))

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <h4><i class="fa-fw fas fa-home text-danger"></i>
                                Institutos</h4>
                        </div>
                        @if (session()->has('message'))
                            <div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;">
                                {{ session('message') }} </div>
                        @endif
                        <div>
                            <input wire:model='keyWord' type="text" class="form-control" name="search"
                                id="search" placeholder="Buscar Institutos">
                        </div>
                        <div class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#createDataModal">
                            <i class="fa fa-plus"></i> Agregar Institutos
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('livewire.institutos.modals')

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead">
                                <tr>
                                    <td>#</td>
                                    <th>Ruc</th>
                                    <th>Nombre</th>
                                    <th>Cuenta Corriente</th>
                                    <td>Acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($institutos as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->RUC }}</td>
                                        <td>{{ $row->Nombre }}</td>
                                        <td>{{ $row->Cuenta_Corriente }}</td>
                                        <td width="90">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-secondary dropdown-toggle" href="#"
                                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Acciones
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a data-bs-toggle="modal" data-bs-target="#updateDataModal"
                                                            class="dropdown-item"
                                                            wire:click="edit({{ $row->RUC }})"><i
                                                                class="fa fa-edit"></i> Editar </a></li>
                                                    <li><a class="dropdown-item"
                                                            onclick="confirm('Confirm Delete Instituto RUC {{ $row->RUC }}? \nDeleted Institutos cannot be recovered!')||event.stopImmediatePropagation()"
                                                            wire:click="destroy({{ $row->RUC }})"><i
                                                                class="fa fa-trash"></i> Eliminar </a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">No data Found </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="float-end">{{ $institutos->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
