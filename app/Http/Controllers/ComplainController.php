<?php

namespace App\Http\Controllers;

use App\Enums\readStatus;
use App\Enums\Role;
use App\Http\Requests\Complain\StoreComplainRequest;
use App\Http\Requests\Complain\StoreConversationRequest;
use App\Http\Requests\Complain\UpdateComplainRequest;
use App\Http\Resources\Complain\ComplainResource;
use App\Services\ComplainService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ComplainController extends Controller
{
    public function __construct(protected ComplainService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->all();
        if (auth()->user()->role_id == Role::CUSTOMER) {
            $filters['customer_user_id'] = auth()->user()->id;
        }
        $data = $this->service->all($filters);

        return ComplainResource::collection($data);
    }

    public function store(StoreComplainRequest $request): JsonResponse
    {
        try {
            $this->service->store(array_merge($request->validated(), ['customer_user_id' => auth()->user()->id]));

            return successResponse(__('Complain Created successfully!'));
        } catch (\Exception $e) {
            return errorResponse(__('Complain creation failed!'));
        }
    }

    public function show($id, Request $request): ComplainResource
    {
        $complain = $this->service->getById($id);
        if (optional(auth()->user())->role_id != Role::CUSTOMER && $complain && $complain->read_by_admin == ReadStatus::UNREAD) {
            $complain->update(['read_by_admin' => ReadStatus::READ]);
        }

        return (new ComplainResource($complain))->additional(['total_unread_complain' => $this->service->adminUnreadCount()]);
    }

    public function update($id, UpdateComplainRequest $request): JsonResponse
    {
        try {
            $this->service->update($id, $request->all());

            return successResponse(__('Complain Updated successfully!'));
        } catch (\Exception $e) {
            return errorResponse(__('Complain update failed!'));
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->destroy($id);

            return successResponse(__('Complain Deleted Successfully!'));
        } catch (\Exception $e) {
            return errorResponse(__('Complain deletion failed!'));
        }
    }

    public function storeConversation(StoreConversationRequest $request): JsonResponse
    {
        try {
            $this->service->storeConversation(array_merge($request->validated(), ['sender_id' => auth()->user()->id]));

            return successResponse(__('Conversation added Successfully!'));
        } catch (\Exception $e) {
            return errorResponse(__('Conversation addition failed!'));
        }
    }
}
