<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\QuestionType;
use Cviebrock\EloquentSluggable\Sluggable;

class Survey extends Model
{
    use HasFactory, HasUuids, Sluggable;
    
    /**
    * The attributes that should be cast to native types.
    *
    * @var array
   */
   protected $casts = [
       'type' => QuestionType::class,
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
}
