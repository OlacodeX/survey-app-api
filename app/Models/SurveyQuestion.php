<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
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
}
