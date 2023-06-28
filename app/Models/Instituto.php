<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instituto extends Model
{
	use HasFactory;
	
    public $timestamps = true;

    protected $table = 'institutos';
    
    protected $primaryKey='RUC';

    protected $fillable = ['RUC','Nombre','Cuenta_Corriente'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registros()
    {
        return $this->hasMany('App\Models\Registro', 'RUC_Instituto', 'RUC');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\Models\User', 'RUC_Instituto', 'RUC');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarios()
    {
        return $this->hasMany('App\Models\Usuario', 'RUC_Instituto', 'RUC');
    }
    
}
