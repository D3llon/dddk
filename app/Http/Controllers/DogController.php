<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Dog;
use App\Models\DogPhoto;
use App\Models\Photo;
use App\Models\UserDog;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Validator;

class DogController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dogs = $user->dogs;
        return view('area.dogs')->with(compact('dogs'));
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        if ($request->isMethod('POST')) {
            $this->updateDogData($request);
        }

        return view('area.dog.add')->with(compact('user'));
    }

    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        if ($request->isMethod('POST')) {
            $this->updateDogData($request, true);
        }

        $dog = Dog::find($id);
//        dd($dog->modifications->count());

        return $dog->user_id === Auth::id()
            ? view('area.dog.add')->with(compact('dog', 'user'))
            : redirect(route('area.dog.index'))->with('error', 'Nemáte prístup.');
    }

    public function updateDogData(Request $request, $isEdit = false)
    {
        $validator = Validator::make($request->all(), [
            'name'                => ['required', 'string'],
            'coowner'             => ['sometimes', 'string', 'nullable'],
            'dddk'                 => ['required', 'boolean'],
            'breed_id'            => ['required', 'exists:breeds,id'],
            'sex'                 => ['required', 'in:M,F'],
//            'user_id'             => ['required', 'exists:users,id'],
            'color'               => ['sometimes', 'string'],
            'hd'                  => ['sometimes', 'string'],
            'ed'                  => ['sometimes', 'string'],
            'eyes'                => ['sometimes', 'string'],
            'eic'                 => ['sometimes', 'string'],
            'shows'               => ['sometimes', 'string'],
            'exams'               => ['sometimes', 'string'],
            'sire_id'             => ['nullable', 'exists:dogs,id'],
            'sire_name'           => ['required_unless:sire_id,null'],
            'dam_id'              => ['nullable', 'exists:dogs,id'],
            'dam_name'            => ['required_unless:dam_id,null'],
            'breeding_station_id' => ['nullable', 'exists:breeding_stations,id'],
            'birth_year'          => ['sometimes', 'numeric'],
            'birth_land'          => ['sometimes', 'string'],
            'litter_id'           => ['sometimes', 'exists:litters,id'],
            'deathdate'           => ['sometimes', 'numeric'],
            'image'               => ['sometimes', 'image'],
            'documents'           => ['sometimes', 'array']
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        $data = $validator->validated();
        if (!isset($data['dddk'])) {
            $data['dddk'] = false;
        }
        $data['status'] = 'pending';
        if (!$isEdit) {
            $data['user_id'] = Auth::id();
            $dog = Dog::create($data);
        } else {
            $dog = Dog::find($request->id);
            $dog->update([$data]);
        }

        if (isset($data['documents'])) {
            /** @var UploadedFile $document */
            foreach ($data['documents'] as $document) {
                $documentName = $document->getClientOriginalName();
                \Storage::disk('public')->put('documents/' . $documentName, $document->getContent());
                Document::firstOrCreate([
                    'name'   => $documentName,
                    'path'   => 'storage/documents/' . $documentName,
                    'type'   => 'dog',
                    'dog_id' => $dog->id
                ]);
            }
        }

        if (isset($data['image'])) {
            $image = Image::make($data['image'])->encode('jpg');

            $now = Carbon::now()->format('Y_m_d_H_i_s');
            $fileName = md5($now) . $now . '.jpg';
            \Storage::disk('public')->put('images/' . $fileName, $image->stream());

            $height = $image->height();
            $width = $image->width();

            $thumbFileName = 'thumb_' . $fileName;
            $image->resize(125, 125, function ($constraint) {
                $constraint->aspectRatio();
            });
            \Storage::disk('public')->put('images/thumbnails/' . $thumbFileName, $image->stream(null, 100));

            if ($isEdit) {
                $primary = $dog->photos()->where('primary', true)->first();
                $primary?->update(['primary' => false]);
            }

            $photo = Photo::create([
                'path'       => 'storage/images/' . $fileName,
                'path_thumb' => 'storage/images/thumbnails/' . $thumbFileName,
                'primary'    => true,
                'width'      => $width,
                'height'     => $height,
                'user_id'    => Auth::id()
            ]);

            DogPhoto::create([
                'photo_id' => $photo->id,
                'dog_id'   => $dog->id
            ]);
        }

        return redirect(route('area.dog.index'))->with('success', 'Vaša požiadavka o ' . ($isEdit ? 'úpravu' : 'pridanie') . ' psa bola zaznamenaná.');
    }
}
