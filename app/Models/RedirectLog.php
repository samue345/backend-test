<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedirectLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'ip_request',
        'user_agent',
        'header',
        'date_access',
    ];

    public $timestamps = false;  // Correção aqui

    public function Redirect(){
        return $this->belongsTo(Redirect::class);
    }

    public function queryParamsRequests(){
        return $this->hasMany(QueryParamsRequest::class, 'redirectlog_id', 'id');
    }
}
