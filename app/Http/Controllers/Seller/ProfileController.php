<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Seller;
use App\User;
use App\State;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seller = Auth::user()->seller;
        $states = State::orderBy('id', 'asc')->get();

        return view('seller.profile')->with('seller', $seller)->with('states', $states);
    }
    
    public function update(Request $request, $id)
    {
        $id = Helper::decrypt($id);
        $data = $request->all();
        $rules = [
            'name' => 'required',
            'state' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } 
        $seller = Seller::find($id);
        if ($request->hasFile('image')) {
            $originalmage = $seller->image;
            $s3path = parse_url($originalmage);
            if (Storage::disk('s3')->exists($s3path['path'])) {  
                Storage::disk('s3')->delete($s3path['path']);
            }

            $image = $request->file('image');
            $file_name = time() . '_profile.' . $image->getClientOriginalExtension();
            $path = "images/profile/" . $file_name;
            $upload = Storage::disk('s3')->put($path, file_get_contents($image), 'public');
            $fileURL = Storage::disk('s3')->url($path);

        } else {
            $fileURL = $seller->image;
        }
        $seller->image = $fileURL;
        $seller->name = $data['name'];
        $seller->state = $data['state'];
        $seller->update();

        if($seller->user_id != null){
            $updateUser = User::find($seller->user_id);
            if($updateUser){
                $updateUser->name = $data['name'];
                $updateUser->save();
            }
        }

        if (isset($data['remove_img']) && $data['remove_img'] != '') {
            $removeImage = explode(",", $data['remove_img']);
            foreach ($removeImage as $image) {
                $existingImage = SellerTopBanner::find($image);
                $originalmage = $existingImage->image;
                $s3path = parse_url($originalmage);
                if (Storage::disk('s3')->exists($s3path['path'])) {  
                    Storage::disk('s3')->delete($s3path['path']);
                }
                $existingImage->delete();
            }
        }

        return redirect()->route('seller.profile')->with('success', 'Profile updated successfully');
    }
}
