<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NuzlockeGame extends Model
{
    protected $guarded = ['id'];

    /**
     * One NuzlockeGame belongs to One User.
     *
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A NuzlockeGame can have one status.
     *
     * @return BelongsTo
     */
    public function status():BelongsTo
    {
        return $this->belongsTo(NuzlockeStatus::class);
    }

    /**
     * A NuzlockeGame can have one set of NuzlockeRules.
     *
     * @return BelongsTo
     */
    public function rule(): BelongsTo
    {
        return $this->belongsTo(NuzlockeRule::class, 'nuzlocke_rules_id');
    }
}
