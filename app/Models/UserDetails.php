<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'address', 'phone_number', 'avatar'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
