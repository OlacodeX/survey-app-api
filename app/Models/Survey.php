<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Traits\ValidateAnswers;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Survey extends Model
{
    use HasFactory, HasUuids, Sluggable, ValidateAnswers;
    
    /**
    * The attributes that should be cast to native types.
    *
    * @var array
   */
   protected $casts = [
       'created_at' => 'datetime',
       'updated_at' => 'datetime',
   ];

   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
       'title',
       'created_by',
       'expires_at',
       'slug',
   ];

   protected function createdAt(): Attribute
   {
       return Attribute::make(
           get: fn ($value) => Carbon::parse($value)->toFormattedDateString(),
       );
   }

   protected function expiresAt(): Attribute
   {
       return Attribute::make(
           get: fn ($value) => Carbon::parse($value)->toFormattedDateString(),
       );
   }

    /**
     * This function tells the sluggable package which column should be used fo generating the slug
     *
    */
    public function sluggable(): Array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Get the user that owns the Survey
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all of the questions for the Survey
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class);
    }
}
