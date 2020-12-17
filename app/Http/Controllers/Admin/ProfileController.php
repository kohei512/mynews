<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profiles;

use App\Staff;
use Carbon\Carbon;



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

      $profile = new Profiles;
      $form = $request->all();

      unset($form['_token']);
      // データベースに保存する
      $profile->fill($form);
      $profile->save();


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


    public function edit(Request $request)
 {
     // Profiles Modelからデータを取得する
     $profile = Profiles::find($request->id);
     if (empty($profile)) {
         abort(404);
     }

    return view('admin.profile.edit', ['profile_form' => $profile]);
 }

    public function update(Request $request)
 {
     // Validationをかける
     $this->validate($request, Profiles::$rules);
     //  Modelからデータを取得する
     $profile = Profiles::find($request->input('id'));
     // 送信されてきたフォームデータを格納する
     $profile_form = $request->all();
     unset($profile_form['_token']);

     // 該当するデータを上書きして保存する
     $profile->fill($profile_form)->save();


     $staff = new Staff;
     $staff->profiles_id = $profile->id;
     $staff->edited_at = Carbon::now();
     $staff->save();

     return redirect('admin/profile/');
 }

    // 以下を追記
    public function delete(Request $request)
 {
     // 該当するProfiles Modelを取得
     $profile = Profiles::find($request->id);
     // 削除する
     $profile->delete();
     return redirect('admin/profile/');
 }
}
