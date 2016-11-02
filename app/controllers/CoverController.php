<?php



class CoverController extends BaseController {

/**

* Display a listing of the resource.

*

* @return Response

*/

	protected $layout = "layouts.main";	

	public function index()

	{

		if (Auth::user())

			return Redirect::to('main');	

		else

		{

			return View::make('login');	

			

		}

	}

	public function main()

	{

		$clients = DB::table('clients')->orderBy('created_at', 'desc')->take(5)->get();

		$invoices = DB::table('invoices')->orderBy('date_created', 'desc')->take(5)->get();

		//$this->layout->content = View::make('dashboard')->with('clients',$clients)->with('invoices',$invoices);


		/*$table = Datatable::table()

		  ->addColumn('Company','Product Code', 'Product Name', 'Cost Price', ' Selling Price','Quantity','Actions')

		  ->setUrl(route('api.products'))

		  ->noScript();	*/

		$products = DB::table('products')->orderBy('created_at','desc')->get();

		$store = DB::table('store')->orderBy('created_at','desc')->get();

		//$this->layout->content = View::make('dashboard', array('table' => $table, 'store' => $store));

		$this->layout->content =  View::make('dashboard')->with('products',$products)->with('store',$store);


	}

	public function showlogin()

	{

		return View::make('login');	

	}

	public function authent()

	{

		$rules = array(

			'email'     => 'required',

			'password'      => 'required',

		);

		$validator = Validator::make(Input::all(), $rules);



		if ($validator->fails()) {

			return Redirect::to('/')

				->withErrors($validator);

		} else {

			$email = Input::get('email');

			$pwd = Input::get('password');

			$count = DB::table('users')

	                     ->where('email',$email)

	                     ->count();

			if ($count > 0)

			{

				$hashedPassword = DB::table('users')->where('email', $email)->first();

				$ID = DB::table('users')->where('email',$email)->pluck('id');

				$firstName = DB::table('users')->where('email',$email)->pluck('first_name');

				$lastName = DB::table('users')->where('email',$email)->pluck('last_name');

				

				if (Auth::attempt(array('email' => $email, 'password' => $pwd),true))

				{

					

					if (Auth::check())	

					{	

						return Redirect::to('/main');

					}

				}

				else

				{

					return Redirect::to('/')->withErrors(['Wrong Email or Password!']);

				}

				

			}

			else{

				return Redirect::to('/')->withErrors(['Wrong Email or Password!']);

			}

		}

	}

	public function logOut()

	{

		Auth::logout();

		return Redirect::to('/');

	}

	public function register()

	{

		$view = View::make('registration');

		return $view;

	}

	public function login()

	{

		$view = View::make('login');

		return $view;

	}

	public function attemptLogin()

	{

		$email = Input::get('email');

		$pwd = Input::get('password');

		$count = DB::table('user')

                     ->where('UserEmail',$email)

                     ->count();

					 

		

		if ($count > 0)

		{

			$hashedPassword = DB::table('user')->where('UserEmail', $email)->first();

			$ID = DB::table('user')->where('UserEmail',$email)->pluck('id');

			$firstName = DB::table('user')->where('UserEmail',$email)->pluck('FirstName');

			$lastName = DB::table('user')->where('UserEmail',$email)->pluck('LastName');

			if (Auth::attempt(array('UserEmail' => $email, 'password' => $pwd),true))

			{

				if (Auth::check())

				{				

					return Redirect::to('/main');

				}

			}

			else

			{

				return Redirect::to('/')->with('message','Wrong Email or Password!');

			}

			

		}

		else

			$view =  View::make('registration')->with('email',$email)->with('count',$count);

		return $view;

	}

	public function finishregister()

	{

		$rules = array(

				'UserEmail'         => 'required|email|unique:user',

				'Password'      	=> 'required',

				'ConfirmPassword'		=> 'required|same:Password',

				'firstName'         => 'required',

				'lastName'      	=> 'required',

				'address'           => 'required',

				'contact'      		=> 'required',

			);

			$validator = Validator::make(Input::all(), $rules);

	

			if ($validator->fails()) 

			{

				return Redirect::to('/register')

					->withErrors($validator);

			} 

			

			else 

			{

				$email = Input::get('UserEmail');

				$password = Input::get('Password');

				$oldPwd = $password;

				$firstName = Input::get('firstName');

				$lastName = Input::get('lastName');

				$address = Input::get('address');

				$contact = Input::get('contact');

				$password = Hash::make($password);

				date_default_timezone_set('Singapore');

				$timezone = date('Y/m/d H:i:s a', time());

				

				$latestID = DB::table('user')->orderBy('uID', 'desc')->first();

				$numberID = explode("U", $latestID->id);

				$numberID[1] = $numberID[1] + 1;

				$newID = "U";

				$newID = $newID.$numberID[1];

				

				$latestID = DB::table('user')->orderBy('uID', 'desc')->first();

				$newEID = $latestID->EntityID + 1;

				DB::table('user')->insert(array

					('id'=>$newID,'UserEmail' => $email, 'FirstName'=>$firstName,'LastName'=>$lastName,'Address'=>$address,'ContactNumber'=>$contact,'Password' => $password,'DateJoined'=>$timezone,'AC'=>'9856','EntityID'=>$newEID)

				);

				

				DB::table('accesscontrols')->insert(array

					('UserID' => $newID,'EntityID'=>$newEID, 'DateCreated'=>$timezone)

				);

				if (Auth::attempt(array('UserEmail' => $email, 'password' => $oldPwd),true))

					{

						if (Auth::check())		

							return Redirect::to('/main');

						else

							return Redirect::to('/login');

					}

				

							return Redirect::to('/login');

			}

	}

	

}

?>