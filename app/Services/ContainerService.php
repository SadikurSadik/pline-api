<?php

namespace App\Services;

use App\Enums\ContainerPhotoType;
use App\Enums\ContainerStatus;
use App\Enums\VehicleStatus;
use App\Filters\FilterByArrivalDate;
use App\Filters\FilterByBookingNumber;
use App\Filters\FilterByContainerGlobalSearch;
use App\Filters\FilterByContainerNumber;
use App\Filters\FilterByContainerPhoto;
use App\Filters\FilterByCustomerUser;
use App\Filters\FilterByEtaDate;
use App\Filters\FilterByExportDate;
use App\Filters\FilterById;
use App\Filters\FilterByLoadingDate;
use App\Filters\FilterByStatus;
use App\Filters\FilterByStreamShipLine;
use App\Filters\FilterByTerminal;
use App\Models\Container;
use App\Models\ContainerDocument;
use App\Models\ContainerPhoto;
use App\Models\Vehicle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class ContainerService
{
    public function all(array $filters = []): LengthAwarePaginator|Builder
    {
        $query = Container::query()->with([
            'customer',
            'port_of_loading',
            'port_of_discharge',
        ]);

        return app(FilterPipelineService::class)->apply($query, [
            FilterByContainerPhoto::class,
            FilterByCustomerUser::class,
            FilterByContainerNumber::class,
            FilterByContainerGlobalSearch::class,
            FilterByBookingNumber::class,
            FilterByStreamShipLine::class,
            FilterByTerminal::class,
            FilterByLoadingDate::class,
            FilterByExportDate::class,
            FilterByEtaDate::class,
            FilterByArrivalDate::class,
            FilterByStatus::class,
            FilterById::class,
        ], $filters);
    }

    public function getById(int $id)
    {
        return Container::with([
            'customer',
            'vehicles',
            'port_of_loading.state.country',
            'port_of_discharge.state.country',
            'vehicles.customer',
            'vehicles.location',
            'container_photos',
            'empty_container_photos',
            'loading_photos',
            'loaded_photos',
            'documents',
        ])->find($id);
    }

    public function store(array $data)
    {
        return $this->save(array_merge($data, ['status' => ContainerStatus::ON_THE_WAY->value]));
    }

    public function update(int $id, array $data)
    {
        foreach (ContainerPhotoType::cases() as $containerPhotoType) {
            if (isset($data['file_urls'][$containerPhotoType->getKeyName()])) {
                $this->removePhotos(
                    $id,
                    $data['file_urls'][$containerPhotoType->getKeyName()],
                    $containerPhotoType->value
                );
            }
        }
        Vehicle::where('container_id', $id)
            ->whereNotIn('id', $data['vehicle_ids'])
            ->update([
                'status' => VehicleStatus::ON_HAND->value,
                'container_id' => null,
            ]);

        return $this->save($data, $id);
    }

    private function save(array $data, ?int $id = null)
    {
        $container = Container::findOrNew($id);
        $container->fill($data);
        $container->save();

        Vehicle::query()->whereIn('id', $data['vehicle_ids'])->update(['container_id' => $container->id]);

        foreach (ContainerPhotoType::cases() as $photoType) {
            if (! empty($data['file_urls'][$photoType->getKeyName()])) {
                $this->savePhotos(
                    $data['file_urls'][$photoType->getKeyName()],
                    $container->id,
                    $photoType->value
                );
            }
        }

        return $container;
    }

    public function destroy(int $id): void
    {
        $container = Container::findOrFail($id);

        $container->delete();
    }

    public function getPhotos($containerId, ?int $type = null)
    {
        return ContainerPhoto::select([
            'id',
            'name',
            'thumbnail',
        ])->where('container_id', $containerId)
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })->get();
    }

    public function getDocuments($containerId, ?int $type = null)
    {
        return ContainerDocument::select([
            'id',
            'name',
        ])->where('container_id', $containerId)
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })->get();
    }

    public function savePhotos($photos, $containerId, $type): array
    {
        $newPhotos = [];
        foreach ($photos as $url) {
            $uri = filter_var($url, FILTER_VALIDATE_URL) ? getRelativeUrl($url) : '';

            if ($uri && Storage::exists($uri)) {
                $thumbnailFileName = str_replace(basename($uri), 'thumb-'.basename($uri), $uri);
                $thumbnail = Storage::exists($thumbnailFileName) ? $thumbnailFileName : $uri;
                $path = 'uploads/containers/photos/'.$containerId.'/';

                if ($uri !== $path.basename($uri) && Storage::exists($uri)) {
                    Storage::move($uri, $path.basename($uri));
                }

                if ($thumbnail !== $uri && $thumbnail !== $path.basename($thumbnail) && Storage::exists($thumbnail)) {
                    Storage::move($thumbnail, $path.basename($thumbnail));
                }

                ContainerPhoto::updateOrCreate([
                    'name' => $path.basename($uri),
                    'container_id' => $containerId,
                    'type' => $type,
                ], ['thumbnail' => $path.basename($thumbnail)]);

                $newPhotos[] = $path.basename($uri);
            }
        }

        return $newPhotos;
    }

    private function saveDocument($documents, $containerId): void
    {
        foreach ($documents as $url) {
            $uri = filter_var($url, FILTER_VALIDATE_URL) ? getRelativeUrl($url) : '';

            if ($uri && Storage::exists($uri)) {
                $path = 'uploads/containers/documents/'.$containerId.'/';

                if ($uri !== $path.basename($uri) && Storage::exists($uri)) {
                    Storage::move($uri, $path.basename($uri));
                }

                ContainerDocument::updateOrCreate([
                    'name' => $path.basename($uri),
                    'container_id' => $containerId,
                ]);
            }
        }
    }

    private function removePhotos($containerId, $photos, $type): void
    {
        $photos = array_map(function ($url) {
            return getRelativeUrl($url);
        }, $photos);

        $photoIds = ContainerPhoto::where([
            'container_id' => $containerId,
            'type' => $type,
        ])->whereNotIn('name', $photos)
            ->pluck('id')
            ->toArray();

        ContainerPhoto::whereIn('id', $photoIds)->delete();
    }
}
