<?php

namespace Revolution\Ordering\Actions;

use Revolution\Ordering\Contracts\Actions\AddHistory;

class AddHistoryAction implements AddHistory
{
    /**
     * @inheritDoc
     */
    public function add(array $history)
    {
        $histories = collect(session('history', []));

        $histories = $histories->prepend($history)
                               ->take(config('ordering.history_limit', 10));

        session(['history' => $histories->toArray()]);
    }
}
