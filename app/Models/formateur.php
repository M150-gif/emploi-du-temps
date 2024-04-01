<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\seance;
use App\Models\module;
use Illuminate\Database\Eloquent\Relations\HasMany;

class formateur extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'prenom',
        'id'
    ];
    public function seance():HasMany
    {
       return $this->hasMany(seance::class, 'id_formateur', 'id');
    }
    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class)
            ->withPivot('status') // Include the pivot column 'status'
            ->withTimestamps();   // Include the pivot timestamps (if needed)
    }
}
