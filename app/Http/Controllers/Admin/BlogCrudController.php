<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlogRequest;
use App\Models\ArticleContent;
use App\Models\ArticlePhoto;
use App\Models\File;
use App\Services\FileService;
use Backpack\CRUD\app\Library\Widget;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

/**
 * Class BlogCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlogCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;

    protected $fileService;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Article::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blog');
        CRUD::setEntityNameStrings(trans('custom.article'), trans('custom.articles'));
        CRUD::setCreateView('admin.blog.create');
    }

    public function fetchTags()
    {
        return $this->fetch([
            'model' => \App\Models\Tag::class,
            'searchable_attributes' => ['name'],
            'paginate' => 10
        ]);
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

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        $this->crud->setColumns([
            [
                'label' => 'Image',
                'name' => 'image.file_path',
                'type' => 'image'
            ],
            [
                'label' => 'ID',
                'name' => 'id',
            ],
            [
                'label' => trans('custom.title'),
                'name' => 'title',
                'type' => 'closure',
                'function' => function($entity) {
                    return optional($entity->contentByLang())->title;
                }
            ],
            [
                'label' => 'Hits',
                'name' => 'hits'
            ]
        ]);
    }

    protected function setupShowOperation()
    {
        
        $id = $this->crud->getCurrentEntryId();
        $entry = $this->crud->getEntry($id);

        // CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */

        CRUD::setColumns([
            [
                'label' => 'ID',
                'name' => 'id',
            ],
            [
                'label' => 'Hits',
                'name' => 'hits'
            ],
            [
                'label' => 'Image',
                'name' => 'image.file_path',
                'type' => 'image'
            ]
        ]);

        CRUD::addColumn([
            'label' => 'Tags',
            'name' => 'tags',
        ]);

        foreach ($entry->contents as $content) {

            $languageCode = Str::upper($content->language->name);

            Widget::add([
                'type' => 'card',
                'wrapper' => ['class' => 'col-md-8 px-0 pl-md-0 pr-md-2'], // optional
                'section' => 'after_content',
                'content' => [
                    'header' => $content->title . " ($languageCode)" ,
                    'body' => $content->text
                ]
            ]);
        }

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(BlogRequest::class);
        
        foreach ($this->crud->model->getLanguages() as $index => $language) {

            $languageCode = Str::upper($language->name);
            
            CRUD::addField([
                'label' => "Title ($languageCode)",
                'name' => "contents[$index].title",
                'entity' => 'contents',
                'type' => 'text',
                'tab' => $languageCode
            ]);

            CRUD::addField([
                'label' => "Text ($languageCode)",
                'name' => "contents[$index].text",
                'entity' => 'contents',
                'type' => 'ckeditor',
                'tab' => $languageCode
            ]);

            CRUD::addField([
                'type' => 'hidden',
                'name' => "contents[$index].lang_id",
                'entity' => 'contents',
                'value' => $language->id,
                'tab' => $languageCode
            ]);

        }

        CRUD::setFromDb(); // fields

        CRUD::addField([
            'label' => "Image",
            'name' => "image.file_path",
            'type' => 'image',
            'attribute' => 'file_path',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 2, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        CRUD::addField([
            'type' => 'relationship',
            'name' => 'tags',
            'ajax' => true,
            'inline_create' => [
                'entity' => 'tags',
                'force_select' => true,
                'modal_route' => route('tags-inline-create'),
                'create_route' =>  route('tags-inline-create-save'),
                'include_main_form_fields' => ['name', 'slug'],
            ],
        ]);

        CRUD::removeField('hits');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        $contents = isset($request['contents']) 
        ? $request['contents'] 
        : [];

        // insert article in the db
        $article = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $article;

        foreach ($contents as $lang_id => $content) {
            $articleContent = new ArticleContent($content);
            
            $article->contents()->save($articleContent);
        }

        if (isset($this->crud->getStrippedSaveRequest()['image']) && $fileId = $this->storeBase64Image($this->crud->getStrippedSaveRequest()['image']['file_path'])) {
            $articlePhoto = new ArticlePhoto([
                'file_id' => $fileId,
                'hits' => 0
            ]);

            $article->photos()->save($articlePhoto);
        }
        
        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($article->getKey());
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(BlogRequest::class);
        
        $id = $this->crud->getCurrentEntryId();
        $entry = $this->crud->getEntry($id);

        foreach ($this->crud->model->getLanguages() as $index => $language) {

            $languageCode = Str::upper($language->name);
            $content = $entry->contentByLang($language->id);
            $relationId = $content ? $content->id : '';
            
            CRUD::addField([
                'label' => "Title ($languageCode)",
                'name' => "contents[$index].title",
                'entity' => 'contents',
                'type' => 'text',
                'value' => $content ? $content->title : '',
                'tab' => $languageCode
            ]);

            CRUD::addField([
                'label' => "Text ($languageCode)",
                'name' => "contents[$index].text",
                'entity' => 'contents',
                'type' => 'ckeditor',
                'value' => $content ? $content->text : '',
                'tab' => $languageCode
            ]);

            CRUD::addField([
                'type' => 'hidden',
                'name' => "contents[$index].lang_id",
                'entity' => 'contents',
                'value' => $language->id,
                'tab' => $languageCode
            ]);

            if ($relationId) {
                CRUD::addField([
                    'type' => 'hidden',
                    'name' => "contents[$index].id",
                    'entity' => 'contents',
                    'value' => $relationId,
                    'tab' => $languageCode
                ]);
            }

        }

        CRUD::setFromDb(); // fields

        CRUD::addField([
            'label' => "Image",
            'name' => "image.file_path",
            'type' => 'image',
            'attribute' => 'file_path',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 2, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            // 'prefix'    => 'uploads/images/blog/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        ]);

        CRUD::addField([
            'label' => 'Tags',
            'type' => 'relationship',
            'name' => 'tags',
            'ajax' => true,
            'inline_create' => [
                'entity' => 'tags',
                'force_select' => true,
                'modal_route' => route('tags-inline-create'),
                'create_route' =>  route('tags-inline-create-save'),
                'include_main_form_fields' => ['name', 'slug'],
            ],
        ]);

        CRUD::removeField('hits');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
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
        $contents = isset($request['contents']) 
            ? $request['contents'] 
            : [];

        // update the row in the db
        $article = $this->crud->update($request->get($this->crud->model->getKeyName()),
                            $this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $article;
        foreach ($contents as $index => $content) {
            if (isset($content['id'])) {
                $articleContent = ArticleContent::where([
                    'id' => $content['id'],
                    'blog_id' => $article->id
                ])->first();
                unset($content['id']);

                if ($articleContent) {
                    $articleContent->update($content);
                }
            } else {
                $articleContent = new ArticleContent($content);
                $article->contents()->save($articleContent);
            }
            
        }

        if (isset($this->crud->getStrippedSaveRequest()['image'])) {
            if ($this->crud->getStrippedSaveRequest()['image']['file_path'] !== null) {
                $fileId = $this->storeBase64Image($this->crud->getStrippedSaveRequest()['image']['file_path']);
                $articlePhoto = new ArticlePhoto([
                    'file_id' => $fileId,
                    'hits' => 0
                ]);
    
                $article->photos()->save($articlePhoto);
            } else if ($article->image) {
                $article->image()->delete();
            }
        }

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($article->getKey());
    }

    protected function storeBase64Image($value, int $type = 1)
    {
        if (Str::startsWith($value, 'data:image')) {
            $disk = config('backpack.base.root_disk_name'); 

            $destination_path = "public/uploads/". date("Y") . "/" . date("m") . "/" . date("d"); 

            $extension = explode('/', explode(':', substr($value, 0, strpos($value, ';')))[1])[1];

            $image = ImageManagerStatic::make($value)->encode($extension, 90);
    
            $filename = time() . '_' . Str::random(5) . ".$extension";

            Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            $public_destination_path = Str::replaceFirst('public/', '', $destination_path);

            $file = File::create([
                'user_id' => backpack_user()->id,
                'filename' => $filename,
                'file_path' => $public_destination_path . '/' . $filename,
                'type' => $type
            ]);
            return $file->id;
        }

        return false;
    }
}
