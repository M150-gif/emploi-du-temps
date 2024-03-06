<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\formateur;
use App\Models\salle;
use App\Models\groupe;
use App\Models\emploi;

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
            $this->belongsTo(formateur::class);
        }
        public function salle():BelongsTo
        {
            $this->belongsTo(salle::class);
        }
        public function emploi():BelongsTo
        {
            $this->belongsTo(emploi::class);
        }
        public function groupe():BelongsTo
        {
            $this->belongsTo(groupe::class);
        }
}
