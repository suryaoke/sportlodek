<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectBlock extends Component
{
    /**
     * Nama input dan label untuk select
     */
    public $name;
    public $label;
    public $placeholder;
    public $value;
    public $options;

    /**
     * Membuat instance komponen
     */
    public function __construct(
        $name,
        $label = '',
        $placeholder = '',
        $value = '',
        $options = []
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->options = $options;
    }

    /**
     * Menampilkan tampilan komponen
     */
    public function render(): View|Closure|string
    {
        return view('components.select-block');
    }
}
