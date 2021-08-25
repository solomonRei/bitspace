<?php

namespace App\Services;

use App\Repositories\FileRepository;
use App\Models\File;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class FileService
{
    protected $fileRepository;
    protected $userRepository;

    public function __construct(FileRepository $fileRepository, UserRepository $userRepository)
    {
        $this->fileRepository = $fileRepository;
        $this->userRepository = $userRepository;
    }

    public function storeFiles($file, $folder, $type, $resize = [], $access = 'public')
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . Str::random(5) . '.' . $extension;

        if ($user = $this->userRepository->getAuthUser()) {

            if (count($resize) > 0) {
                $file = $this->imgResize($file, $resize);
                $path = storage_path("app/public/user_" . $user->id . "/" . $folder . "/". $filename);
                if (Storage::makeDirectory("public/user_" . $user->id . "/" . $folder))
                    $file->save($path);
                $path = "user_" . $user->id . "/" . $folder. "/". $filename;
            }else{
                $path = $file->storeAs("user_" . $user->id . "/" . $folder, $filename, $access);
            }

            $path = "storage/" . $path;

            $fileModel = new File;
            $fileModel->user_id = $user->id;
            $fileModel->filename = $filename;
            $fileModel->file_path = $path;
            $fileModel->type = $type;
            $fileModel->save();

            return $fileModel->id;
        }
        return false;
    }

    public function imgResize($image, $settings)
    {
        if (isset($settings['width']) && isset($settings['height'])) {
            $img = Image::make($image->path());
            $img->resize($settings['width'], $settings['height'], function ($const) {
                $const->aspectRatio();
            });
            return $img;
        }

        return null;
    }

    public function getFileById($id)
    {
        if ($file = $this->fileRepository->getById($id))
            return $file;
        else return false;
    }

    public function getFileByUserAndId($id)
    {
        if ($file = $this->fileRepository->getByUserAndId($id, $this->userRepository->getAuthUser()->id))
            return $file;
        else return false;
    }

    public function deleteFilesByType($type)
    {
        if ($user = $this->userRepository->getAuthUser()) {
            if ($files = $this->fileRepository->getByType($type, $user->id)) {
                $paths = [];
                foreach ($files as $file) {
                    $paths[] = $file->file_path;
                    $file->delete();
                }
                return true;
            }
        }
        return false;
    }

    protected function deleteFiles($paths)
    {
        return Storage::delete($paths);
    }

    public function createOrUpdateStrings($data, $lang_id, $file_id)
    {
        $file = $this->fileRepository->getById($file_id);

        $data['lang_id'] = $lang_id;
        $data['file_id'] = $file_id;

        if ($file->fileStrings()->updateOrCreate(['lang_id' => $lang_id], $data)) return true;
        else return false;
    }

    public function getByUser($auth, $type = 1, $user_id = 0)
    {
            $files = [];

            $user = $auth ? $this->userRepository->getAuthUser() : $this->userRepository->getUserObject($user_id);
            if ($user) {
                $files = $this->fileRepository->getByUserId($user->id, $type);
            }
       return $files;
    }


}
