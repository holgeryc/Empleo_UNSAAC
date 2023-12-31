@section('title', __('Registros'))
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <h4><i class="fa fa-bars text-info"></i>
                                Registros</h4>
                        </div>
                        @if (session()->has('message'))
                            <div wire:poll.4s class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;">
                                {{ session('message') }} </div>
                        @endif
                        <div>
                            <input wire:model='keyWord' type="text" class="form-control" name="search"
                                id="search" placeholder="Buscar Registros">
                        </div>
                        @auth
                            @if (Auth::user()->Tipo != 'Contador')
                                <select wire:model="institutoSeleccionado" class="form-control" style="width: 200px;">
                                    <option value="">Seleccionar Instituto</option>
                                    @foreach ($institutos as $instituto)
                                        <option value="{{ $instituto->RUC }}">{{ $instituto->Nombre }}</option>
                                    @endforeach
                                </select>
                            @endif
                        @endauth
                        <select wire:model="mesSeleccionado" class="form-control" style="width: 200px;">
                            <option value="">Seleccione meses</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                        <input wire:model='anioSeleccionado' type="text" class="form-control" style="width: 200px;"
                            placeholder="Ingrese Año">
                        <div>
                            <a href="{{ route('generar-pdf', [$mesSeleccionado, $anioSeleccionado, $institutoSeleccionado, $keyWord]) }}"
                                class="btn btn-sm btn-info" target="_blank">
                                <i class="fa fa-file-pdf-o"></i> Generar PDF
                            </a>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @auth
                            @if (Auth::user()->Tipo === 'Administrador' || Auth::user()->Tipo === 'Contador')
                                <div class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createDataModal">
                                    <i class="fa fa-plus"></i> Agregar Registros
                                </div>
                            @endif
                        @endauth

                    </div>
                </div>

                <div class="card-body">
                    @include('livewire.registros.modals')
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead">
                                <tr>
                                    <td>#</td>
                                    <th>Fecha</th>
                                    <th>N° Voucher</th>
                                    <th>N° Cheque</th>
                                    <th>C_P</th>
                                    <th>Nombres y Apellidos</th>
                                    <th>Detalle</th>
                                    <th>Entrada</th>
                                    <th>Salida</th>
                                    <th>Saldo</th>
                                    <th>Instituto</th>
                                    <th>Activado</th>
                                    @auth
                                        @if (Auth::user()->Tipo === 'Administrador' || Auth::user()->Tipo === 'Contador')
                                            <td>Acciones</td>
                                        @endif
                                    @endauth
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registros as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->FechaFormateada }}</td>
                                        <td>{{ $row->N°_Voucher }}</td>
                                        <td>{{ $row->N°_Cheque }}</td>
                                        <td>{{ $row->C_P }}</td>
                                        <td>{{ $row->Nombres_y_Apellidos }}</td>
                                        <td>{{ $row->Detalle }}</td>
                                        <td>{{ $row->Entrada }}</td>
                                        <td>{{ $row->Salida }}</td>
                                        <td>{{ $row->Saldo }}</td>
                                        <td>{{ $row->Nombre }}</td>
                                        <td>{{ $row->Activado }}</td>
                                        @auth
                                            @if (Auth::user()->Tipo === 'Administrador')
                                                <td width="90">
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-secondary dropdown-toggle" href="#"
                                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Acciones
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li><a data-bs-toggle="modal" data-bs-target="#updateDataModal"
                                                                    class="dropdown-item"
                                                                    wire:click="edit({{ $row->id }})"><i
                                                                        class="fa fa-edit"></i> Editar </a></li>
                                                            <li><a class="dropdown-item"
                                                                    onclick="confirm('Confirm Delete Registro id {{ $row->id }}? \nDeleted Registros cannot be recovered!')||event.stopImmediatePropagation()"
                                                                    wire:click="destroy({{ $row->id }})"><i
                                                                        class="fa fa-trash"></i> Eliminar </a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            @endif
                                            @if (Auth::user()->Tipo === 'Contador' && $row->Activado)
                                                <td width="90">
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-secondary dropdown-toggle" href="#"
                                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Acciones
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li><a data-bs-toggle="modal" data-bs-target="#updateDataModal"
                                                                    class="dropdown-item"
                                                                    wire:click="edit({{ $row->id }})"><i
                                                                        class="fa fa-edit"></i> Editar </a></li>
                                                            <li><a class="dropdown-item"
                                                                    onclick="confirm('Confirm Delete Registro id {{ $row->id }}? \nDeleted Registros cannot be recovered!')||event.stopImmediatePropagation()"
                                                                    wire:click="destroy({{ $row->id }})"><i
                                                                        class="fa fa-trash"></i> Eliminar </a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            @endif
                                        @endauth
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">No data Found </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="float-end">{{ $registros->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
