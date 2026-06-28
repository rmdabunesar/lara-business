<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ReviewController extends Controller
{
    public function AllReview() {
        $review = Review::latest()->get();
        return view('admin.backend.review.review_all', compact('review'));
    }

    public function AddReview() {
        return view('admin.backend.review.add_review');
    }

    public function StoreReview(Request $request) {
        $save_url = null;

        if ($request->file('photo')) {
            $photo = $request->file('photo');

            $manager = new ImageManager(new Driver());

            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();

            $image = $manager->decode($photo->getContent());

            $image->resize(60, 60);

            $image->save(public_path('upload/review/' . $name_gen));

            $save_url = 'upload/review/' . $name_gen;
        }

        Review::create([
            'name'     => $request->name,
            'position' => $request->position,
            'message'  => $request->message,
            'image'    => $save_url,
        ]);

        $notification = [
            'message'    => 'Review Added Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.review')->with($notification);
    }

    public function EditReview($id) {
        $review = Review::find($id);
        return view('admin.backend.review.edit_review', compact('review'));
    }

    public function UpdateReview(Request $request) {
        $review = Review::findOrFail($request->id);

        $data = [
            'name'     => $request->name,
            'position' => $request->position,
            'message'  => $request->message,
        ];

        if ($request->file('photo')) {
            $photo = $request->file('photo');

            $manager = new ImageManager(new Driver());

            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();

            $image = $manager->decode($photo->getContent());

            $image->resize(60, 60);

            $image->save(public_path('upload/review/' . $name_gen));

            if ($review->image && file_exists(public_path($review->image))) {
                @unlink(public_path($review->image));
            }

            $data['image'] = 'upload/review/' . $name_gen;
        }

        $review->update($data);

        $notification = [
            'message'    => 'Review Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.review')->with($notification);
    }
}