<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use App\User;

class HomeController extends Controller
{
    /**
     * Edit profile
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        return view('home', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
        $data = $request->All();

        if (empty($request->input('password'))) {
            $data = $request->except(['password']);
        } else {
            $data['password'] = Hash::make($request->password);
        }

        $data['photo'] = $this->uploadFile($request);

        User::find($id)->update($data);
        return redirect()->route('home/index')
            ->with('success','Profile updated successfully');
    }

    /**
     * Upload photo
     *
     * @param UserRequest $request
     * @return string
     */
    private function uploadFile(UserRequest $request){
        $file = $request->file('photo');

        if ($file) {
            $name = md5(microtime() . rand(0, 9999)).'_'.$file->getClientOriginalName();
            $file->move('upload', $name);
            return $name;
        }

        return '';
    }
}
