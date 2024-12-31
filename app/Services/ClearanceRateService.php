<?php

namespace App\Services;

use App\Models\SystemSetting;
use Illuminate\Support\Collection;

class ClearanceRateService
{
    public function all(): Collection
    {
        return SystemSetting::query()->select('name', 'value')
            ->whereIn('name', ['clearance_rate', 'profit'])
            ->get()
            ->pluck('value', 'name');
    }

    public function update($name, $value): void
    {
        SystemSetting::query()->where('name', $name)->update(['value' => $value]);
    }
}
