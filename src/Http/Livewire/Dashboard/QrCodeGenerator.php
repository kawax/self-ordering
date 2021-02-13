<?php

namespace Revolution\Ordering\Http\Livewire\Dashboard;

use Livewire\Component;

class QrCodeGenerator extends Component
{
    /**
     * @var string
     */
    public string $table = '1';

    public function render()
    {
        return view('ordering::livewire.dashboard.qr-code-generator');
    }
}
