<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Post;

class PostUpdatedAdminMessage extends Mailable
{
    use Queueable, SerializesModels;

    protected $post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('noreply@example.com')
            ->markdown('mail.markdown.adminMessagePostUpdate')
            ->with([
                'postTitle' => $this->post->title,
                'postSlug' => $this->post->slug,
                'postUrl' => env('APP_URL') . 'posts/' . $this->post->slug
            ]);
    }
}