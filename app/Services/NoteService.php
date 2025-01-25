<?php

namespace App\Services;

use App\Models\AdminNote;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class NoteService
{
    public function all(array $filters = []): Collection
    {
        $query = Note::query();
        if (! empty($filters['vehicle_id'])) {
            $query->where('vehicle_id', $filters['vehicle_id']);
        }
        if (! empty($filters['container_id'])) {
            $query->where('container_id', $filters['container_id']);
        }

        return $query->limit(100)->get();
    }

    public function storeVccNote(array $data, int $id, $type = 'VCC_NOTE'): void
    {
        $data['vcc_id'] = $id;
        $data['created_by'] = Auth::id();
        $data['note_type'] = $type;

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

    public function containerStoreNote(array $data, int $id): void
    {
        $data['container_id'] = $id;
        $data['created_by'] = Auth::id();

        Note::create($data);
    }

    public function containerGetNote(int $id): Collection
    {
        return Note::with('user')
            ->where('container_id', $id)
            ->get();
    }

    public function vehicleStoreNote(array $data, int $id): void
    {
        $data['vehicle_id'] = $id;
        $data['created_by'] = Auth::id();

        Note::create($data);
    }

    public function vehicleGetNote(int $id): Collection
    {
        return Note::with('user')
            ->where('vehicle_id', $id)
            ->get();
    }

    public function store(array $data)
    {
        return $this->saveNote($data);
    }

    private function saveNote($data, $id = null)
    {
        $note = Note::findOrNew($id);
        $note->fill($data);
        $note->save();

        return $note;
    }
}
