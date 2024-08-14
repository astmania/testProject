<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str; // Импортируем Str


class PetForm extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        // Автоматическая генерация UUID при создании новой записи
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
    protected $fillable = [
        'uuid',
        'photo',
        'chipset',
        'check_id',
        'pet_name',
        'pet_type',
        'pet_family_type',
        'pet_region',
        'pet_country',
        'pet_city',
        'pet_street',
        'iin',
        'reg_date',
        'gr',
        'mm',
        'old_year',
        'old_month',
        'comment',
        'other_comment',
    ];

    /**
     * Тип ключа UUID.
     */
    protected $keyType = 'string';
}
