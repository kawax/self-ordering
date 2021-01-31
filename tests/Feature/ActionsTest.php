<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Event;
use Revolution\Ordering\Actions\AddCartAction;
use Revolution\Ordering\Actions\AddHistoryAction;
use Revolution\Ordering\Actions\OrderAction;
use Revolution\Ordering\Actions\ResetCartAction;
use Revolution\Ordering\Contracts\Actions\AddCart;
use Revolution\Ordering\Contracts\Actions\AddHistory;
use Revolution\Ordering\Contracts\Actions\Order;
use Revolution\Ordering\Contracts\Actions\ResetCart;
use Revolution\Ordering\Events\OrderEntry;
use Revolution\Ordering\Facades\Menu;
use Tests\TestCase;

class ActionsTest extends TestCase
{
    public function testAddCart()
    {
        $act = app(AddCart::class);

        $act->add(1);

        $this->assertInstanceOf(AddCartAction::class, $act);
    }

    public function testAddHistory()
    {
        $act = app(AddHistory::class);

        $act->add([]);

        $this->assertInstanceOf(AddHistoryAction::class, $act);
    }

    public function testResetCart()
    {
        $act = app(ResetCart::class);

        $act->reset();

        $this->assertInstanceOf(ResetCartAction::class, $act);
    }

    public function testOrder()
    {
        Event::fake();

        Menu::shouldReceive('get')->once();

        $act = app(Order::class);

        $act->order();

        $this->assertInstanceOf(OrderAction::class, $act);

        Event::assertDispatched(OrderEntry::class, 1);
    }
}
