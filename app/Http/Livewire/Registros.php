<?php

namespace App\Http\Livewire;

use Dompdf\Dompdf;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Registro;
use App\Models\User;
use App\Models\Instituto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Registros extends Component
{
	use WithPagination;

	protected $paginationTheme = 'bootstrap';
	public $selected_id, $keyWord, $Fecha, $N°_Voucher, $N°_Cheque, $C_P, $DNI, $Nombres_y_Apellidos, $Detalle, $Entrada, $Salida, $Saldo, $RUC_Instituto, $Activado, $mesSeleccionado, $anioSeleccionado, $logueado, $institutoSeleccionado;

	protected $messages = [
		'Fecha.required' => 'El campo Fecha es requerido.',
		'Nombres_y_Apellidos.required' => 'El campo Nombres y Apellidos es requerido.',
		'N°_Voucher.required_if' => 'El campo N° Voucher es requerido si N° Cheque esta vacio.',
		'N°_Cheque.required_if' => 'El campo N° Cheque es requerido si N° Voucher esta vacio.',
		'Entrada.required_if' => 'El campo Entrada es requerido si Salida esta vacio.',
		'Salida.required_if' => 'El campo Salida es requerido si Entrada esta vacio.',
		'RUC_Instituto' => 'El campo de Instituto es requerido',
	];

	public function render()
	{
		$usuarios = User::all();
		$institutos = Instituto::all();
		$mesSeleccionado = $this->mesSeleccionado;
		$anioSeleccionado = $this->anioSeleccionado;
		$institutoSeleccionado = $this->institutoSeleccionado;

		$logueado = Auth::user()->RUC_Instituto;
		$keyWord = '%' . $this->keyWord . '%';
		if (Auth::user()->Tipo === "Contador") {
			$registros = Registro::leftJoin('institutos', 'registros.RUC_Instituto', '=', 'institutos.RUC')
				->leftJoin('users', 'users.DNI', '=', 'registros.DNI')
				->selectRaw('registros.*, institutos.Nombre, DATE_FORMAT(registros.Fecha, "%d/%m/%Y") AS FechaFormateada')
				->when($mesSeleccionado || $anioSeleccionado || $logueado, function ($query) use ($logueado, $mesSeleccionado, $anioSeleccionado) {
					return $query->where(function ($query) use ($mesSeleccionado, $anioSeleccionado, $logueado) {
						if ($logueado) {
							$query->whereRaw('registros.RUC_Instituto LIKE ?', [$logueado]);
						}
						if ($mesSeleccionado) {
							$query->whereRaw('MONTH(Fecha) = ?', [str_pad($mesSeleccionado, 2, '0', STR_PAD_LEFT)]);
						}
						if ($anioSeleccionado) {
							$query->whereRaw('YEAR(Fecha) = ?', [$anioSeleccionado]);
						}
					});
				})
				->where(function ($query) use ($keyWord) {
					$query->Where('N°_Voucher', 'LIKE', $keyWord)
						->orWhere('N°_Cheque', 'LIKE', $keyWord)
						->orWhere('C_P', 'LIKE', $keyWord)
						->orWhere('registros.Nombres_y_Apellidos', 'LIKE', $keyWord)
						->orWhere('Detalle', 'LIKE', $keyWord)
						->orWhere('Entrada', 'LIKE', $keyWord)
						->orWhere('Salida', 'LIKE', $keyWord)
						->orWhere('Saldo', 'LIKE', $keyWord)
						->orWhere('registros.Activado', 'LIKE', $keyWord);
				})
				->whereRaw('users.Tipo != "Administrador"')
				->orderBy('Fecha', 'asc')
				->paginate(10);
		}
		if (Auth::user()->Tipo === "Controlador") {
			$registros = Registro::leftJoin('institutos', 'registros.RUC_Instituto', '=', 'institutos.RUC')
				->leftJoin('users', 'users.DNI', '=', 'registros.DNI')
				->selectRaw('registros.*, institutos.Nombre, DATE_FORMAT(registros.Fecha, "%d/%m/%Y") AS FechaFormateada')
				->when($mesSeleccionado || $anioSeleccionado || $institutoSeleccionado, function ($query) use ($mesSeleccionado, $anioSeleccionado, $institutoSeleccionado) {
					return $query->where(function ($query) use ($mesSeleccionado, $anioSeleccionado, $institutoSeleccionado) {
						if ($institutoSeleccionado) {
							$query->whereRaw('registros.RUC_Instituto LIKE ?', [$institutoSeleccionado]);
						}
						if ($mesSeleccionado) {
							$query->whereRaw('MONTH(Fecha) = ?', [str_pad($mesSeleccionado, 2, '0', STR_PAD_LEFT)]);
						}
						if ($anioSeleccionado) {
							$query->whereRaw('YEAR(Fecha) = ?', [$anioSeleccionado]);
						}
					});
				})
				->where(function ($query) use ($keyWord) {
					$query->where('N°_Voucher', 'LIKE', $keyWord)
						->orWhere('N°_Cheque', 'LIKE', $keyWord)
						->orWhere('C_P', 'LIKE', $keyWord)
						->orWhere('registros.Nombres_y_Apellidos', 'LIKE', $keyWord)
						->orWhere('Detalle', 'LIKE', $keyWord)
						->orWhere('Entrada', 'LIKE', $keyWord)
						->orWhere('Salida', 'LIKE', $keyWord)
						->orWhere('Saldo', 'LIKE', $keyWord)
						->orWhere('institutos.Nombre', 'LIKE', $keyWord)
						->orWhere('registros.Activado', 'LIKE', $keyWord);
				})
				->whereRaw('users.Tipo != "Administrador"')
				->orderBy('Fecha', 'asc')
				->paginate(10);
		}
		if (Auth::user()->Tipo === "Administrador") {
			$registros = Registro::leftJoin('institutos', 'registros.RUC_Instituto', '=', 'institutos.RUC')
				->selectRaw('registros.*, institutos.Nombre, DATE_FORMAT(registros.Fecha, "%d/%m/%Y") AS FechaFormateada')
				->when($mesSeleccionado || $anioSeleccionado || $institutoSeleccionado, function ($query) use ($mesSeleccionado, $anioSeleccionado, $institutoSeleccionado) {
					return $query->where(function ($query) use ($mesSeleccionado, $anioSeleccionado, $institutoSeleccionado) {
						if ($institutoSeleccionado) {
							$query->whereRaw('registros.RUC_Instituto LIKE ?', [$institutoSeleccionado]);
						}
						if ($mesSeleccionado) {
							$query->whereRaw('MONTH(Fecha) = ?', [str_pad($mesSeleccionado, 2, '0', STR_PAD_LEFT)]);
						}
						if ($anioSeleccionado) {
							$query->whereRaw('YEAR(Fecha) = ?', [$anioSeleccionado]);
						}
					});
				})
				->where(function ($query) use ($keyWord) {
					$query->where('N°_Voucher', 'LIKE', $keyWord)
						->orWhere('N°_Cheque', 'LIKE', $keyWord)
						->orWhere('C_P', 'LIKE', $keyWord)
						->orWhere('registros.Nombres_y_Apellidos', 'LIKE', $keyWord)
						->orWhere('Detalle', 'LIKE', $keyWord)
						->orWhere('Entrada', 'LIKE', $keyWord)
						->orWhere('Salida', 'LIKE', $keyWord)
						->orWhere('Saldo', 'LIKE', $keyWord)
						->orWhere('institutos.Nombre', 'LIKE', $keyWord)
						->orWhere('registros.Activado', 'LIKE', $keyWord);
				})
				->orderBy('Fecha', 'asc')
				->paginate(10);
		}
		// Formatear los campos de entrada, salida y saldo en formato de moneda peruana
		$registros->getCollection()->transform(function ($registro) {
			if ($registro->Entrada != 0) {
				$registro->Entrada = 'S/. ' . number_format($registro->Entrada, 2);
			}
			if ($registro->Salida != 0) {
				$registro->Salida = 'S/. ' . number_format($registro->Salida, 2);
			}
			if ($registro->Saldo != 0) {
				$registro->Saldo = 'S/. ' . number_format($registro->Saldo, 2);
			}
			return $registro;
		});
		return view('livewire.registros.view', [
			'registros' => $registros,
			'usuarios' => $usuarios,
			'institutos' => $institutos,
		]);
	}
	public function generarPDF($mesSeleccionado = null, $anioSeleccionado = null, $institutoSeleccionado = null, $keyWord = null)
	{
		if (Auth::user()->Tipo === "Contador") {
			$institutoSeleccionado = Auth::user()->RUC_Instituto;
		}
		if (Auth::user()->Tipo === "Contador") {
			if (empty($mesSeleccionado) || empty($anioSeleccionado)) {
				// Mostrar aviso de campos faltantes o redireccionar a una página de error
				return redirect()->back()->with('error', 'Debe elegir un mes y un año');
			}
		} else {
			if (empty($mesSeleccionado) || empty($anioSeleccionado) || empty($institutoSeleccionado)) {
				// Mostrar aviso de campos faltantes o redireccionar a una página de error
				return redirect()->back()->with('error', 'Debe elegir un mes, un año y un instituto');
			}
		}
		$usuarios = User::all();
		$institutos = Instituto::all();
		$logueado = Auth::user()->RUC_Instituto;
		$logueado_tipo = Auth::user()->Tipo;
		$keyWord = '%' . $keyWord . '%';

		if (Auth::user()->Tipo === "Contador") {
			$registros = Registro::leftJoin('institutos', 'registros.RUC_Instituto', '=', 'institutos.RUC')
				->leftJoin('users', 'users.DNI', '=', 'registros.DNI')
				->selectRaw('registros.*, institutos.Nombre, DATE_FORMAT(registros.Fecha, "%d/%m/%Y") AS FechaFormateada')
				->when($mesSeleccionado || $anioSeleccionado || $logueado, function ($query) use ($logueado, $mesSeleccionado, $anioSeleccionado) {
					return $query->where(function ($query) use ($mesSeleccionado, $anioSeleccionado, $logueado) {
						if ($logueado) {
							$query->whereRaw('registros.RUC_Instituto LIKE ?', [$logueado]);
						}
						if ($mesSeleccionado) {
							$query->whereRaw('MONTH(Fecha) = ?', [str_pad($mesSeleccionado, 2, '0', STR_PAD_LEFT)]);
						}
						if ($anioSeleccionado) {
							$query->whereRaw('YEAR(Fecha) = ?', [$anioSeleccionado]);
						}
					});
				})
				->where(function ($query) use ($keyWord) {
					$query->Where('N°_Voucher', 'LIKE', $keyWord)
						->orWhere('N°_Cheque', 'LIKE', $keyWord)
						->orWhere('C_P', 'LIKE', $keyWord)
						->orWhere('registros.Nombres_y_Apellidos', 'LIKE', $keyWord)
						->orWhere('Detalle', 'LIKE', $keyWord)
						->orWhere('Entrada', 'LIKE', $keyWord)
						->orWhere('Salida', 'LIKE', $keyWord)
						->orWhere('Saldo', 'LIKE', $keyWord)
						->orWhere('registros.Activado', 'LIKE', $keyWord);
				})
				->whereRaw('users.Tipo != "Administrador"')
				->orderBy('Fecha', 'asc')
				->paginate(10);
		}
		if (Auth::user()->Tipo === "Controlador") {
			$registros = Registro::leftJoin('institutos', 'registros.RUC_Instituto', '=', 'institutos.RUC')
				->leftJoin('users', 'users.DNI', '=', 'registros.DNI')
				->selectRaw('registros.*, institutos.Nombre, DATE_FORMAT(registros.Fecha, "%d/%m/%Y") AS FechaFormateada')
				->when($mesSeleccionado || $anioSeleccionado || $institutoSeleccionado, function ($query) use ($mesSeleccionado, $anioSeleccionado, $institutoSeleccionado) {
					return $query->where(function ($query) use ($mesSeleccionado, $anioSeleccionado, $institutoSeleccionado) {
						if ($institutoSeleccionado) {
							$query->whereRaw('registros.RUC_Instituto LIKE ?', [$institutoSeleccionado]);
						}
						if ($mesSeleccionado) {
							$query->whereRaw('MONTH(Fecha) = ?', [str_pad($mesSeleccionado, 2, '0', STR_PAD_LEFT)]);
						}
						if ($anioSeleccionado) {
							$query->whereRaw('YEAR(Fecha) = ?', [$anioSeleccionado]);
						}
					});
				})
				->where(function ($query) use ($keyWord) {
					$query->where('N°_Voucher', 'LIKE', $keyWord)
						->orWhere('N°_Cheque', 'LIKE', $keyWord)
						->orWhere('C_P', 'LIKE', $keyWord)
						->orWhere('registros.Nombres_y_Apellidos', 'LIKE', $keyWord)
						->orWhere('Detalle', 'LIKE', $keyWord)
						->orWhere('Entrada', 'LIKE', $keyWord)
						->orWhere('Salida', 'LIKE', $keyWord)
						->orWhere('Saldo', 'LIKE', $keyWord)
						->orWhere('institutos.Nombre', 'LIKE', $keyWord)
						->orWhere('registros.Activado', 'LIKE', $keyWord);
				})
				->whereRaw('users.Tipo != "Administrador"')
				->orderBy('Fecha', 'asc')
				->paginate(10);
		}
		if (Auth::user()->Tipo === "Administrador") {
			$registros = Registro::leftJoin('institutos', 'registros.RUC_Instituto', '=', 'institutos.RUC')
				->selectRaw('registros.*, institutos.Nombre, DATE_FORMAT(registros.Fecha, "%d/%m/%Y") AS FechaFormateada')
				->when($mesSeleccionado || $anioSeleccionado || $institutoSeleccionado, function ($query) use ($mesSeleccionado, $anioSeleccionado, $institutoSeleccionado) {
					return $query->where(function ($query) use ($mesSeleccionado, $anioSeleccionado, $institutoSeleccionado) {
						if ($institutoSeleccionado) {
							$query->whereRaw('registros.RUC_Instituto LIKE ?', [$institutoSeleccionado]);
						}
						if ($mesSeleccionado) {
							$query->whereRaw('MONTH(Fecha) = ?', [str_pad($mesSeleccionado, 2, '0', STR_PAD_LEFT)]);
						}
						if ($anioSeleccionado) {
							$query->whereRaw('YEAR(Fecha) = ?', [$anioSeleccionado]);
						}
					});
				})
				->where(function ($query) use ($keyWord) {
					$query->where('N°_Voucher', 'LIKE', $keyWord)
						->orWhere('N°_Cheque', 'LIKE', $keyWord)
						->orWhere('C_P', 'LIKE', $keyWord)
						->orWhere('registros.Nombres_y_Apellidos', 'LIKE', $keyWord)
						->orWhere('Detalle', 'LIKE', $keyWord)
						->orWhere('Entrada', 'LIKE', $keyWord)
						->orWhere('Salida', 'LIKE', $keyWord)
						->orWhere('Saldo', 'LIKE', $keyWord)
						->orWhere('institutos.Nombre', 'LIKE', $keyWord)
						->orWhere('registros.Activado', 'LIKE', $keyWord);
				})
				->orderBy('Fecha', 'asc')
				->paginate(10);
		}
		// Formatear los campos de entrada, salida y saldo en formato de moneda peruana
		$registros->getCollection()->transform(function ($registro) {
			if ($registro->Entrada != 0) {
				$registro->Entrada = 'S/. ' . number_format($registro->Entrada, 2);
			}
			if ($registro->Salida != 0) {
				$registro->Salida = 'S/. ' . number_format($registro->Salida, 2);
			}
			if ($registro->Saldo != 0) {
				$registro->Saldo = 'S/. ' . number_format($registro->Saldo, 2);
			}
			return $registro;
		});
		//Messeleeccioado mapeado para su nombr correspondiente
		$meses = [
			'01' => 'ENERO',
			'02' => 'FEBRERO',
			'03' => 'MARZO',
			'04' => 'ABRIL',
			'05' => 'MAYO',
			'06' => 'JUNIO',
			'07' => 'JULIO',
			'08' => 'AGOSTO',
			'09' => 'SEPTIEMBRE',
			'10' => 'OCTUBRE',
			'11' => 'NOVIEMBRE',
			'12' => 'DICIEMBRE',
		];
		if (isset($meses[$mesSeleccionado])) {
			$mesSeleccionado = $meses[$mesSeleccionado];
		} else {
			$mesSeleccionado = 'Mes inválido';
		}
		//Nombre del institutosleeccionado
		$instituto = Instituto::where('RUC', $institutoSeleccionado)->first();
		if ($instituto) {
			$institutoSeleccionado = $instituto->Nombre;
		}
		//cuenta bancaria del instituto sleccioando
		if ($instituto) {
			$institutoCuentaCorriente = $instituto->Cuenta_Corriente;
		}
		//saldo anterior
		$primerRegistro = $registros->first();

		if ($primerRegistro) {
			$registroAnterior = Registro::where('Fecha', '<=', $primerRegistro->Fecha)
				->where('id', '<', $primerRegistro->id)
				->orderBy('Fecha', 'desc')
				->first();
			if ($registroAnterior) {
				// El registro anterior está disponible
				$saldoAnterior = $registroAnterior->Saldo;
			} else {
				// No se encontró ningún registro anterior al primer registro
				// Realiza la lógica adecuada en este caso
				$saldoAnterior = 0;
			}
		} else {
			// No se encontró el primer registro para el mes y año especificados
			// Realiza la lógica adecuada en este caso
			$saldoAnterior = 0;
		}
		// Crear una instancia de Dompdf
		$dompdf = new Dompdf();

		// Generar el contenido HTML del PDF
		$html = view('livewire.registros.pdf', compact('registros', 'institutoSeleccionado', 'mesSeleccionado', 'anioSeleccionado', 'institutoCuentaCorriente', 'saldoAnterior'))->render();

		// Cargar el contenido HTML en Dompdf
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->set_option('isRemoteEnabled', true);
		// Renderizar el PDF
		$dompdf->render();

		// Establecer el nombre del archivo PDF
		$filename = 'registros.pdf';

		// Descargar el PDF generado
		$dompdf->stream($filename, ['Attachment' => false]);;
	}

	public function cancel()
	{
		$this->resetInput();
		$this->resetValidation();
	}

	private function resetInput()
	{
		$this->Fecha = null;
		$this->N°_Voucher = null;
		$this->N°_Cheque = null;
		$this->C_P = null;
		$this->DNI = null;
		$this->Nombres_y_Apellidos = null;
		$this->Detalle = null;
		$this->Entrada = null;
		$this->Salida = null;
		$this->Saldo = null;
		$this->RUC_Instituto = null;
		$this->Activado = null;
	}

	public function store()
	{
		if (Auth::user()->Tipo === 'Contador') {
			$this->validate([
				'Fecha' => 'required',
				'Nombres_y_Apellidos' => 'required',
				'N°_Voucher' => 'required_if:N°_Cheque,null',
				'N°_Cheque' => 'required_if:N°_Voucher,null',
				'Entrada' => 'required_if:Salida,null',
				'Salida' => 'required_if:Entrada,null',
			]);
		}
		if (Auth::user()->Tipo === 'Administrador') {
			$this->validate([
				'Fecha' => 'required',
				'RUC_Instituto' => 'required',
			]);
		}

		if ($this->RUC_Instituto === '') {
			$this->RUC_Instituto = null;
		};
		if (Auth::user()->Tipo === "Contador") {
			$this->RUC_Instituto = Auth::user()->RUC_Instituto;
		}
		$registroAnterior = Registro::where('RUC_Instituto', $this->RUC_Instituto)
			->where('Fecha', '<=', $this->Fecha)
			->orderByDesc('id')
			->first();

		if (!$registroAnterior) {
			$saldoAnterior = 0;
		} else {
			$saldoAnterior = $registroAnterior->Saldo;
		}
		$Saldo = $saldoAnterior + doubleval($this->Entrada) - doubleval($this->Salida);
		if (Auth::user()->Tipo == "Contador") {
			Registro::create([
				'Fecha' => $this->Fecha,
				'N°_Voucher' => $this->N°_Voucher,
				'N°_Cheque' => $this->N°_Cheque,
				'C_P' => $this->C_P,
				'DNI' => Auth::user()->DNI,
				'Nombres_y_Apellidos' => $this->Nombres_y_Apellidos,
				'Detalle' => $this->Detalle,
				'Entrada' => $this->Entrada,
				'Salida' => $this->Salida,
				'Saldo' => $Saldo,
				'RUC_Instituto' => $this->RUC_Instituto,
				'Activado' => true,
			]);
		} else {
			Registro::create([
				'Fecha' => $this->Fecha,
				'N°_Voucher' => $this->N°_Voucher,
				'N°_Cheque' => $this->N°_Cheque,
				'C_P' => $this->C_P,
				'DNI' => $this->DNI,
				'Nombres_y_Apellidos' => $this->Nombres_y_Apellidos,
				'Detalle' => $this->Detalle,
				'Entrada' => $this->Entrada,
				'Salida' => $this->Salida,
				'Saldo' => $Saldo,
				'RUC_Instituto' => $this->RUC_Instituto,
				'Activado' => true,
			]);
		}

		$this->resetInput();
		$this->dispatchBrowserEvent('closeModal');
		session()->flash('message', 'Registro Successfully created.');
	}

	public function edit($id)
	{
		$record = Registro::findOrFail($id);
		$this->selected_id = $id;
		$this->Fecha = $record->Fecha;
		$this->N°_Voucher = $record->N°_Voucher;
		$this->N°_Cheque = $record->N°_Cheque;
		$this->C_P = $record->C_P;
		$this->Nombres_y_Apellidos = $record->Nombres_y_Apellidos;
		$this->Detalle = $record->Detalle;
		$this->Entrada = $record->Entrada;
		$this->Salida = $record->Salida;
		$this->Saldo = $record->Saldo;
		if (Auth::user()->Tipo === 'Administrador') {
			$this->Activado = $record->Activado;
		}
		$this->RUC_Instituto = $record->RUC_Instituto;
		$this->resetValidation();
	}

	public function update()
	{
		if (Auth::user()->Tipo === 'Contador') {
			$this->validate([
				'Fecha' => 'required',
				'Nombres_y_Apellidos' => 'required',
				'N°_Voucher' => 'required_if:N°_Cheque,null',
				'N°_Cheque' => 'required_if:N°_Voucher,null',
				'Entrada' => 'required_if:Salida,null',
				'Salida' => 'required_if:Entrada,null',
			]);
		}
		if (Auth::user()->Tipo === 'Administrador') {
			$this->validate([
				'Fecha' => 'required',
				'RUC_Instituto' => 'required',
			]);
		}
		if ($this->Entrada === '' || $this->Entrada === 0) {
			$this->Entrada = null;
		};
		if ($this->Salida === ''  || $this->Salida === 0) {
			$this->Salida = null;
		};
		$registroAnterior = Registro::where('RUC_Instituto', $this->RUC_Instituto)
			->where(function ($query) {
				$query->where('Fecha', '<', $this->Fecha)
					->orWhere(function ($query) {
						$query->where('Fecha', $this->Fecha)
							->where('id', '<', $this->selected_id);
					});
			})
			->orderByDesc('Fecha')
			->orderByDesc('id')
			->first();

		if (!$registroAnterior) {
			$saldoAnterior = 0;
		} else {
			$saldoAnterior = $registroAnterior->Saldo;
		}
		$Saldo = $saldoAnterior + doubleval($this->Entrada) - doubleval($this->Salida);


		if ($this->selected_id) {
			$record = Registro::find($this->selected_id);
			if (Auth::user()->Tipo === 'Administrador') {
				$record->update([
					'Fecha' => $this->Fecha,
					'N°_Voucher' => $this->N°_Voucher,
					'N°_Cheque' => $this->N°_Cheque,
					'C_P' => $this->C_P,
					'Nombres_y_Apellidos' => $this->Nombres_y_Apellidos,
					'Detalle' => $this->Detalle,
					'Entrada' => $this->Entrada,
					'Salida' => $this->Salida,
					'Saldo' => $Saldo,
					'RUC_Instituto' => $this->RUC_Instituto,
					'Activado' => $this->Activado
				]);
			} else {
				$record->update([
					'Fecha' => $this->Fecha,
					'N°_Voucher' => $this->N°_Voucher,
					'N°_Cheque' => $this->N°_Cheque,
					'C_P' => $this->C_P,
					'Nombres_y_Apellidos' => $this->Nombres_y_Apellidos,
					'Detalle' => $this->Detalle,
					'Entrada' => $this->Entrada,
					'Salida' => $this->Salida,
					'Saldo' => $Saldo,
					'RUC_Instituto' => $this->RUC_Instituto,
				]);
			};
			$this->updateSaldosPosteriores($record, $Saldo);

			$this->resetInput();
			$this->dispatchBrowserEvent('closeModal');
			session()->flash('message', 'Registro Successfully updated.');
		}
	}
	private function updateSaldosPosteriores($registro, $saldoAnterior)
	{
		$registrosPosteriores = Registro::where('RUC_Instituto', $registro->RUC_Instituto)
			->where(function ($query) use ($registro) {
				$query->where('Fecha', '>', $registro->Fecha)
					->orWhere(function ($query) use ($registro) {
						$query->where('Fecha', $registro->Fecha)
							->where('id', '>', $registro->id);
					});
			})
			->orderBy('Fecha')
			->orderBy('id')
			->get();

		foreach ($registrosPosteriores as $registroPosterior) {
			$saldo = $saldoAnterior + doubleval($registroPosterior->Entrada) - doubleval($registroPosterior->Salida);

			$registroPosterior->update([
				'Saldo' => $saldo,
			]);

			$saldoAnterior = $saldo;

			// Llamada recursiva para procesar los siguientes registros
			$this->updateSaldosPosteriores($registroPosterior, $saldoAnterior);
		}
	}

	public function destroy($id)
	{
		if ($id) {
			//buscamos el registro respectivo
			$Registro = Registro::where('id', $id)
				->first();
			//si el registro exite
			if ($Registro) {
				//sacamos el registro anterior
				$registroAnterior = Registro::where('Fecha', '<=', $Registro->Fecha)
					->where('id', '<', $Registro->id)
					->orderBy('Fecha', 'desc')
					->first();
				//borramos el registro seleccionado
				Registro::where('id', $id)->delete();
				//sie l registro anteriro eciste
				if ($registroAnterior) {
					// El registro anterior está disponible
					$saldoAnterior = $registroAnterior->Saldo;
					//usamos el proceso de actualizacion de losm registro posteriores al anterior del borrado
					$this->updateSaldosPosteriores($registroAnterior, $saldoAnterior);
				}
			}
		}
	}
}
