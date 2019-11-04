<?php

namespace App\Jobs;

use App\Mail\StandardEmail;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use League\Flysystem\FileNotFoundException;

class SendEmailFromTemplate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $layoutDirectory = 'views/emails/';
    protected $contentMergeField = '[content]';

    protected $emailName;
    protected $mergeFields;
    protected $toEmailAddress;

    /**
     * Create a new job instance.
     *
     * @param string $emailName
     * @param array $mergeFields
     * @param string $toEmailAddress
     */
    public function __construct(string $emailName, array $mergeFields, string $toEmailAddress)
    {
        $this->emailName = $emailName;
        $this->mergeFields = $mergeFields;
        $this->toEmailAddress = $toEmailAddress;
    }

    public function handle()
    {
        try {
            $layout = File::get(resource_path($this->layoutDirectory . 'layout.html'));
        } catch (FileNotFoundException $exception) {
            Log::error($this->layoutDirectory . 'layout.html could not be found on the file system');
            return;

        }

        $email = EmailTemplate::where('name', $this->emailName)->first();

        if (!$email) {
            Log::error('Email: `' . $this->emailName . '´ was not found in database');
            return;
        }

        $content = str_replace(
            $this->contentMergeField,
            $email->mergeFields($this->mergeFields),
            $layout
        );

        Mail::to($this->toEmailAddress)
            ->send(new StandardEmail($email->subject, $email->getCCRecipients(), $content));
    }
}
