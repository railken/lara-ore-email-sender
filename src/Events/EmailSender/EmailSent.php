<?php

namespace Railken\Amethyst\Events\EmailSender;

use Illuminate\Queue\SerializesModels;
use Railken\Amethyst\Models\EmailSender;
use Railken\Lem\Contracts\AgentContract;

class EmailSent
{
    use SerializesModels;

    public $email;
    public $agent;

    /**
     * Create a new event instance.
     *
     * @param \Railken\Amethyst\Models\EmailSender $email
     * @param \Railken\Lem\Contracts\AgentContract $agent
     */
    public function __construct(EmailSender $email, AgentContract $agent = null)
    {
        $this->email = $email;
        $this->agent = $agent;
    }
}