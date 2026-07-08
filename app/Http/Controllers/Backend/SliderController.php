<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Title;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SliderController extends Controller
{
    public function GetSlider()
    {
        $slider = Slider::first();

        if (! $slider) {
            $slider = Slider::create([
                'title'       => null,
                'description' => null,
                'image'       => null,
                'link'        => null,
                'button_text' => null,
            ]);
        }

        return view('admin.backend.slider.get_slider', compact('slider'));
    }

    public function UpdateSlider(Request $request)
    {
        $slider = Slider::findOrFail($request->id);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'link'        => $request->link,
            'button_text' => $request->button_text,
        ];

        if ($request->file('photo')) {
            $photo = $request->file('photo');

            $manager = new ImageManager(new Driver());

            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();

            $image = $manager->decode($photo->getContent());

            $image->resize(306, 618);

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

        return redirect()->route('get.slider')->with($notification);
    }

    public function EditSlider(Request $request)
    {
        $slider = Slider::findOrFail($request->id);

        $field = $request->input('field');
        $value = $request->input('value');

        if (in_array($field, ['title', 'description', 'link', 'button_text'])) {
            $slider->$field = $value;
            $slider->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid field']);
    }

    public function EditTitle(Request $request)
    {
        $title = Title::findOrFail($request->id);

        $field = $request->input('field');
        $value = $request->input('value');

        if (in_array($field, ['features', 'reviews', 'answers'])) {
            $title->$field = $value;
            $title->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid field']);
    }
}
