<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCivilian
 */
class Civilian extends Model
{
    use HasFactory;

    protected $fillable = [
        'NIK',
        'NKK',
        'name',
        'date_of_birth',
        'income',
        'phone_number',
        'gender',
        'education',
        'kinship',
        'address',
        'RT'
    ];
}
