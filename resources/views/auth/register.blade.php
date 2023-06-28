@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="DNI" class="col-md-4 col-form-label text-md-end">{{ __('DNI') }}</label>

                                <div class="col-md-6">
                                    <input id="DNI" type="text" class="form-control" name="DNI"
                                        autocomplete="new-DNI">
                                    @error('DNI')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @else
                                        <small class="form-text text-info">Campo obligatorio,numerico y 8 digitos.</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group">
                            <label for="DNI"></label>
                            <input wire:model="DNI" type="text" class="form-control" id="DNI" placeholder="Dni">@error('DNI') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div> --}}

                            {{-- <div class="form-group">
                            <label for="Nombres_y_Apellidos"></label>
                            <input wire:model="Nombres_y_Apellidos" type="text" class="form-control" id="Nombres_y_Apellidos" placeholder="Nombres Y Apellidos">@error('Nombres_y_Apellidos') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div> --}}

                            <div class="row mb-3">
                                <label for="Nombres_y_Apellidos"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nombres_y_Apellidos') }}</label>

                                <div class="col-md-6">
                                    <input id="Nombres_y_Apellidos" type="text" class="form-control"
                                        name="Nombres_y_Apellidos" autocomplete="new-Nombres_y_Apellidos">
                                    @error('Nombres_y_Apellidos')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @else
                                        <small class="form-text text-info">Campo obligatorio, se recomienda un nombre
                                            Real.</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- <div class="form-group">
                            <label for="email"></label>
                            <input wire:model="email" type="text" class="form-control" id="email" placeholder="Email">@error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div> --}}

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Correo Electronico') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="email"
                                        autocomplete="new-email">
                                    @error('email')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @else
                                        <small class="form-text text-info">Campo obligatorio y de formato correo.</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group">
                            <label for="Tipo"></label>
                            <input wire:model="Tipo" type="text" class="form-control" id="Tipo" placeholder="Tipo">@error('Tipo') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div> --}}
                            {{-- <div class="row mb-3">
                            <label for="Tipo" class="col-md-4 col-form-label text-md-end">{{ __('Tipo') }}</label>

                            <div class="col-md-6">
                                <input id="Tipo" type="text" class="form-control" name="Tipo" required autocomplete="new-Tipo">
                            </div>
                        </div> --}}

                            {{-- <div class="form-group">
                            <label for="RUC_Instituto"></label>
                            <input wire:model="RUC_Instituto" type="text" class="form-control" id="RUC_Instituto" placeholder="Ruc Instituto">@error('RUC_Instituto') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div> --}}

                            <div class="row mb-3">
                                <label for="RUC_Instituto"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Instituto') }}</label>
                                <div class="col-md-6">
                                    <select name="RUC_Instituto" class="form-control">
                                        <option value="">Seleccionar Instituto</option>
                                        @foreach ($institutos as $instituto)
                                            <option value="{{ $instituto->RUC }}">{{ $instituto->Nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('RUC_Instituto')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @else
                                        <small class="form-text text-info">Campo obligatorio si es de tipo Contador.</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group">
                            <label for="Activado"></label>
                            <input wire:model="Activado" type="checkbox"id="Activado" placeholder="Activado">@error('Activado') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>       --}}

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        autocomplete="new-password">
                                    @error('password')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @else
                                        <small class="form-text text-info">Campo obligatorio,minimo 8 caracteres.</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirmar Contraseña') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" autocomplete="new-password">
                                    @error('password-confirm')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @else
                                        <small class="form-text text-info">Campo obligatorio,minimo 8 caracteres.</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Registrar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
