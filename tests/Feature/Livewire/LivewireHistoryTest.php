<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use Livewire\Livewire;
use Revolution\Ordering\Http\Livewire\Order\History;
use Tests\TestCase;

class LivewireHistoryTest extends TestCase
{
    public function testHistory()
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

    public function testHistoryDeleteHistory()
    {
        Livewire::test(History::class)
                ->call('deleteHistory');
    }

    public function testHistoryRedirect()
    {
        $this->withSession([
            'table' => 'test',
        ]);

        Livewire::test(History::class)
                ->call('back')
                ->assertRedirect(route('order', ['table' => 'test']));
    }
}
