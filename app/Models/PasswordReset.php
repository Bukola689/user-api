<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $guarded = [];

    const UPDATED_AT = null;
    /**
     * 
     *  The attribute that are mass assignable
     * 
     *  @Var array <int, string>
     * 
     */

     protected $fillable = [
        'email', 'token'
     ];
}
