<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;


class RedirectLog extends Model
{
    use HasFactory;
    protected $fillable = [
       'ip_request',
        'user_agent',
        'header',
        'date_access',
    ];
    protected $appends = ['code'];
    public function getCodeAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }

    public function queryParamsRequests(){
        return $this->hasMany(QueryParamsRequest::class, 'redirect_id', 'id');
    }
}


