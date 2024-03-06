<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\filiere;
use App\Models\seance;
class groupe extends Model
{
    use HasFactory;
    protected $fillable=[
        'nom_groupe',
        'Mode_de_formation',
        'Niveau',
        'filiere_id',
    ];
    public function filiere():BelongsTo
    {
        $this->belongsTo(filiere::class);
    }
    public function seance():HasMany
    {
        $this->hasMany(seance::class);
    }
}
