<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\filiere;
use App\Models\seance;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class groupe extends Model
{
    use HasFactory;
    protected $fillable=[
        'nom_groupe',
        'Mode_de_formation',
        'Niveau',
        'filiere_id',
    ];
    public function filiere()
     {
    return $this->belongsTo(Filiere::class);
     }
    public function seance():HasMany
    {
       return $this->hasMany(seance::class,'id_groupe');
    }
}
