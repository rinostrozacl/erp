<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Auth\UserRepository;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Requests\Backend\Auth\User\UpdateUserPasswordRequest;
use Illuminate\Http\Request;
use Hash;


/**
 * Class UserPasswordController.
 */
class UserPasswordController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     */
    public function edit(ManageUserRequest $request, User $user)
    {
        return view('backend.auth.user.change-password')
            ->withUser($user);
    }

    /**
     * @param UpdateUserPasswordRequest $request
     * @param User                      $user
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function update(Request $request, User $user)
    {
        
       
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);
        $request->user()->fill(['password' => Hash::make($request->password)])->save();
    
        $request->session()->flash('success', 'La contraseña ha sido cambiada.');
       // return back();
        /*
        if(Hash::check($request->old, Auth::user()->password)) {
            //Change the password
           
        }
        else {
            $request->session()->flash('failure', 'Your password has not been changed.');
            return back();
        } 

        //$this->userRepository->updatePassword($user, $request->only('password'));
        //$user->update(['password'=> Hash::make($request->only('password'))]);*/
         
      return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.updated_password'));
    }
}
