<?php

namespace App\Models;
use App\Models\groupe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class filiere extends Model
{
    use HasFactory;
    protected $fillable=[
        'nom_filier',
        'niveau_formation',
        'mode_formation',
        'id'
    ];
    public function groupe():HasMany
    {
        $this->hasMany(groupe::class);
    }
}
