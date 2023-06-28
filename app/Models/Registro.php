<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'registros';

    protected $fillable = ['Fecha','N°_Voucher','N°_Cheque','C_P','DNI','Nombres_y_Apellidos','Detalle','Entrada','Salida','Saldo','RUC_Instituto','Activado'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function instituto()
    {
        return $this->hasOne('App\Models\Instituto', 'RUC', 'RUC_Instituto');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'DNI', 'DNI');
    }
    
}
