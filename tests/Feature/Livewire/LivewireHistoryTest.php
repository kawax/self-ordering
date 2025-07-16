<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use Livewire\Livewire;
use Revolution\Ordering\Http\Livewire\Order\History;
use Tests\TestCase;

class LivewireHistoryTest extends TestCase
{
    public function test_history()
    {
        $this->withoutVite();

        $this->withSession([
            'history' => [
                [
                    'items' => [
                        'id' => 'test',
                    ],
                ],
            ],
        ]);

        $response = $this->get(route('history'));

        $response->assertStatus(200)
            ->assertSeeLivewire('ordering.history');
    }

    public function test_history_delete_history()
    {
        Livewire::test(History::class)
            ->call('deleteHistory')
            ->assertSessionMissing('history');
    }

    public function test_history_redirect()
    {
        $this->withSession([
            'table' => 'test',
        ]);

        Livewire::test(History::class)
            ->call('back')
            ->assertRedirect(route('order', ['table' => 'test']));
    }
}
