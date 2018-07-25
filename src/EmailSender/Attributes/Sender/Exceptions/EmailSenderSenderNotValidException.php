<?php

namespace Railken\LaraOre\EmailSender\Attributes\Sender\Exceptions;

use Railken\LaraOre\EmailSender\Exceptions\EmailSenderAttributeException;

class EmailSenderSenderNotValidException extends EmailSenderAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'sender';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'EMAILSENDER_SENDER_NOT_VALID';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not valid';
}