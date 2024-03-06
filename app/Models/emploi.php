<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\seance;

class emploi extends Model
{

    use HasFactory;
    protected $fillable=[
        'nom_emploi',
        'date_debut',
        'date_fin'
    ];
    public function seance():HasMany
    {
        $this->hasMany(seance::class);
    }
}
