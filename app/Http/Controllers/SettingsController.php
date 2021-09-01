<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditContactsRequest;
use App\Http\Requests\EditSettingsRequest;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\PresentationUpdateRequest;
use App\Http\Requests\SummaryContactsRequest;
use App\Services\FileService;
use App\Services\ReviewService;
use App\Traits\MetaTags;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\SettingsService;
use App\Traits\Languages;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Array_;

class SettingsController extends Controller
{
    use MetaTags, Languages;

    protected $settingsService, $fileService, $reviewService;
    private $class = 'personal-info-page';

    public function __construct(SettingsService $settingsService, FileService $fileService, ReviewService $reviewService)
    {
        $this->settingsService = $settingsService;
        $this->fileService = $fileService;
        $this->reviewService = $reviewService;
    }


    public function index()
    {
//        $class = 'profile-page';

        $class = $this->class;
        $user = $this->settingsService->getUser();


        $this->setMeta(trans('custom.profile_settings'), 'Description');

        return view('frontend.profile.settings', compact('class', 'user'));
    }

    public function showContactForm()
    {
        $class = $this->class;
        $user = $this->settingsService->getUser();

        $this->setMeta(trans('custom.profile_settings'), 'Description');

        return view('frontend.profile.contacts', compact('class', 'user'));
    }

    public function showSummaryForm()
    {
        $class = $this->class;
        $user = $this->settingsService->getUser();

        $this->setMeta(trans('custom.profile_settings'), 'Description');

        return view('frontend.profile.summary', compact('class', 'user'));
    }

    public function showMediaForm()
    {
        $class = $this->class;
        $user = $this->settingsService->getUser();
        $files = $this->fileService->getByUser(true, 1);

        $this->setMeta(trans('custom.profile_settings'), 'Description');

        return view('frontend.profile.media', compact('class', 'user', 'files'));
    }

    public function showReviews()
    {
        $class = $this->class;
        $user = $this->settingsService->getUser();
        $reviews = $this->reviewService->getCommentsAll($user->id);
        return view('frontend.profile.reviews', compact('class', 'user', 'reviews'));
    }

    public function updateContactForm(EditContactsRequest $request)
    {

        $data = $this->insertData($request->validated());

        if (count($data) > 0) {
            foreach ($data as $lang_id => $fields) {
                if (!$this->settingsService->createOrUpdateSettings($fields, $this->getLangId($lang_id))) toastr()->error(__('custom.error'));
            }
        }
        toastr()->success(__('custom.success'));

        return back();
    }

    public function updateSummaryForm(SummaryContactsRequest $request)
    {

        $data = $this->insertData($request->validated());

        if (count($data) > 0) {
            foreach ($data as $lang_id => $fields) {
                if (!$this->settingsService->createOrUpdateSettings($fields, $this->getLangId($lang_id))) toastr()->error(__('custom.error'));
            }
        }
        toastr()->success(__('custom.success'));

        return back();
    }

    public function updateMediaForm(ImageRequest $request)
    {
        $data = $request->validated();
        foreach ($data['files'] as $file) {
            $this->fileService->storeFiles($file, 'files', 1);
        }
    }

    public function updatePresentationForm(PresentationUpdateRequest $request)
    {
        $data = $this->insertData($request->validated());

        if (count($data) > 0) {
            foreach ($data as $lang_id => $fields) {
                if (isset($fields['thumb'])) {
//                    $this->fileService->deleteFilesByType(2);
                    $file_id = $this->fileService->storeFiles($fields['thumb'], 'presentation', 2);
                    if (!$this->fileService->createOrUpdateStrings([
                        'thumb' => $fields['thumb']
                    ], $this->getLangId($lang_id), $file_id)) toastr()->error(__('custom.error'));

                    $mediafiles = $this->settingsService->formMediaFiles([
                        "url" => $fields['url'],
                        "file_id" => $file_id
                    ]);

                } else {
                    if ($user = $this->settingsService->getUser()) {
                        $data = $user->userStrings()
                            ->first()
                            ->getUsersString($this->getLangId($lang_id), $user->id);

                        $mediafiles = $this->settingsService->formMediaFiles([
                            "url" => $fields['url'],
                            "file_id" => $data->mediafiles_url['presentation']['file_id']
                        ]);

                    }
                }
                if (!$this->settingsService->createOrUpdateSettings($mediafiles, $this->getLangId($lang_id))) toastr()->error(__('custom.error'));
                else toastr()->success(__('custom.success'));
            }
        }

        return back();
    }

    public function update(EditSettingsRequest $request)
    {
        $validated_data = $request->validated();
        try {
            if (isset($validated_data['ava'])) {
                $file_id = $this->fileService->storeFiles($validated_data['ava'], 'ava', 3, ['width' => 240, 'height' => 240]);
                $validated_data['ava'] = $file_id;
            }

            if ($this->settingsService->updateSettings($validated_data)) toastr()->success(__('custom.success'));
            else toastr()->error(__('custom.error'));

        }catch (\Exception $e){
            toastr()->error($e->getMessage());
        }

        return back();
    }

    public function deleteMediaForm(Request $request)
    {
        if (isset($request->id)) {
            $id = (int) $request->id;
            if ($file = $this->fileService->getFileByUserAndId($id))
                if($file->delete())
                    return response()->json(['answer' => true]);
        }
        return response()->json(['answer' => false]);
    }

    public function deleteProfile()
    {
        if ($this->settingsService->deleteProfileTemporary())
        {
            toastr()->success('Ваш аккаунт удален');

            return back();
        }
    }

    public function include2FAQuery()
    {
        // Temporary
        toastr()->error(__('custom.error'));

        return back();

        $this->settingsService->include2FAQuery();
    }
}
