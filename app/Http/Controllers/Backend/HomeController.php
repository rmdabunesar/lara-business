<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Clarifies;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use App\Models\Usability;

class HomeController extends Controller
{
    // Display all features in the admin listing view.
    public function AllFeature()
    {
        $feature = Feature::latest()->get();
        return view('admin.backend.feature.feature_all', compact('feature'));
    }

    // Show the form for adding a new feature.
    public function AddFeature()
    {
        return view('admin.backend.feature.add_feature');
    }

    // Store a newly created feature and upload its image if provided.
    public function StoreFeature(Request $request)
    {
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

    // Load the selected feature for editing.
    public function EditFeature($id)
    {
        $feature = Feature::find($id);
        return view('admin.backend.feature.edit_feature', compact('feature'));
    }

    // Update an existing feature and replace its image if a new one is uploaded.
    public function UpdateFeature(Request $request)
    {
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

    // Remove a feature and delete its uploaded image file.
    public function DeleteFeature($id)
    {
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

    // Display the clarifies record in the admin listing view.
    public function GetClarifies()
    {
        $clarifies = Clarifies::first();

        if (! $clarifies) {
            $clarifies = Clarifies::create([
                'title'       => null,
                'description' => null,
                'image'       => null,
            ]);
        }

        return view('admin.backend.clarifies.clarifies_all', compact('clarifies'));
    }

    // Show the form for adding a new clarifies entry (placeholder / redirect to all).
    public function AddClarifies()
    {
        return redirect()->route('all.clarifies');
    }

    // Create or update the clarifies entry.
    public function UpdateClarifies(Request $request)
    {
        $clarifies = $request->filled('id') ? Clarifies::find($request->id) : null;

        if (! $clarifies) {
            $clarifies = new Clarifies();
        }

        // Handle inline AJAX update
        if ($request->ajax() || $request->has('field')) {
            $field = $request->input('field');
            $value = $request->input('value');

            if (in_array($field, ['title', 'description'])) {
                $clarifies->$field = $value;
                $clarifies->save();

                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Invalid field']);
        }

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
        ];

        if ($request->file('photo')) {
            $photo = $request->file('photo');

            $manager = new ImageManager(new Driver());

            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();
            $uploadPath = public_path('upload/clarifies');

            if (! File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true, true);
            }

            $image = $manager->decode($photo->getContent());
            $image->resize(306, 618);
            $image->save($uploadPath . '/' . $name_gen);

            if ($clarifies->image && file_exists(public_path($clarifies->image))) {
                @unlink(public_path($clarifies->image));
            }

            $data['image'] = 'upload/clarifies/' . $name_gen;
        }

        $clarifies->fill($data);
        $clarifies->save();

        $notification = [
            'message'    => 'Clarifies Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.clarifies')->with($notification);
    }

    // Display all usabilities in the admin listing view.
    public function GetUsabilities()
    {
        $usabilities = Usability::first();

        if (! $usabilities) {
            $usabilities = Usability::create([
                'title'       => null,
                'description' => null,
                'button_text' => null,
                'button_url'  => null,
                'youtube_url' => null,
                'thumbnail'   => null,
            ]);
        }

        return view('admin.backend.usabilities.usabilities_all', compact('usabilities'));
    }

    // Show the form for adding a new usabilities entry (placeholder / redirect to all).
    public function AddUsabilities()
    {
        return redirect()->route('all.usabilities');
    }

    // Create or update the usabilities entry.
    public function UpdateUsabilities(Request $request)
    {
        $usabilities = $request->filled('id') ? Usability::find($request->id) : null;

        if (! $usabilities) {
            $usabilities = new Usability();
        }

        // Handle inline AJAX update
        if ($request->ajax() || $request->has('field')) {
            $field = $request->input('field');
            $value = $request->input('value');

            if (in_array($field, ['title', 'description', 'button_text', 'button_url', 'youtube_url'])) {
                $usabilities->$field = $value;
                $usabilities->save();

                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Invalid field']);
        }

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_url'  => $request->button_url,
            'youtube_url' => $request->youtube_url,
        ];

        if ($request->file('photo')) {
            $photo = $request->file('photo');

            $manager = new ImageManager(new Driver());

            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();
            $uploadPath = public_path('upload/usabilities');

            if (! File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true, true);
            }

            $image = $manager->decode($photo->getContent());
            $image->resize(560, 400);
            $image->save($uploadPath . '/' . $name_gen);

            if ($usabilities->thumbnail && file_exists(public_path($usabilities->thumbnail))) {
                @unlink(public_path($usabilities->thumbnail));
            }

            $data['thumbnail'] = 'upload/usabilities/' . $name_gen;
        }

        $usabilities->fill($data);
        $usabilities->save();

        $notification = [
            'message'    => 'Usabilities Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.usabilities')->with($notification);
    }

}
