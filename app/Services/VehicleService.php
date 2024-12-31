<?php

namespace App\Services;

use App\Enums\VehicleDocumentType;
use App\Enums\VehiclePhotoType;
use App\Filters\FilterByAuctionName;
use App\Filters\FilterByCustomerUser;
use App\Filters\FilterById;
use App\Filters\FilterByLocation;
use App\Filters\FilterByLotNumber;
use App\Filters\FilterByPurchaseDate;
use App\Filters\FilterByServiceProvider;
use App\Filters\FilterByStatus;
use App\Filters\FilterByVehicleGlobalSearch;
use App\Filters\FilterByVinNumber;
use App\Filters\FilterByYearMakeModel;
use App\Models\Vehicle;
use App\Models\VehicleDocument;
use App\Models\VehiclePhoto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class VehicleService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Vehicle::query()->with(['vehicle_make', 'vehicle_model', 'customer', 'location']);

        return app(FilterPipelineService::class)->apply($query, [
            FilterByStatus::class,
            FilterByLocation::class,
            FilterById::class,
            FilterByVehicleGlobalSearch::class,
            FilterByCustomerUser::class,
            FilterByVinNumber::class,
            FilterByLotNumber::class,
            FilterByAuctionName::class,
            FilterByServiceProvider::class,
            FilterByYearMakeModel::class,
            FilterByPurchaseDate::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return Vehicle::with([
            'vehicle_make',
            'vehicle_model',
            'customer',
            'location',
            'title_type',
            'yard_photos',
            'auction_photos',
            'pickup_photos',
            'arrived_photos',
            'documents',
            'invoices',
        ])->find($id);
    }

    public function store(array $data)
    {
        return $this->save($data);
    }

    public function update(int $id, array $data)
    {

        // handle deleted photos
        foreach (VehiclePhotoType::cases() as $vehiclePhotoType) {
            if (isset($data['file_urls'][$vehiclePhotoType->getKeyName()])) {
                $this->removeVehiclePhotos(
                    $id,
                    $data['file_urls'][$vehiclePhotoType->getKeyName()],
                    $vehiclePhotoType->value
                );
            }
        }
        foreach (VehicleDocumentType::cases() as $vehiclePhotoType) {
            if (isset($data['file_urls'][$vehiclePhotoType->getKeyName()])) {
                $this->removeVehicleDocuments(
                    $id,
                    $data['file_urls'][$vehiclePhotoType->getKeyName()],
                    $vehiclePhotoType->value
                );
            }
        }

        return $this->save($data, $id);
    }

    private function save(array $data, ?int $id = null)
    {
        $vehicle = Vehicle::findOrNew($id);
        $vehicle->fill($data);
        $vehicle->save();

        return $vehicle;
    }

    public function destroy(int $id): void
    {
        $vehicle = Vehicle::findOrFail($id);

        $vehicle->delete();
    }

    public function getVehiclePhotos($vehicleId, ?int $type = null)
    {
        return VehiclePhoto::select([
            'id',
            'name',
            'thumbnail',
        ])->where('vehicle_id', $vehicleId)
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })->get();
    }

    public function getVehicleDocuments($vehicleId, ?int $type = null)
    {
        return VehicleDocument::select([
            'id',
            'name',
        ])->where('vehicle_id', $vehicleId)
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })->get();
    }

    public function saveVehiclePhoto($photos, $vehicleId, $type)
    {
        $newPhotos = [];
        foreach ($photos as $url) {
            $uri = filter_var($url, FILTER_VALIDATE_URL) ? getRelativeUrl($url) : '';

            if ($uri && Storage::exists($uri)) {
                $thumbnailFileName = str_replace(basename($uri), 'thumb-'.basename($uri), $uri);
                $thumbnail = Storage::exists($thumbnailFileName) ? $thumbnailFileName : $uri;
                $path = 'uploads/vehicles/photos/'.$vehicleId.'/';

                if ($uri !== $path.basename($uri) && Storage::exists($uri)) {
                    Storage::move($uri, $path.basename($uri));
                }

                if ($thumbnail !== $uri && $thumbnail !== $path.basename($thumbnail) && Storage::exists($thumbnail)) {
                    Storage::move($thumbnail, $path.basename($thumbnail));
                }

                VehiclePhoto::updateOrCreate([
                    'name' => $path.basename($uri),
                    'vehicle_id' => $vehicleId,
                    'type' => $type,
                ], ['thumbnail' => $path.basename($thumbnail)]);

                $newPhotos[] = $path.basename($uri);
            }
        }

        return $newPhotos;
    }

    private function saveVehicleDocument($documents, $vehicleId, $type): void
    {
        foreach ($documents as $url) {
            $uri = filter_var($url, FILTER_VALIDATE_URL) ? getRelativeUrl($url) : '';

            if ($uri && Storage::exists($uri)) {
                $path = 'uploads/vehicles/documents/'.$vehicleId.'/';

                if ($uri !== $path.basename($uri) && Storage::exists($uri)) {
                    Storage::move($uri, $path.basename($uri));
                }

                VehicleDocument::updateOrCreate([
                    'name' => $path.basename($uri),
                    'vehicle_id' => $vehicleId,
                    'type' => $type,
                ]);
            }
        }
    }

    private function removeVehiclePhotos($vehicleId, $photos, $type): void
    {
        $photos = array_map(function ($url) {
            return getRelativeUrl($url);
        }, $photos);

        $photoIds = VehiclePhoto::where([
            'vehicle_id' => $vehicleId,
            'type' => $type,
        ])->whereNotIn('name', $photos)
            ->pluck('id')
            ->toArray();

        VehiclePhoto::whereIn('id', $photoIds)->delete();
    }

    private function removeVehicleDocuments($vehicleId, $photos, $type): void
    {
        $photos = array_map(function ($url) {
            return getRelativeUrl($url);
        }, $photos);

        $photoIds = VehicleDocument::where([
            'vehicle_id' => $vehicleId,
            'type' => $type,
        ])->whereNotIn('name', $photos)
            ->pluck('id')
            ->toArray();

        VehicleDocument::whereIn('id', $photoIds)->delete();
    }
}
