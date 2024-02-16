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
    public function queryParamsRequests(){
        return $this->hasMany(QueryParamsRequest::class, 'redirect_id', 'id');
    }
}
