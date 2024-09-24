<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Priority extends Model
{
    use HasFactory;

    /**
     *  A priority belongs to many tasks.
     *
     * @codeCoverageIgnore Don't test relationships
     * @return BelongsToMany
     */
    public function task(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
}
