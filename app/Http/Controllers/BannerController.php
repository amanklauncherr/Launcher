<?php

namespace App\Http\Controllers;

// use App\Models\Banner;
use App\Models\BannerNew;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BannerController extends Controller
{
   

    public function Upload(Request $request)
    {
        $banner = BannerNew::where('Banner_No', $request->Banner_No)->first();

        $validator = Validator::make(
            $request->all(), [
                'Banner_No' => 'required|string',
                'Banner_heading' => $banner ? 'nullable|string|max:25' : 'required|string|max:25',
                'Banner_sub_heading' => $banner ? 'nullable|string|max:50' : 'required|string|max:50',
                'Banner_button_text' => $banner ? 'nullable|string|max:20' : 'required|string|max:20',
                'Banner_image' => $banner ? 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120' : 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $validator->validated();

            if (!$banner && BannerNew::count() >= 3) {
                return response()->json([
                    'message' => 'Cannot create more than 3 banners'
                ], 400);
            }

            if ($request->hasFile('Banner_image')) {
                $uploadedFileUrl = Cloudinary::upload($request->file('Banner_image')->getRealPath())->getSecurePath();
                $data['Banner_image'] = $uploadedFileUrl;
            }

            if($banner)
            {
                $banner->update($data);
                return response()->json(['message' => 'Banner updated'], 201);
            }else {
                BannerNew::create($data);
                return response()->json(['message' => 'Banner created'], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while Adding or Updating Section',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function showUpload()
    {
        $terms =BannerNew::all();
        if($terms->isEmpty())
        {
            return response()->json(['message' => 'No Banner found'], 404);
        }
        else {

            return response()->json($terms,200);
        }
    }
}



// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class AddSubTextAndButtonTextToBannerNewTable extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::table('banner_new', function (Blueprint $table) {
//             $table->string('sub_text')->nullable()->after('column_name'); // Replace 'column_name' with the name of the column after
// iem-xnrj-hhb
