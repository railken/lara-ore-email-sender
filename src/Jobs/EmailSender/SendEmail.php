<?php

namespace Railken\Amethyst\Jobs\EmailSender;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Railken\Amethyst\Events\EmailSender\EmailFailed;
use Railken\Amethyst\Events\EmailSender\EmailSent;
use Railken\Amethyst\Managers\DataBuilderManager;
use Railken\Amethyst\Managers\EmailSenderManager;
use Railken\Amethyst\Models\EmailSender;
use Railken\Bag;
use Railken\Lem\Contracts\AgentContract;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $data;
    protected $agent;

    /**
     * Create a new job instance.
     *
     * @param EmailSender                          $email
     * @param array                                $data
     * @param \Railken\Lem\Contracts\AgentContract $agent
     */
    public function __construct(EmailSender $email, array $data = [], AgentContract $agent = null)
    {
        $this->email = $email;
        $this->data = $data;
        $this->agent = $agent;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $data = $this->data;
        $email = $this->email;

        $esm = new EmailSenderManager();
        $dbm = new DataBuilderManager();

        $result = $dbm->build($email->data_builder, $data);

        if (!$result->ok()) {
            return event(new EmailFailed($email, $result->getErrors()[0], $this->agent));
        }

        $data = $result->getResource();
        $result = $esm->render($email->data_builder, [
            'body'        => $email->body,
            'subject'     => $email->subject,
            'sender'      => $email->sender,
            'recipients'  => $email->recipients,
            'attachments' => $email->attachments,
        ], $data);

        if (!$result->ok()) {
            return event(new EmailFailed($email, $result->getErrors()[0], $this->agent));
        }

        $bag = new Bag($result->getResource());

        Mail::send([], [], function ($message) use ($bag) {
            $message->to($bag->get('recipients'))
                ->subject($bag->get('subject'))
                ->setBody($bag->get('body'), 'text/html');

            foreach ($bag->get('attachments') as $attachment) {
                if (!empty($attachment['source']) && !empty($attachment['as'])) {
                    $source = file_get_contents($attachment['source']);

                    $message->attach($attachment['source'], ['as' => $attachment['as']]);
                }
            }
        });

        event(new EmailSent($email, $this->agent));
    }
}