<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ModuleA6CController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getPhoto(Request $request,$imagename)
	{
		
	$dir = 'Modules/A6C';
$files = scandir($dir);
for($i = 2; $i < count($files); $i++)
    print $files[$i]."<br>";
		
	  //$dstpath=realpath(base_path('/')).'\Public\Modules\A6C\\';
	//  $dstpath='Public\Modules\A6C';
       //echo $dstpath.$imagename;
     //   if(file_exists($dstpath.$imagename.'.jpg'))
		 // if(file_exists('Public\Modules\A6C\\'.$imagename.'.jpg'))
    //        return redirect('/Modules/A6C/'.$imagename.'.jpg');
    ////    else
        //   return redirect('/Modules/A6C/'.'null.jpg');
     
    }

 public function postPhoto(Request $request,$imagename)
 {
     $photoFile = $request->file('photo');
     $dstpath=realpath(base_path('/')).'\Public\Modules\A6C';
     //echo "welcome postphoto<br>";
     //echo  $request->input('name');
     //echo  $photoFile;
	 
     if($request->hasFile("photo"))
     {
         //echo '<br>has photo file';
         //echo  $photoFile->getPathname();
         //echo '<br>';
        // echo  $photoFile->getFilename();
        // echo '<br>';
        // echo $request->input("filename").'<br>';
         echo 'Save   '.$imagename.'.jpg  OK!'.'<br>';

         // $photoFile->move($dstpath, $imagename.'.jpg');
		$photoFile->move('Public\Modules\A6C', $imagename.'.jpg');
		File::put('Public/Modules/A6C/mytextdocument.txt','John Doe');
     }
     else
         echo '<br>no photo file';
 }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
