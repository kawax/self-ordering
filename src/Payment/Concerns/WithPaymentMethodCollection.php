<?php

namespace Revolution\Ordering\Payment\Concerns;

use Illuminate\Support\Collection;

trait WithPaymentMethodCollection
{
    /**
     * @return Collection
     */
    public function keys(): Collection
    {
        return $this->methods()->keys();
    }

    /**
     * @param  string  $key
     *
     * @return string|null
     */
    public function name(string $key): ?string
    {
        return $this->methods()->get($key);
    }
}
