<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HomeController extends Controller
{
    public function AllFeature()
    {
        $feature = Feature::latest()->get();
        return view('admin.backend.feature.feature_all', compact('feature'));
    }

    public function AddFeature() {
        return view('admin.backend.feature.add_feature');
    }

    public function StoreFeature(Request $request) {
        $save_url = null;

        if ($request->file('photo')) {
            $photo = $request->file('photo');

            $manager = new ImageManager(new Driver());

            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();

            $image = $manager->decode($photo->getContent());

            $image->resize(60, 60);

            $image->save(public_path('upload/feature/' . $name_gen));

            $save_url = 'upload/feature/' . $name_gen;
        }

        Feature::create([
            'title'       => $request->title,
            'description' => $request->description,
            'icon'        => $save_url,
        ]);

        $notification = [
            'message'    => 'Feature Added Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.feature')->with($notification);
    }

    public function EditFeature($id) {
        $feature = Feature::find($id);
        return view('admin.backend.feature.edit_feature', compact('feature'));
    }

    public function UpdateFeature(Request $request) {
        $feature = Feature::findOrFail($request->id);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
        ];

        if ($request->file('photo')) {
            $photo = $request->file('photo');

            $manager = new ImageManager(new Driver());

            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();

            $image = $manager->decode($photo->getContent());

            $image->resize(60, 60);

            $image->save(public_path('upload/feature/' . $name_gen));

            if ($feature->icon && file_exists(public_path($feature->icon))) {
                @unlink(public_path($feature->icon));
            }

            $data['icon'] = 'upload/feature/' . $name_gen;
        }

        $feature->update($data);

        $notification = [
            'message'    => 'Feature Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.feature')->with($notification);
    }

    public function DeleteFeature($id) {
        $feature = Feature::findOrFail($id);

        if ($feature->icon && file_exists(public_path($feature->icon))) {
            @unlink(public_path($feature->icon));
        }

        $feature->delete();

        $notification = [
            'message'    => 'Feature Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.feature')->with($notification);
    }
}
