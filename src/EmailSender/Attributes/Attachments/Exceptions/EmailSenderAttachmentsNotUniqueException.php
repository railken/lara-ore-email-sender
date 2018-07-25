<?php

namespace Railken\LaraOre\EmailSender\Attributes\Attachments\Exceptions;

use Railken\LaraOre\EmailSender\Exceptions\EmailSenderAttributeException;

class EmailSenderAttachmentsNotUniqueException extends EmailSenderAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'attachments';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'EMAILSENDER_ATTACHMENTS_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}