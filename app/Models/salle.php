<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\seance;
class salle extends Model
{
    use HasFactory;
    protected $fillable=[
        'nom_salle'
    ];
    public function seance():HasMany
    {
        $this->hasMany(seance::class);
    }
}
