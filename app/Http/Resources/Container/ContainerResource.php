<?php

namespace App\Http\Resources\Container;

use App\Enums\StreamShipLine;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ContainerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'thumbnail' => $this->getThumbnailPhoto(data_get($this, 'container_photos.0.thumbnail')),
            'customer_name' => data_get($this, 'customer.name'),
            'customer_user_id' => $this->customer_user_id,
            'customer_id' => data_get($this, 'customer.customer_id'),
            'booking_number' => $this->booking_number,
            'container_number' => $this->container_number,
            'loading_date' => Carbon::parse($this->loading_date)->format('Y-m-d'),
            'export_date' => $this->export_date,
            'eta_date' => $this->eta_date,
            'streamship_line' => $this->streamship_line,
            'terminal' => $this->terminal,
            'vessel' => $this->vessel,
            'destination' => $this->destination,
            'container_tracking_url' => $this->trackingUrl($this->streamship_line, $this->container_number),
            'status_name' => $this->status->getLabel(),
        ];
    }

    private function getThumbnailPhoto($photo): Application|string|UrlGenerator
    {
        if (empty($photo)) {
            return url('images/car-default-photo.png');
        }

        return filter_var($photo, FILTER_VALIDATE_URL) === false ? Storage::url($photo) : $photo;
    }

    public function trackingUrl($streamShipLine, $containerNumber): string
    {
        $url = '';
        switch ($streamShipLine) {
            case StreamshipLine::MAERSK->value:
            case StreamshipLine::APM_TERMINALS->value:
                $url = 'https://www.maersk.com/tracking/'.$containerNumber;
                break;
            case StreamshipLine::HMM->value:
                $url = 'https://www.hmm21.com/cms/business/ebiz/trackTrace/trackTrace/index.jsp?type=1&number='.$containerNumber.'&is_quick=Y&quick_params=';
                break;
            case StreamshipLine::MSC->value:
                $url = 'http://www.shippingline.org/track/?container='.$containerNumber.'&type=container&line=msc';
                break;
            case StreamshipLine::HAPAG_LLOYD->value:
                $url = 'https://www.hapag-lloyd.com/en/online-business/track/track-by-container-solution.html?container='.$containerNumber;
                break;
            case StreamshipLine::YANG_MING->value:
                $url = 'https://www.yangming.com/e-service/track_trace/track_trace_cargo_tracking.aspx';
                break;
            case StreamshipLine::ONE->value:
                $url = 'https://ecomm.one-line.com/ecom/CUP_HOM_3301.do?redir=Y&ctrack-field='.$containerNumber.'&sessLocale=en&trakNoParam='.$containerNumber;
                break;
            case StreamshipLine::EVERGREEN->value:
                $url = 'https://ct.shipmentlink.com/servlet/TDB1_CargoTracking.do';
                break;
            case StreamshipLine::CMA_CGM->value:
                $url = 'https://www.cma-cgm.com/ebusiness/tracking';
                break;
            case StreamshipLine::APL->value:
                $url = 'https://www.apl.com/ebusiness/tracking/search';
                break;
        }

        return $url;
    }
}
