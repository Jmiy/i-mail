<?php

namespace Illuminate\Mail;

use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;
use Hyperf\View\RenderInterface;

class MailServiceProvider
{

    /**
     * The application instance.
     *
     * @var ContainerInterface
     */
    protected $app;

    /**
     * Create a new Cache manager instance.
     */
    public function __construct(ContainerInterface $app)
    {
        $this->app = $app;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerIlluminateMailer();
        $this->registerMarkdownRenderer();
    }

    /**
     * Register the Illuminate mailer instance.
     *
     * @return void
     */
    protected function registerIlluminateMailer()
    {
        $this->app->bind('mailer', function ($app) {
            return $app->get('mail.manager')->mailer();
        });
    }

    /**
     * Register the Markdown renderer instance.
     *
     * @return void
     */
    protected function registerMarkdownRenderer()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/resources/views' => $this->app->resourcePath('views/vendor/mail'),
            ], 'laravel-mail');
        }
    }
}
