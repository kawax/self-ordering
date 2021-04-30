<?php

declare(strict_types=1);

namespace Revolution\Ordering\Actions;

use Revolution\Ordering\Contracts\Actions\AddHistory;

class AddHistoryAction implements AddHistory
{
    /**
     * @inheritDoc
     */
    public function add(array $history): void
    {
        $histories = collect(session('history', []));

        $histories = $histories->prepend($history)
                               ->take(config('ordering.history.limit', 100));

        session(['history' => $histories->toArray()]);
    }
}
