<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use App\Http\Requests\UsersRequest;
use App\Models\UsersStrings;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/users');
        CRUD::setEntityNameStrings(trans('custom.user'), trans('custom.users'));
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns

        CRUD::setColumns([
            'id',
            [
                'label' => trans('Avatar'),
                'name' => 'avatar.file_path',
                'type' => 'image'
            ],
            'name',
            'email',
            'balance'
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $id = $this->crud->getCurrentEntryId();

        $entry = $id ? $this->crud->getEntry($id) : null;

        CRUD::setValidation(UsersRequest::class);

        // CRUD::setFromDb(); // fields

        CRUD::addFields([
            'is_admin',
            'is_hided',
            'is_searched',
            'is_promoted',
            'banned',
            'name',
            'login',
        ]);

        CRUD::addField([
            'label' => 'New Password',
            'name' => 'new_password',
            'type' => 'password'
        ]);

        CRUD::addField([
            'label' => 'Avatar',
            'type' => 'image',
            'name' => 'avatar.file_path',
            'attribute' => 'file_path',
            'entity' => 'avatar',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        foreach ($this->crud->model->getLanguages() as $index => $language) {

            $languageCode = Str::upper($language->name);

            $relationId = $id && ($string = $entry->stringByLang($language->id))
                ? $string->id
                : null;

            CRUD::addField([
                'label' => trans('custom.first_name') . " ($languageCode)",
                'name' => "userStringsByLang[$index].name",
                'entity' => 'userStringsByLang',
                'type' => 'text',
                'value' => $entry && $entry->stringByLang($language->id)
                    ? $entry->stringByLang($language->id)->name
                    : '',
                'tab' => $languageCode
            ]);

            CRUD::addField([
                'label' => trans('custom.surname') . " ($languageCode)",
                'name' => "userStringsByLang[$index].surname",
                'entity' => 'userStringsByLang',
                'type' => 'text',
                'value' => $entry && $entry->stringByLang($language->id)
                    ? $entry->stringByLang($language->id)->surname
                    : '',
                'tab' => $languageCode
            ]);

            CRUD::addField([
                'label' => trans('custom.age') . " ($languageCode)",
                'name' => "userStringsByLang[$index].age",
                'entity' => 'userStringsByLang',
                'type' => 'text',
                'value' => $entry && $entry->stringByLang($language->id)
                    ? $entry->stringByLang($language->id)->age
                    : '',
                'tab' => $languageCode
            ]);

            CRUD::addField([
                'label' => trans('custom.education') . " ($languageCode)",
                'name' => "userStringsByLang[$index].education",
                'entity' => 'userStringsByLang',
                'type' => 'text',
                'value' => $entry && $entry->stringByLang($language->id)
                    ? $entry->stringByLang($language->id)->education
                    : '',
                'tab' => $languageCode
            ]);

            CRUD::addField([
                'label' => trans('custom.about') . " ($languageCode)",
                'name' => "userStringsByLang[$index].about",
                'entity' => 'userStringsByLang',
                'type' => 'ckeditor',
                'value' => $entry && $entry->stringByLang($language->id)
                    ? $entry->stringByLang($language->id)->about
                    : '',
                'tab' => $languageCode
            ]);

            CRUD::addField([
                'label' => trans('custom.experience') . " ($languageCode)",
                'name' => "userStringsByLang[$index].experience",
                'entity' => 'userStringsByLang',
                'type' => 'text',
                'value' => $entry && $entry->stringByLang($language->id)
                    ? $entry->stringByLang($language->id)->experience
                    : '',
                'tab' => $languageCode
            ]);

            if ($relationId) {
                CRUD::addField([
                    'type' => 'hidden',
                    'name' => "userStringsByLang[$index].id",
                    'entity' => 'userStringsByLang',
                    'attribute' => 'id',
                    'value' => $relationId,
                    'tab' => $languageCode
                ]);
            }

            CRUD::addField([
                'type' => 'hidden',
                'name' => "userStringsByLang[$index].lang_id",
                'entity' => 'userStringsByLang',
                'attribute' => 'lang_id',
                'value' => $language->id,
                'tab' => $languageCode
            ]);

            // if ($entry) {
            //     $string = $entry->stringByLang($language->id);

            //     if ($string) {
            //         CRUD::addField([
            //             'type' => 'hidden',
            //             'name' => "city_strings[$index].id",
            //             'entity' => 'cityStrings',
            //             'attribute' => 'id',
            //             'value' => $string->id,
            //             'tab' => $languageCode
            //         ]);
            //     }
            // }

        }

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        $userStrings = isset($request['userStringsByLang'])
            ? $request['userStringsByLang']
            : [];

        // $request

        // insert article in the db
        $user = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $user;

        foreach ($userStrings as $lang_id => $string) {
            $userString = new UsersStrings($string);

            $user->userStrings()->save($userString);
        }

        if (isset($this->crud->getStrippedSaveRequest()['avatar'])
            && $fileId = $this->storeBase64Avatar($this->crud->getStrippedSaveRequest()['avatar']['file_path'], 3, ['width' => 240, 'height' => 240])) {
            $user->update(['ava' => $fileId]);
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($user->getKey());
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        $userStrings = isset($request['userStringsByLang'])
            ? $request['userStringsByLang']
            : [];

        // dd($userStrings);

        // update the row in the db
        $user = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $user;

        dd($user);
        foreach ($userStrings as $index => $string) {
            dd($string);
            if (isset($string['id'])) {
                $userString = UsersStrings::where([
                    'id' => $string['id'],
                    'user_id' => $user->id
                ])->first();

                unset($string['id']);

                if ($userString) {
                    $userString->update($string);
                }
            } else {
                dd($user);
                $userString = new UsersStrings($string);
                $user->userStrings()->save($userString);
            }

        }

        if (isset($this->crud->getStrippedSaveRequest()['image'])) {
            if ($this->crud->getStrippedSaveRequest()['image']['file_path'] !== null) {
                $fileId = $this->storeBase64Avatar($this->crud->getStrippedSaveRequest()['image']['file_path'], 3, ['width' => 240, 'height' => 240]);

                $user->update(['ava' => $fileId]);
            } else if ($user->image) {
                $user->update(['ava' => null]);
                $user->avatar()->delete();
            }
        }

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($user->getKey());
    }

    protected function storeBase64Avatar($value, int $type = 3, $settings)
    {
        if (Str::startsWith($value, 'data:image')) {
            $disk = config('backpack.base.root_disk_name');

            $userId = backpack_user()->id;

            $destination_path = "public/user_$userId/ava/" . date("d");

            $extension = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];

            $image = ImageManagerStatic::make($value)->encode($extension, 90);

            $image->resize($settings['width'], $settings['height'], function ($const) {
                $const->aspectRatio();
            });

            $filename = time() . '_' . Str::random(5) . ".$extension";

            Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);

            $file = File::create([
                'user_id' => $userId,
                'filename' => $filename,
                'file_path' => $public_destination_path . '/' . $filename,
                'type' => $type
            ]);
            return $file->id;
        }

        return false;
    }
}
