<?php

namespace Amethyst\Models;

use Amethyst\Core\ConfigurableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Railken\Lem\Contracts\EntityContract;

/**
 * @property DataBuilder $data_builder
 */
class EmailSender extends Model implements EntityContract
{
    use SoftDeletes;
    use ConfigurableModel;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->ini('amethyst.email-sender.data.email-sender');
        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function data_builder(): BelongsTo
    {
        return $this->belongsTo(config('amethyst.data-builder.data.data-builder.model'));
    }
}
