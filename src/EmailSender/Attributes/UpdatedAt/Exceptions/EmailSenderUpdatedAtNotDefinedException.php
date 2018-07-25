<?php

namespace Railken\LaraOre\EmailSender\Attributes\UpdatedAt\Exceptions;

use Railken\LaraOre\EmailSender\Exceptions\EmailSenderAttributeException;

class EmailSenderUpdatedAtNotDefinedException extends EmailSenderAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'updated_at';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'EMAILSENDER_UPDATED_AT_NOT_DEFINED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is required';
}