<?php



class MiddlemenController extends BaseController {

/**

* Display a listing of the resource.

*

* @return Response

*/

	protected $layout = "layouts.main";	

	public function create_form()

	{

		$this->layout->content =  View::make('company.create');	

	}

	public function fancy_create_form()

	{

		return  View::make('company.fancycreate');	

	}

	public function show_middlemen()

	{

		$middlemen = DB::table('middlemen')->orderBy('created_at','desc')->get();

		$this->layout->content =  View::make('company.manage')->with('middlemen',$middlemen);	

	}

	public function store()

	{

		

		$rules = array(

			'first_name'     => 'required',

		);

		$validator = Validator::make(Input::all(), $rules);



		if ($validator->fails()) {

			return Redirect::to('middlemen/create')

				->withErrors($validator);

		} else {

		     function getExtension($str) {

			   $i = strrpos($str,".");

			   if (!$i) { return ""; }

			   $l = strlen($str) - $i;

			   $ext = substr($str,$i+1,$l);

			   return $ext;

			}

	

			$image=$_FILES['photo']['name'];

			if($image) 

			{

				$filename = stripslashes($image);

				$extension = getExtension($filename);

				$extension = strtolower($extension);

				if($extension == "jpg" || $extension == "png" || $extension== "gif"){

					$imgname = rand().time();

					$image_name= $imgname.'.'.$extension;

					$newpath= public_path()."/img/".$image_name;

					$copied = copy($_FILES['photo']['tmp_name'], $newpath);

					if (!$copied) 

					{

						return Redirect::to('products');

					}

					else

					{

						$get_photo = $image_name;		

					}

				}	

				else{

					return Redirect::to('company');

				}	

			}

			else{

				$get_photo = "";

			}

			$MiddlemenEntry = new MiddlemenEntry;

			$MiddlemenEntry->first_name       = Input::get('first_name');	

			$MiddlemenEntry->reg_no       = Input::get('reg_no');			

			$MiddlemenEntry->mobile_contact       = Input::get('mobile_contact');

			$MiddlemenEntry->photo = $get_photo;

			$MiddlemenEntry->email		   = Input::get('email');

			$MiddlemenEntry->address       = Input::get('address');

			$MiddlemenEntry->remarks		   = Input::get('remarks');

			$MiddlemenEntry->updated_by		   = Auth::user()->id;

			date_default_timezone_set('Singapore');

			$date = date('Y-m-d h:i:s', time());

			$MiddlemenEntry->created_at		   = $date;

			$MiddlemenEntry->updated_at		   = $date;

			$MiddlemenEntry->save();



			return Redirect::to('company');

		}

		

	}

	public function fancystore()

	{

		

		$rules = array(

			'first_name'     => 'required',

		);

		$validator = Validator::make(Input::all(), $rules);



		if ($validator->fails()) {

			return Redirect::to('company/create')

				->withErrors($validator);

		} else {

		    function getExtension($str) {

			   $i = strrpos($str,".");

			   if (!$i) { return ""; }

			   $l = strlen($str) - $i;

			   $ext = substr($str,$i+1,$l);

			   return $ext;

			}

	

			$image=$_FILES['photo']['name'];

			if($image) 

			{

				$filename = stripslashes($image);

				$extension = getExtension($filename);

				$extension = strtolower($extension);

				if($extension == "jpg" || $extension == "png" || $extension== "gif"){

					$imgname = rand().time();

					$image_name= $imgname.'.'.$extension;

					$newpath= public_path()."/img/".$image_name;

					$copied = copy($_FILES['photo']['tmp_name'], $newpath);

					if (!$copied) 

					{

						return Redirect::to('products');

					}

					else

					{

						$get_photo = $image_name;		

					}

				}	

				else{

					return Redirect::to('company');

				}	

			}

			else{

				$get_photo = "";

			}

			$MiddlemenEntry = new MiddlemenEntry;

			$MiddlemenEntry->first_name       = Input::get('first_name');

			$MiddlemenEntry->photo = $get_photo;

			$MiddlemenEntry->mobile_contact       = Input::get('mobile_contact');

			$MiddlemenEntry->email		   = Input::get('email');

			$MiddlemenEntry->address       = Input::get('address');

			$MiddlemenEntry->remarks		   = Input::get('remarks');

			$MiddlemenEntry->updated_by		   = Auth::user()->id;

			date_default_timezone_set('Singapore');

			$date = date('Y-m-d h:i:s', time());

			$MiddlemenEntry->created_at		   = $date;

			$MiddlemenEntry->updated_at		   = $date;

			$MiddlemenEntry->save();



			return View::make('utilities.fancy')->with('id',DB::getPdo()->lastInsertId())->with('name',Input::get('first_name')." ".Input::get('last_name'));

		}

		

	}

	public function save_edit()

	{

		$rules = array(

			'first_name'     => 'required',

		);

		$validator = Validator::make(Input::all(), $rules);



		if ($validator->fails()) {

			return Redirect::to('company/create')

				->withErrors($validator);

		} else {

		    

			$MiddlemenEntry = MiddlemenEntry::find(Input::get('id'));

			function getExtension($str) {

			   $i = strrpos($str,".");

			   if (!$i) { return ""; }

			   $l = strlen($str) - $i;

			   $ext = substr($str,$i+1,$l);

			   return $ext;

			}

	

			$image=$_FILES['photo']['name'];

			if($image) 

			{

				//$unlink_existing_image = $MiddlemenEntry->photo;

				//unlink(public_path()."/img/".$unlink_existing_image);

				$filename = stripslashes($image);

				$extension = getExtension($filename);

				$extension = strtolower($extension);

				if($extension == "jpg" || $extension == "png" || $extension== "gif"){

					$imgname = rand().time();

					$image_name= $imgname.'.'.$extension;

					$newpath= public_path()."/img/".$image_name;

					$copied = copy($_FILES['photo']['tmp_name'], $newpath);

					if (!$copied) 

					{

						return Redirect::to('products');

					}

					else

					{

						$get_photo = $image_name;		

					}

				}	

				else{

					return Redirect::to('products');

				}	

			}

			else{

				$get_photo = "";

			}

			$MiddlemenEntry->first_name       = Input::get('first_name');

			$MiddlemenEntry->reg_no       = Input::get('reg_no');

			$MiddlemenEntry->photo = $get_photo;

			$MiddlemenEntry->mobile_contact       = Input::get('mobile_contact');

			$MiddlemenEntry->email		   = Input::get('email');

			$MiddlemenEntry->address       = Input::get('address');

			$MiddlemenEntry->remarks		   = Input::get('remarks');

			$MiddlemenEntry->updated_by		   = Auth::user()->id;

			date_default_timezone_set('Singapore');

			$date = date('Y-m-d h:i:s', time());

			$MiddlemenEntry->updated_at		   = $date;

			$MiddlemenEntry->save();



			return Redirect::to('company');

		}

	}

	public function edit_middlemen($id)

	{

		$middlemen = MiddlemenEntry::find($id);

		 return View::make('company.edit')

            ->with('middlemen', $middlemen);

	}

	public function view_middlemen($id)

	{

		$middlemen = MiddlemenEntry::find($id);

		 return View::make('company.view')

            ->with('middlemen', $middlemen);

	}

	

	public function delete_middlemen()

	{

		$id = Input::get('id');

		DB::table('middlemen')->where('id','=',$id)->delete();

		return Redirect::to('company');

	}

}

?>