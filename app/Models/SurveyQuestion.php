<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\QuestionType;

class SurveyQuestion extends Model
{
    use HasFactory, HasUuids;
    
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
       'question',
       'type',
       'survey_id',
   ];

   protected function createdAt(): Attribute
   {
       return Attribute::make(
           get: fn ($value) => Carbon::parse($value)->toFormattedDateString(),
       );
   }

   /**
    * Get the survey that owns the SurveyQuestion
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function survey(): BelongsTo
   {
       return $this->belongsTo(Survey::class);
   }

   /**
    * Get all of the answers for the SurveyQuestion
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function answers(): HasMany
   {
       return $this->hasMany(SurveyQuestionAnswer::class, 'question_id');
   }
}
