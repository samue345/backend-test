<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Redirect extends Model
{
    use HasFactory;
    protected $fillable = [
         'status',
         'url_destino',
        
     ];
     protected $appends = ['code'];
     public function getCodeAttribute()
     {
         return Hashids::encode($this->attributes['id']);
     }

     public function redirectLogs(){
        return $this->hasMany(RedirectLog::class);
    }
}
