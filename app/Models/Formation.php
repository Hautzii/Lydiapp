<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static find($id)
 */
class formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date'
    ];

    public function interns()
{
    return $this->hasMany(Intern::class);
}
}
