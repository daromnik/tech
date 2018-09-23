<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $guarded  = ["_token"];

    /**
     * Метод получает все группы запросов для проекта
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany("App\Models\Group");
    }

    /**
     * Метод получает все запросы для проекта
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function queries()
    {
        return $this->hasManyThrough("App\Models\Query", "App\Models\Group");
    }

    /**
     * Заготовка для запроса активных проектов
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
