<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SliderController extends Controller
{
    // All Slider Method
    public function AllSlider() {
        $slider = Slider::latest()->get();
        return view('admin.backend.slider.slider_all', compact('slider'));
    }

    public function AddSlider() {
        return view('admin.backend.slider.add_slider');
    }

    public function StoreSlider(Request $request) {
        $save_url = null;

        if ($request->file('photo')) {
            $photo = $request->file('photo');

            $manager = new ImageManager(new Driver());

            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();

            $image = $manager->decode($photo->getContent());

            $image->resize(60, 60);

            $image->save(public_path('upload/slider/' . $name_gen));

            $save_url = 'upload/slider/' . $name_gen;
        }

        Slider::create([
            'title'     => $request->title,
            'description' => $request->description,
            'link'  => $request->link,
            'image'    => $save_url,
        ]);

        $notification = [
            'message'    => 'Slider Added Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.slider')->with($notification);
    }

    public function EditSlider($id) {
        $slider = Slider::find($id);
        return view('admin.backend.slider.edit_slider', compact('slider'));
    }

    public function UpdateSlider(Request $request) {
        $slider = Slider::findOrFail($request->id);

        $data = [
            'title'     => $request->title,
            'description' => $request->description,
            'link'  => $request->link,
        ];

        if ($request->file('photo')) {
            $photo = $request->file('photo');

            $manager = new ImageManager(new Driver());

            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();

            $image = $manager->decode($photo->getContent());

            $image->resize(60, 60);

            $image->save(public_path('upload/slider/' . $name_gen));

            if ($slider->image && file_exists(public_path($slider->image))) {
                @unlink(public_path($slider->image));
            }

            $data['image'] = 'upload/slider/' . $name_gen;
        }

        $slider->update($data);

        $notification = [
            'message'    => 'Slider Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.slider')->with($notification);
    }

    public function DeleteSlider($id) {
        $slider = Slider::findOrFail($id);

        if ($slider->image && file_exists(public_path($slider->image))) {
            @unlink(public_path($slider->image));
        }

        $slider->delete();

        $notification = [
            'message'    => 'Slider Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.slider')->with($notification);
    }
}
