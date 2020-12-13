<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profiles;

class ProfileController extends Controller

{
    public function add()
 {
    return view('admin.profile.create');
 }

    public function create(Request $request)
 {

      // Varidationを行う
      $this->validate($request, Profiles::$rules);

      $news = new Profiles;
      $form = $request->all();


      // データベースに保存する
      $news->fill($form);
      $news->save();


      return redirect('admin/profile/create');
 }

    // 以下を追記
    public function index(Request $request)
 {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Profiles::where('name', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = Profiles::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
 }


    public function edit()
 {
    return view('admin.profile.edit');
 }

    public function update()
 {
    return redirect('admin/profile/edit');
 }

}
