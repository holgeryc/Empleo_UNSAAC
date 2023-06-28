<?php 

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
	use HasFactory;
    use \Illuminate\Auth\Authenticatable;
	
    public $timestamps = true;

    protected $table = 'users';
    protected $primaryKey= 'DNI';

    protected $fillable = ['DNI','Nombres_y_Apellidos','email','Tipo','RUC_Instituto','Activado','password'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function instituto()
    {
        return $this->hasOne('App\Models\Instituto', 'RUC', 'RUC_Instituto');
    }
    
}
