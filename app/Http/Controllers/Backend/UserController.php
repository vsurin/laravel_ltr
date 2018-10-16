<?php

namespace App\Http\Controllers\Backend;

use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();

        return view('backend.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $user = new User;

        return view('backend.user.create', compact('user'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['photo'] = $this->uploadFile($request);
        $data['password'] = Hash::make($request->password);

        User::create($data);

        return redirect()->route('users.index')
            ->with('success','Users created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('backend.user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('backend.user.edit', compact('user'));
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
        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
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