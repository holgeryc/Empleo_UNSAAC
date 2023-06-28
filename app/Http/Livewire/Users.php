<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Instituto;


class Users extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $DNI, $Nombres_y_Apellidos, $email, $Tipo, $RUC_Instituto, $Activado, $password;
    public $NuevaContraseña = false;

    protected $messages = [
        'DNI.required' => 'El campo DNI es requerido.',
        'DNI.numeric' => 'El campo DNI debe ser un valor numérico.',
        'DNI.digits' => 'El campo DNI debe tener exactamente 8 dígitos.',
        'Nombres_y_Apellidos.required' => 'El campo de Nombres y Apellidos es requerido',
        'email.required' => 'El campo de correo es requerido',
        'email.email' => 'El campo debe ser de tipo correo',
        'Activado.required' => 'Es requerido que este Activado',
        'password.required' => 'El campo de contraseña es requerido',
        'password.min' => 'El campo de contraseña debe ser de minimo 8 caracteres',
        'Tipo.required' => 'El campo de Tipo es requerido',
    ];

    public function render()
    {
        $institutos = Instituto::all();
        $keyWord = '%' . $this->keyWord . '%';
        $usuarios = User::latest()
            ->leftjoin('institutos', 'users.RUC_Instituto', '=', 'institutos.RUC')
            ->select('users.*', 'institutos.Nombre')
            ->orWhere('DNI', 'LIKE', $keyWord)
            ->orWhere('Nombres_y_Apellidos', 'LIKE', $keyWord)
            ->orWhere('email', 'LIKE', $keyWord)
            ->orWhere('Tipo', 'LIKE', $keyWord)
            ->orWhere('institutos.Nombre', 'LIKE', $keyWord)
            ->orWhere('Activado', 'LIKE', $keyWord)
            ->paginate(10);
        return view('livewire.users.view', [
            'users' => $usuarios,
            'institutos' => $institutos,
        ]);
    }

    public function cancel()
    {
        $this->resetInput();
        $this->resetValidation();
    }

    private function resetInput()
    {
        $this->DNI = null;
        $this->Nombres_y_Apellidos = null;
        $this->email = null;
        $this->Tipo = null;
        $this->RUC_Instituto = null;
        $this->Activado = null;
        $this->password = null;
    }

    public function store()
    {
        $this->validate([
            'DNI' => 'required|numeric|digits:8',
            'Nombres_y_Apellidos' => 'required',
            'email' => 'required|email',
            'RUC_Instituto' => 'required_if:Tipo,Contador',
            'password' => 'required|min:8'
        ]);
        if ($this->Tipo === null) {
            $this->Tipo = 'Contador';
        }
        User::create([
            'DNI' => $this->DNI,
            'Nombres_y_Apellidos' => $this->Nombres_y_Apellidos,
            'email' => $this->email,
            'Tipo' => $this->Tipo,
            'RUC_Instituto' => $this->RUC_Instituto,
            'Activado' => true,
            'password' => Hash::make($this->password)
        ]);

        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('message', 'User Successfully created.');
    }

    public function edit($DNI)
    {
        $record = User::findOrFail($DNI);
        $this->DNI = $DNI;
        $this->Nombres_y_Apellidos = $record->Nombres_y_Apellidos;
        $this->email = $record->email;
        $this->Tipo = $record->Tipo;
        $this->RUC_Instituto = $record->RUC_Instituto;
        $this->Activado = $record->Activado;
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate([
            'DNI' => 'required|numeric|digits:8',
            'email' => 'required',
            'RUC_Instituto' => 'required_if:Tipo,Contador',
            'Tipo' => 'required',
            'Activado' => 'required',
            'password' => 'required_if:NuevaContraseña,true',
        ]);
        if ($this->RUC_Instituto === '') {
            $this->RUC_Instituto = null;
        };

        if ($this->DNI && $this->password) {
            $record = User::find($this->DNI);
            $record->update([
                'Nombres_y_Apellidos' => $this->Nombres_y_Apellidos,
                'email' => $this->email,
                'Tipo' => $this->Tipo,
                'RUC_Instituto' => $this->RUC_Instituto,
                'Activado' => $this->Activado,
                'password' => Hash::make($this->password)
            ]);

            $this->resetInput();
            $this->dispatchBrowserEvent('closeModal');
            session()->flash('message', 'User Successfully updated.');
        } else {
            if ($this->DNI) {
                $record = User::find($this->DNI);
                $record->update([
                    'Nombres_y_Apellidos' => $this->Nombres_y_Apellidos,
                    'email' => $this->email,
                    'Tipo' => $this->Tipo,
                    'RUC_Instituto' => $this->RUC_Instituto,
                    'Activado' => $this->Activado,
                ]);

                $this->resetInput();
                $this->dispatchBrowserEvent('closeModal');
                session()->flash('message', 'User Successfully updated.');
            }
        }
    }

    public function destroy($DNI)
    {
        if ($DNI) {
            User::where('DNI', $DNI)->delete();
        }
    }
}
