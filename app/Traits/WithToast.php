<?php

namespace App\Traits;

trait WithToast
{
    protected function success(string $message): void
    {
        $this->dispatch('notify', message: $message, style: 'success');
    }

    protected function error(string $message): void
    {
        $this->dispatch('notify', message: $message, style: 'error');
    }

    protected function info(string $message): void
    {
        $this->dispatch('notify', message: $message, style: 'info');
    }
}
