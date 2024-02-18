<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueryParamsRequest extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'redirectlog_id', 'key', 'value'];

    public $timestamps = false;  
    public function RedirectLog(){
        return $this->belongsTo(RedirectLog::class, 'redirectlog_id');
    }
}
