<!-- Add Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Create New Registro</h5>
                <button wire:click.prevent="cancel()" type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="Fecha">Fecha</label>
                        <input wire:model="Fecha" type="date" class="form-control" id="Fecha"
                            placeholder="Fecha">
                        @error('Fecha')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Campo obligatorio.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="N°_Voucher">N° Voucher</label>
                        <input wire:model="N°_Voucher" type="text" class="form-control" id="N°_Voucher"
                            placeholder="N° Voucher">
                        @error('N°_Voucher')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Campo obligatorio si N° Cheque esta vacio.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="N°_Cheque">N° Cheque</label>
                        <input wire:model="N°_Cheque" type="text" class="form-control" id="N°_Cheque"
                            placeholder="N° Cheque">
                        @error('N°_Cheque')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Campo obligatorio si N° Voucher esta vacio.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="C_P">C P</label>
                        <input wire:model="C_P" type="text" class="form-control" id="C_P" placeholder="C P">
                    </div>
                    <div class="form-group">
                        <label for="Nombres_y_Apellidos">Nombres y Apellidos</label>
                        <input wire:model="Nombres_y_Apellidos" type="text" class="form-control"
                            id="Nombres_y_Apellidos" placeholder="Nombres y Apellidos">
                        @auth
                            @if (Auth::user()->Tipo === 'Contador')
                                @error('Nombres_y_Apellidos')
                                    <span class="error text-danger">{{ $message }}</span>
                                @else
                                    <small class="form-text text-info">Campo obligatorio, Datos de la persona que realizo el
                                        movimeinto economico.</small>
                                @enderror
                            @endif
                        @endauth
                    </div>
                    <div class="form-group">
                        <label for="Detalle">Detalle</label>
                        <input wire:model="Detalle" type="text" class="form-control" id="Detalle"
                            placeholder="Detalle">
                        @error('Detalle')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Detalle del movimiento economico.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Entrada">Entrada</label>
                        <input wire:model="Entrada" type="number" class="form-control" id="Entrada"
                            placeholder="Entrada">
                        @error('Entrada')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Campo obligatorio si Salida esta vacio.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Salida">Salida</label>
                        <input wire:model="Salida" type="number" class="form-control" id="Salida"
                            placeholder="Salida">
                        @error('Salida')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Campo obligatorio si Entrada esta vacio.</small>
                        @enderror
                    </div>
                    @auth
                        @if (Auth::user()->Tipo != 'Contador')
                            <div class="form-group">
                                <label for="RUC_Instituto">Instituto</label>
                                <select wire:model="RUC_Instituto" class="form-control" id="RUC_Instituto"
                                    placeholder="Ruc Instituto">
                                    <option value="">Seleccionar Instituto</option>
                                    @foreach ($institutos as $instituto)
                                        <option value="{{ $instituto->RUC }}">{{ $instituto->Nombre }}</option>
                                    @endforeach
                                </select>
                                @error('RUC_Instituto')
                                    <span class="error text-danger">{{ $message }}</span>
                                @else
                                    <small class="form-text text-info">Campo obligatorio.</small>
                                @enderror
                            </div>
                        @endif
                    @endauth

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="store()" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div wire:ignore.self class="modal fade" id="updateDataModal" data-bs-backdrop="static" tabindex="-1"
    role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Actualizar Registro</h5>
                <button wire:click.prevent="cancel()" type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" wire:model="selected_id">
                    <div class="form-group">
                        <label for="Fecha">Fecha</label>
                        <input wire:model="Fecha" type="date" class="form-control" id="Fecha"
                            placeholder="Fecha">
                        @error('Fecha')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Campo obligatorio.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="N°_Voucher">N° Voucher</label>
                        <input wire:model="N°_Voucher" type="text" class="form-control" id="N°_Voucher"
                            placeholder="N° Voucher">
                        @auth
                            @if (Auth::user()->Tipo === 'Contador')
                                @error('N°_Voucher')
                                    <span class="error text-danger">{{ $message }}</span>
                                @else
                                    <small class="form-text text-info">Campo obligatorio si N° Cheque esta vacio.</small>
                                @enderror
                            @endif
                        @endauth
                    </div>
                    <div class="form-group">
                        <label for="N°_Cheque">N° Cheque</label>
                        <input wire:model="N°_Cheque" type="text" class="form-control" id="N°_Cheque"
                            placeholder="N° Cheque">
                        @auth
                            @if (Auth::user()->Tipo === 'Contador')
                                @error('N°_Cheque')
                                    <span class="error text-danger">{{ $message }}</span>
                                @else
                                    <small class="form-text text-info">Campo obligatorio si N° Voucher esta vacio.</small>
                                @enderror
                            @endif
                        @endauth
                    </div>
                    <div class="form-group">
                        <label for="C_P">C P</label>
                        <input wire:model="C_P" type="text" class="form-control" id="C_P"
                            placeholder="C P">

                    </div>
                    <div class="form-group">
                        <label for="Nombres_y_Apellidos">Nombres y Apellidos</label>
                        <input wire:model="Nombres_y_Apellidos" type="text" class="form-control"
                            id="Nombres_y_Apellidos" placeholder="Nombres y Apellidos">
                        @auth
                            @if (Auth::user()->Tipo === 'Contador')
                                @error('Nombres_y_Apellidos')
                                    <span class="error text-danger">{{ $message }}</span>
                                @else
                                    <small class="form-text text-info">Campo obligatorio, Datos de la persona que realizo el
                                        movimeinto economico.</small>
                                @enderror
                            @endif
                        @endauth
                    </div>
                    <div class="form-group">
                        <label for="Detalle">Detalle</label>
                        <input wire:model="Detalle" type="text" class="form-control" id="Detalle"
                            placeholder="Detalle">
                        @error('Detalle')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Detalle del movimiento economico.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Entrada">Entrada</label>
                        <input wire:model="Entrada" type="number" class="form-control" id="Entrada"
                            placeholder="Entrada">
                        @auth
                            @if (Auth::user()->Tipo === 'Contador')
                                @error('Entrada')
                                    <span class="error text-danger">{{ $message }}</span>
                                @else
                                    <small class="form-text text-info">Campo obligatorio si Salida esta vacio.</small>
                                @enderror
                            @endif
                        @endauth
                    </div>
                    <div class="form-group">
                        <label for="Salida">Salida</label>
                        <input wire:model="Salida" type="number" class="form-control" id="Salida"
                            placeholder="Salida">
                        @auth
                            @if (Auth::user()->Tipo === 'Contador')
                                @error('Salida')
                                    <span class="error text-danger">{{ $message }}</span>
                                @else
                                    <small class="form-text text-info">Campo obligatorio si Entrada esta vacio.</small>
                                @enderror
                            @endif
                        @endauth
                    </div>
                    @auth
                        @if (Auth::user()->Tipo != 'Contador')
                            <div class="form-group">
                                <label for="RUC_Instituto">Instituto</label>
                                <select wire:model="RUC_Instituto" class="form-control" id="RUC_Instituto"
                                    placeholder="Ruc Instituto">
                                    <option value="">Seleccionar Instituto</option>
                                    @foreach ($institutos as $instituto)
                                        <option value="{{ $instituto->RUC }}">{{ $instituto->Nombre }}</option>
                                    @endforeach
                                </select>
                                @error('RUC_Instituto')
                                    <span class="error text-danger">{{ $message }}</span>
                                @else
                                    <small class="form-text text-info">Campo obligatorio.</small>
                                @enderror
                            </div>
                        @endif
                        @if (Auth::user()->Tipo === 'Administrador')
                            <div class="form-group">
                                <label for="Activado">Activado</label>
                                <input wire:model="Activado" type="checkbox" class="form-check-input" id="Activado"
                                    placeholder="Activado">
                                @error('Activado')
                                    <span class="error text-danger">{{ $message }}</span>
                                @else
                                    <small class="form-text text-info">Activar y Descactivar Registro.</small>
                                @enderror
                            </div>
                        @endif
                    @endauth
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
