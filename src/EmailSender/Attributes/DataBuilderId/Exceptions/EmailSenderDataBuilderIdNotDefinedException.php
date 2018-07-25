<?php

namespace Railken\LaraOre\EmailSender\Attributes\DataBuilderId\Exceptions;

use Railken\LaraOre\EmailSender\Exceptions\EmailSenderAttributeException;

class EmailSenderDataBuilderIdNotDefinedException extends EmailSenderAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'data_builder_id';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'EMAILSENDER_DATA_BUILDER_ID_NOT_DEFINED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is required';
}
