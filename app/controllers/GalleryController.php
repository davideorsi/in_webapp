<?php
use Illuminate\Support\MessageBag;

class GalleryController extends BaseController {



  public function show($id)
  {
    $Event = Evento::find($id);
    $dir = storage_path().'/images/gallery/'.$id.'/';
    $list = scandir($dir);
    $Pics = Array();
      if ($list!=null){
      	foreach ($list as $file){
          $ext = 'jpg';
          if (substr_compare(strtolower($file), $ext, -strlen($ext)) === 0){
            array_push($Pics, $file);
          }
        }
      }
    return View::make('frontpage.gallery')
      ->with('Evento', $Event)
      ->with('Pics',$Pics);
  }



}
