<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use App\Models\User;
use App\Models\Media;
use Illuminate\Support\Str;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class MediaController extends Controller
{
	public function imageupload(Request $request)
	{
		//echo "Hai"; 
		//echo "<pre>"; print($request); die;
		//echo $request->type; die;
		$validator = Validator::make($request->all(), 
			[ 
				'lang_code' => 'required',
				'type' => 'required',
				'image'  => 'required|mimes:png,jpg,jpeg',
			]); 

		if ($validator->fails()) {          
			return response()->json([
				"status" => "false",
				"status_code" => "Invalid",
				"message" => "Invalid Params",
			]);                        
		}

		if ($files = $request->file('image')) {


			if($request->type == "item") {
			    //store file into disk
				$randomname = Str::random(6);
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileNameToStore = $randomname.'_'.time().'.'.$extension;
				$path = $request->file('image')->storeAs('public/products/original/',$fileNameToStore);

				/*$img = Image::make($request->file('image'))->resize(300, 300, function ($constraint) {
				$constraint->aspectRatio();
				})->stream();*/
				
				$img = Image::make($request->file('image'));
				$img->orientate()
				->fit(300, 300, function ($constraint) {
				    $constraint->upsize();
				})->stream();
				Storage::disk('public')->put('/products/thumb300/'.$fileNameToStore,$img);
				
				$originalURL = url('/')."/storage/app/public/products/original/".$fileNameToStore;
				$thumbURL = url('/')."/storage/app/public/products/thumb300/".$fileNameToStore;

				if($fileNameToStore)
				{
					return response()->json([
						"status" => "true",
						"message" => "Image upload successfully",
						"original_image" => $originalURL,
						"thumb300_image" => $thumbURL,
						"image_name" => $fileNameToStore
					]);
				}
				else
				{
					return response()->json([
						"status" => "false",
						"message" => "Something went wrong",
					]);
				}



			} 
			if($request->type == "profile") {

				$randomname = Str::random(6);
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileNameToStore = $randomname.'_'.time().'.'.$extension;
				$path = $request->file('image')->storeAs('public/users/original/',$fileNameToStore);

				/*$img = Image::make($request->file('image'))->resize(100, 100, function ($constraint) {
				$constraint->aspectRatio();
				})->stream();*/
				
				$img = Image::make($request->file('image'));
				$img->orientate()
				->fit(100, 100, function ($constraint) {
				    $constraint->upsize();
				})->stream();
				
				Storage::disk('public')->put('/users/thumb100/'.$fileNameToStore,$img);
				
				$originalURL = url('/')."/storage/app/public/users/original/".$fileNameToStore;
				$thumbURL = url('/')."/storage/app/public/users/thumb100/".$fileNameToStore;

				if($fileNameToStore)
				{
					return response()->json([
						"status" => "true",
						"message" => "Image upload successfully",
						"original_image" => $originalURL,
						"thumb100_image" => $thumbURL,
						"image_name" => $fileNameToStore
					]);
				}
				else
				{
					return response()->json([
						"status" => "false",
						"message" => "Something went wrong",
					]);
				}


			}
			if($request->type == "chat") {


				$randomname = Str::random(6);
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileNameToStore = $randomname.'_'.time().'.'.$extension;
				$path = $request->file('image')->storeAs('public/chats/',$fileNameToStore);

				/*$upload_file = $request->file('image');
				$height = Image::make($upload_file)->height();
				$width = Image::make($upload_file)->width();

				//echo $width.'-'.$height; die;

				$img = Image::make($request->file('image'))->resize($width, $height, function ($constraint) {
				$constraint->upsize();
				$constraint->aspectRatio();
				})->stream();
				Storage::disk('public')->put('/chats/'.$fileNameToStore,$img);*/
				
				$originalURL = url('/')."/storage/app/public/chats/".$fileNameToStore; 

				if($fileNameToStore)
				{
					return response()->json([
						"status" => "true",
						"message" => "Image upload successfully",
						"original_image" => $originalURL,
						"image_name" => $fileNameToStore
					]);
				}
				else
				{
					return response()->json([
						"status" => "false",
						"message" => "Something went wrong",
					]);
				}


			}
         
		}

		
	}

	public function taskerprofileupload(Request $request)
	{

		$validator = Validator::make($request->all(), 
			[ 
				'user_id' => 'required',
				'image'  => 'required|mimes:png,jpg,jpeg|max:2048',
			]); 

		if ($validator->fails()) {          
			return response()->json([
				"status_code" => 400,
				"message" => "Invalid Params",
			]);                        
		}

		$user_id = $request->user_id;
		$user_exists= User::where('userId',$user_id)->where('role','tasker')->count();
		
		if(!$user_exists){
			return response()->json([
				"status_code" => 400,
				"message" => "Invalid User ID",
			]);
		}

		$userDB= User::where('userId',$user_id)->where('role','tasker')->first();

		if ($files = $request->file('image')) {

			//store file into disk
			$randomname = Str::random(6);
			$extension = $request->file('image')->getClientOriginalExtension();
			$new_file_name = $randomname.'_'.time().'.'.$extension;
			$path = $request->file('image')->storeAs('public/taskers/avatars/',$new_file_name);
			$mediaURL = url('/media/taskers/'.$new_file_name);
			
			//store your file into database
			$userDB->image = $new_file_name;            
		}


		if($userDB->save())
		{
			return response()->json([
				"status_code" => 200,
				"image" => $mediaURL,
			]);
		}
		else
		{
			return response()->json([
				"status_code" => 500,
				"message" => "Something went wrong",
			]);
		}
	}

	public function taskermediaupload(Request $request)
	{

		$validator = Validator::make($request->all(), 
			[ 
				'user_id' => 'required',
				'type' => 'required',
				'name' => 'required',
				'image'  => 'required|mimes:png,jpg,jpeg,pdf|max:2048',
			]); 

		if ($validator->fails()) {          
			return response()->json([
				"status_code" => 400,
				"message" => "Invalid Params",
			]);                        
		}

		try {

			$user_id = $request->user_id;

			$user_record= User::where('userId',$user_id)->where('role','tasker')->first();

			if(!$user_record){
				return response()->json([
					"status_code" => 400,
					"message" => "Invalid User ID",
				]);
			}

			$media = new Media();
			$mediapath = "documents/";
			$media->for = $request->get('type');
			$media->name = $request->get('name');
			$media->taskerId = new \MongoDB\BSON\ObjectID($user_record->_id);

			if($request->get('type') === "portfolio"){
				$mediapath = "portfolio/";
			}

			if ($files = $request->file('image')) {

				$file_type = $request->file('image')->getMimeType();

				$valid_file_types = array("image/png", "image/jpg", "image/jpeg", "application/pdf");

				if($request->get('type') === "portfolio")
					$valid_file_types = array("image/png", "image/jpg", "image/jpeg");


				if (in_array($file_type, $valid_file_types)){

					//	store file into disk
					$randomname = Str::random(6);
					$extension = $request->file('image')->getClientOriginalExtension();
					$new_file_name = $randomname.'_'.time().'.'.$extension;
					$path = $request->file('image')->storeAs('public/taskers/'.$mediapath,$new_file_name);
					$mediaURL = url('/media/'.$mediapath.$new_file_name);

					//	store your file into database
					$media->media_name = $new_file_name;
				}
				else
				{
					return response()->json([
						"status_code" => 400,
						"message" => "Only jpg,png images are allowed",
					]);
				}          
			}

			if($media->save())
			{	
				$mediaId = $media->_id;
				return response()->json([
					"status_code" => 200,
					"name"=>$request->get('name'),
					"media_id"=>$mediaId,
					"image" => $mediaURL,
				]);
			}
			else
			{
				return response()->json([
					"status_code" => 500,
					"message" => "Something went wrong",
				]);
			}

		} catch (Exception $exception) {
			return response()->json([
				"status_code" => 500,
				"message" => "Something went wrong",
			]);
		}
	}



	public function userchatupload(Request $request)
	{

		$validator = Validator::make($request->all(), 
			[ 
				'user_id' => 'required',
				'media'  => 'required|mimes:png,jpg,jpeg,pdf|max:2048',
			]); 

		if ($validator->fails()) {          
			return response()->json([
				"status_code" => 400,
				"message" => "Invalid Params",
			]);                        
		}

		$user_id = $request->user_id;
		$user_exists= User::where('userId',$user_id)->where('role','user')->count();
		
		if(!$user_exists){
			return response()->json([
				"status_code" => 400,
				"message" => "Invalid User ID",
			]);
		}

		if ($files = $request->file('media')) {

			//store file into disk
			$randomname = Str::random(6);
			$extension = $request->file('media')->getClientOriginalExtension();
			$new_file_name = $randomname.'_'.time().'.'.$extension;
			$path = $request->file('media')->storeAs('public/users/chats/',$new_file_name);
			$mediaURL = url('/media/users/chats/'.$new_file_name);         
		}


		return response()->json([
			"status_code" => 200,
			'media_name'=>$new_file_name,
			"media_url" => $mediaURL,
		]);
	}

	public function taskerchatupload(Request $request)
	{

		$validator = Validator::make($request->all(), 
			[ 
				'user_id' => 'required',
				'media'  => 'required|mimes:png,jpg,jpeg,pdf|max:2048',
			]); 

		if ($validator->fails()) {          
			return response()->json([
				"status_code" => 400,
				"message" => "Invalid Params",
			]);                        
		}

		$user_id = $request->user_id;
		$user_exists= User::where('userId',$user_id)->where('role','tasker')->count();
		
		if(!$user_exists){
			return response()->json([
				"status_code" => 400,
				"message" => "Invalid User ID",
			]);
		}

		if ($files = $request->file('media')) {

			//store file into disk
			$randomname = Str::random(6);
			$extension = $request->file('media')->getClientOriginalExtension();
			$new_file_name = $randomname.'_'.time().'.'.$extension;
			$path = $request->file('media')->storeAs('public/taskers/chats/',$new_file_name);
			$mediaURL = url('/media/taskers/chats/'.$new_file_name);         
		}

		return response()->json([
			"status_code" => 200,
			'media_name'=>$new_file_name,
			"media_url" => $mediaURL,
		]);
		
	}


	public function taskeraudioupload(Request $request)
	{

		$validator = Validator::make($request->all(), 
			[ 
				'user_id' => 'required',
				'audio' => 'mimes:audio/mp3,mpga,mp3,wav,aac,mp4a,opus,ogg,m4a|required',
			]); 

		if ($validator->fails()) {          
			return response()->json([
				"status_code" => 400,
				"message" => "Invalid params",
			]);                        
		}
		$user_id = $request->user_id;
		$user_exists= User::where('userId',$user_id)->where('role','tasker')->count();
		
		if(!$user_exists){
			return response()->json([
				"status_code" => 400,
				"message" => "Invalid User ID",
			]);
		}

		$userDB= User::where('userId',$user_id)->where('role','tasker')->first();

		if ($files = $request->file('audio')) {

			//store file into disk
			$randomname = Str::random(6);
			$extension = $request->file('audio')->getClientOriginalExtension();
			$fileNameToStore = $randomname.'_'.time().'.'.$extension;
			$path = $request->file('audio')->storeAs('public/users/audio/',$fileNameToStore);
			$audioURL = url('/media/users/'.$fileNameToStore);
		}

		if($path)
		{
			return response()->json([
				"status_code" => 200,
				"audio" => $audioURL,
			]);
		}
		else
		{
			return response()->json([
				"status_code" => 500,
				"message" => "Something went wrong",
			]);
		}
	}


	public function useraudioupload(Request $request)
	{

		$validator = Validator::make($request->all(), 
			[ 
				'user_id' => 'required',
				'audio' => 'mimes:audio/mp3,mpga,mp3,wav,aac,mp4a,opus,ogg|required',
			]); 

		if ($validator->fails()) {          
			return response()->json([
				"status_code" => 400,
				"message" => "Invalid params",
			]);                        
		}
		$user_id = $request->user_id;
		$user_exists= User::where('userId',$user_id)->where('role','user')->first();
		
		if(!$user_exists){
			return response()->json([
				"status_code" => 400,
				"message" => "Invalid User ID",
			]);
		}

		$userDB= User::where('userId',$user_id)->where('role','user')->first();

		if ($files = $request->file('audio')) {

			//store file into disk
			$randomname = Str::random(6);
			$extension = $request->file('audio')->getClientOriginalExtension();
			$fileNameToStore = $randomname.'_'.time().'.'.$extension;
			$path = $request->file('audio')->storeAs('public/users/audio/',$fileNameToStore);
			$audioURL = url('/media/users/'.$fileNameToStore);
			//store your file into database
			         
		}

		if($path)
		{
			return response()->json([
				"status_code" => 200,
				"audio" => $audioURL,
			]);
		}
		else
		{
			return response()->json([
				"status_code" => 500,
				"message" => "Something went wrong",
			]);
		}
	}
}

