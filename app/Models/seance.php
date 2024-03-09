<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\formateur;
use App\Models\salle;
use App\Models\groupe;
use App\Models\emploi;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class seance extends Model
{
    use HasFactory;
    protected $fillable=[
        'day',
        'partie_jour',
        'order_seance',
        'date_debut',
        'date_fin',
        'id_salle',
        'id_formateur',
        'id_groupe',
        'id_emploi',
        'type_seance'
];

public function formateur():BelongsTo
{
    return $this->belongsTo(formateur::class,"id_formateur");
}
        
        public function salle():BelongsTo
        {
           return $this->belongsTo(salle::class,"id_salle");
        }
        public function emploi():BelongsTo
        {
            $this->belongsTo(emploi::class,"id_emploi");
        }
        public function groupe():BelongsTo
        {
          return  $this->belongsTo(groupe::class,"id_groupe");
        }
}
