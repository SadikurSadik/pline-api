<?php

namespace App\Services;

use App\Models\AdminNote;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class NoteService
{
    public function storeVcc(array $data, int $id): void
    {
        $data['vcc_id'] = $id;
        $data['created_by'] = Auth::id();
        $data['note_type'] = 'VCC_NOTE';

        AdminNote::create($data);
    }

    public function storeSubmissionVcc(array $data, int $id): void
    {
        $data['vcc_id'] = $id;
        $data['created_by'] = Auth::id();
        $data['note_type'] = 'SUBMISSION_NOTE';

        AdminNote::create($data);
    }

    public function getVccNote(string $type, int $id): Collection
    {
        return AdminNote::with('user')
            ->where('note_type', $type)
            ->where('vcc_id', $id)
            ->get();
    }

    public function storeVehicleNote(array $data, int $id): void
    {
        $data['vehicle_id'] = $id;
        $data['created_by'] = Auth::id();

        AdminNote::create($data);
    }

    public function getVehicleNote(int $id): Collection
    {
        return AdminNote::with('user')
            ->where('vehicle_id', $id)
            ->get();
    }

    public function storeContainerNote(array $data, int $id): void
    {
        $data['container_id'] = $id;
        $data['created_by'] = Auth::id();

        AdminNote::create($data);
    }

    public function getContainerNote(int $id): Collection
    {
        return AdminNote::with('user')
            ->where('container_id', $id)
            ->get();
    }
}
