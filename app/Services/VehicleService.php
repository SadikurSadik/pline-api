<?php

namespace App\Services;

use App\Enums\VehicleDocumentType;
use App\Enums\VehiclePhotoType;
use App\Filters\FilterByAuctionName;
use App\Filters\FilterByCustomerUser;
use App\Filters\FilterById;
use App\Filters\FilterByLicenseNumber;
use App\Filters\FilterByLocation;
use App\Filters\FilterByLotNumber;
use App\Filters\FilterByPurchaseDate;
use App\Filters\FilterByServiceProvider;
use App\Filters\FilterByStatus;
use App\Filters\FilterByVehicleGlobalSearch;
use App\Filters\FilterByVinNumber;
use App\Filters\FilterByYearMakeModel;
use App\Models\Vehicle;
use App\Models\VehicleCondition;
use App\Models\VehicleDocument;
use App\Models\VehicleFeature;
use App\Models\VehiclePhoto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class VehicleService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Vehicle::query()->with(['customer', 'location', 'city', 'title_type', 'yard_photos']);

        return app(FilterPipelineService::class)->apply($query, [
            FilterByStatus::class,
            FilterByLocation::class,
            FilterById::class,
            FilterByVehicleGlobalSearch::class,
            FilterByCustomerUser::class,
            FilterByLicenseNumber::class,
            FilterByVinNumber::class,
            FilterByLotNumber::class,
            FilterByAuctionName::class,
            FilterByServiceProvider::class,
            FilterByYearMakeModel::class,
            FilterByPurchaseDate::class,
        ], $filters);
    }

    public function getById(int $id, $customerUserId = null)
    {
        return Vehicle::with([
            'customer',
            'location',
            'title_type',
            'yard_photos',
            'auction_photos',
            'pickup_photos',
            'arrived_photos',
            'vehicle_conditions',
            'vehicle_features',
            'documents',
            'invoices',
        ])->when($customerUserId, function ($q) use ($customerUserId) {
            $q->where('customer_user_id', $customerUserId);
        })->find($id);
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

        foreach (Arr::get($data, 'vehicle_conditions', []) as $key => $value) {
            VehicleCondition::updateOrCreate(
                ['vehicle_id' => $vehicle->id, 'condition_id' => $key],
                ['value' => $value]
            );
        }

        $featureIds = Arr::get($data, 'vehicle_features', []);
        VehicleFeature::where('vehicle_id', $vehicle->id)->delete();
        foreach ($featureIds as $featureId) {
            if ($featureId) {
                VehicleFeature::updateOrCreate(
                    ['vehicle_id' => $vehicle->id, 'feature_id' => $featureId],
                    ['value' => 1]
                );
            }
        }

        foreach (VehiclePhotoType::cases() as $vehiclePhotoType) {
            if (! empty($data['file_urls'][$vehiclePhotoType->getKeyName()])) {
                $this->saveVehiclePhoto(
                    $data['file_urls'][$vehiclePhotoType->getKeyName()],
                    $vehicle->id,
                    $vehiclePhotoType->value
                );
            }
        }

        foreach (VehicleDocumentType::cases() as $vehicleDocumentType) {
            if (! empty($data['file_urls'][$vehicleDocumentType->getKeyName()])) {
                $this->saveVehicleDocument(
                    $data['file_urls'][$vehicleDocumentType->getKeyName()],
                    $vehicle->id,
                    $vehicleDocumentType->value
                );
            }
        }

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

    public function getByVin(mixed $vin, null $customerUserId)
    {
        return Vehicle::with([
            'customer',
            'location',
            'title_type',
            'yard_photos',
            'auction_photos',
            'pickup_photos',
            'arrived_photos',
            'vehicle_conditions',
            'vehicle_features',
            'documents',
            'invoices',
        ])->when($customerUserId, function ($q) use ($customerUserId) {
            $q->where('customer_user_id', $customerUserId);
        })->where(function ($query) use ($vin) {
            $query->where('vin_number', $vin)
                ->orWhereHas('container', function ($query) use ($vin) {
                    $query->where('container_number', $vin);
                });
        })->firstOrFail();
    }
}
