<?php

namespace App\View\Components;

use App\Support\CommandPalette;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CommandModal extends Component
{
    /**
     * @param  list<array{id: string, label: string, url: string, group: string, keywords: list<string>}>|null  $items
     */
    public function __construct(
        public ?array $items = null,
    ) {
        $this->items = $items ?? CommandPalette::items();
    }

    public function render(): View|Closure|string
    {
        return view('components.command-modal');
    }
}
