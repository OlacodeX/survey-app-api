<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use App\Enums\QuestionType;

class Survey extends Model
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
}
