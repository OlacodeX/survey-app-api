<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyQuestionAnswer extends Model
{
    use HasFactory, HasUuids;
    
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
       'answer',
       'question_id',
   ];

   protected function createdAt(): Attribute
   {
       return Attribute::make(
           get: fn ($value) => Carbon::parse($value)->toFormattedDateString(),
       );
   }

   /**
    * Get the question that owns the SurveyQuestionAnswer
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function question(): BelongsTo
   {
       return $this->belongsTo(SurveyQuestion::class, 'question_id');
   }

}
