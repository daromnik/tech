<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ["name", "project_id"];

    /**
     * Метод получает все запросы, которые принадлеат группе
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function queries()
    {
        return $this->hasMany("App\Models\Query");
    }
}
