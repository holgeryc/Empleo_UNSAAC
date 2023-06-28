<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Instituto;

class Institutos extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selected_id, $keyWord, $RUC, $Nombre, $Cuenta_Corriente;
    public $selected_instituto = null;

    //los mensajes de error segun el validate
    protected $messages = [
        'RUC.required' => 'El campo RUC es requerido.',
        'RUC.numeric' => 'El campo RUC debe ser un valor numérico.',
        'RUC.digits' => 'El campo RUC debe tener exactamente 11 dígitos.',
        'Nombre.required' => 'El campo de Nombres y Apellidos es requerido',
        'Cuenta_Corriente.required' => 'El campo de Cuenta Corriente es requerido',
        'Cuenta_Corriente.numeric' => 'El campo de Cuenta Corriente debe ser un valor numérico',
    ];
    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        $institutos = Instituto::latest()
            ->orWhere('RUC', 'LIKE', $keyWord)
            ->orWhere('Nombre', 'LIKE', $keyWord)
            ->orWhere('Cuenta_Corriente', 'LIKE', $keyWord)
            ->paginate(10);
        return view('livewire.institutos.view', [
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
        $this->RUC = null;
        $this->Nombre = null;
        $this->Cuenta_Corriente = null;
    }

    public function store()
    {
        $this->validate([
            'RUC' => 'required|numeric|digits:11',
            'Nombre' => 'required',
            'Cuenta_Corriente' => 'required|numeric',
        ]);

        Instituto::create([
            'RUC' => $this->RUC,
            'Nombre' => $this->Nombre,
            'Cuenta_Corriente' => $this->Cuenta_Corriente
        ]);

        $this->resetInput();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('message', 'Instituto Successfully created.');
    }

    public function edit($RUC)
    {
        $record = Instituto::findOrFail($RUC);
        $this->RUC = $RUC;
        $this->Nombre = $record->Nombre;
        $this->Cuenta_Corriente = $record->Cuenta_Corriente;
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate([
            'RUC' => 'required|numeric|digits:11',
            'Nombre' => 'required',
            'Cuenta_Corriente' => 'required|numeric',
        ]);

        if ($this->RUC) {
            $record = Instituto::find($this->RUC);
            $record->update([
                'Nombre' => $this->Nombre,
                'Cuenta_Corriente' => $this->Cuenta_Corriente
            ]);

            $this->resetInput();
            $this->dispatchBrowserEvent('closeModal');
            session()->flash('message', 'Instituto Successfully updated.');
        }
    }

    public function destroy($RUC)
    {
        if ($RUC) {
            Instituto::where('RUC', $RUC)->delete();
        }
    }
}
