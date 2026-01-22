<?php

namespace App\Livewire\Admin\Quotes;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

final class CreateQuote extends Component
{
    #[Layout('layouts.sge')]
    public function render(): View
    {
        return view('livewire.quotes.form');
    }
}
