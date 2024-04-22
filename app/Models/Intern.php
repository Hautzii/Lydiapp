<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static find($id)
 * @method static join(string $string, string $string1, string $string2, string $string3)
 * @property mixed|string $profile_picture
 * @property mixed $formation_id
 * @property mixed|string $last_name
 * @property mixed|string $first_name
 */
class Intern extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_picture',
        'first_name',
        'last_name',
        'phone_number',
        'email'
    ];

    public function formation(): BelongsTo
{
    return $this->belongsTo(Formation::class);
}

    public function favoritedByUsers()
{
    return $this->belongsToMany(User::class, 'favorites');
}
}
