<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ProfileRequest;
use App\Services\UploadMediaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('frontend.pages.profile.index');

    }

    public function profileUpdate(ProfileRequest $request,UploadMediaService  $mediaService)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $user->update([
                'full_name' => $data['full_name'],
                'number' => $data['number'],
                'email' => $data['email'],
            ]);
            if (isset($data['password'])) {
                $user->fill([
                    'password' => Hash::make($data['password']),
                ])->save();
            }
            if ($request->hasFile('image'))
                $mediaService->upload('user', 'image', $user->id, '', false, $request);

            DB::commit();
            return $this->jsonSuccess(trans('backend.messages.success.profile'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('frontend')->error($e->getMessage());
            return $this->jsonError('', [
                'message_error' => $e->getMessage()
            ], 500);
        }

    }
}
