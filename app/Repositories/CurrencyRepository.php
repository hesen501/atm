<?php
namespace App\Repositories;

use App\Models\Currency;

class CurrencyRepository
{
    public function all()
    {
        return Currency::query()->get();
    }

    public function find($id)
    {
        return Currency::query()->findOrFail($id);
    }

    public function create($data)
    {
        return Currency::query()->create($data);
    }

    public function update($id, $data)
    {
        $currency = Currency::query()->findOrFail($id);
        $currency->update($data);
        return $currency;
    }

    public function delete($id)
    {
        $currency = Currency::query()->findOrFail($id);
        return $currency->delete();
    }
}
