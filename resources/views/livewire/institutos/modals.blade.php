<!-- Add Modal -->
<div wire:ignore.self class="modal fade" id="createDataModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="createDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDataModalLabel">Create New Instituto</h5>
                <button wire:click.prevent="cancel()" type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="RUC"></label>
                        <input wire:model="RUC" type="text" class="form-control" id="RUC" placeholder="Ruc">
                        @error('RUC')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Campo obligatorio, numerico y 11 digitos.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Nombre"></label>
                        <input wire:model="Nombre" type="text" class="form-control" id="Nombre"
                            placeholder="Nombre">
                        @error('Nombre')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Campo obligatorio, se recomienda el nombre completo del
                                Instituto.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Cuenta_Corriente"></label>
                        <input wire:model="Cuenta_Corriente" type="text" class="form-control" id="Cuenta_Corriente"
                            placeholder="Cuenta Corriente">
                        @error('Cuenta_Corriente')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Campo obligatorio y numerico.</small>
                        @enderror
                    </div>

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
<div wire:ignore.self class="modal fade" id="updateDataModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Instituto</h5>
                <button wire:click.prevent="cancel()" type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="RUC"></label>
                        <input wire:model="RUC" type="text" class="form-control" id="RUC" placeholder="Ruc"
                            readonly disabled>
                        @error('RUC')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Campo obligatorio, numerico y 11 digitos.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Nombre"></label>
                        <input wire:model="Nombre" type="text" class="form-control" id="Nombre"
                            placeholder="Nombre">
                        @error('Nombre')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Campo obligatorio, se recomienda el nombre completo del
                                Instituto.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Cuenta_Corriente"></label>
                        <input wire:model="Cuenta_Corriente" type="text" class="form-control" id="Cuenta_Corriente"
                            placeholder="Cuenta Corriente">
                        @error('Cuenta_Corriente')
                            <span class="error text-danger">{{ $message }}</span>
                        @else
                            <small class="form-text text-info">Campo obligatorio y numerico.</small>
                        @enderror
                    </div>

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
