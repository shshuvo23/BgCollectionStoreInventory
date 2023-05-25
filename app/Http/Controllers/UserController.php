<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Order;
use App\Models\Style;
use App\Models\Receiver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function superAdminDashboard()
    {
        // return "Hello";
        $styles =  Style::count();
        $buyers = Buyer::count();
        $orders = Order::count();
        $receivers = Receiver::count();
        return view('users.dashboard', [
            'page_title' => 'Admin Dashboard',
            'page_message' => 'Store Management Application',
            'styles'=>$styles,
            'buyers'=>$buyers,
            'orders'=>$orders,
            'receivers'=>$receivers,
        ]);
    }

    public function index()
    {
        $users = User::leftJoin('roles', 'users.role_id', '=', 'roles.role_id')
            ->get(['users.id', 'users.name', 'users.email', 'roles.role_name', 'users.deleted_at', 'users.role_id']);
        $trashed_users = User::onlyTrashed()->count();
        //   return $trashed_users;
        $page_title = "User List";
        $page_message = "View all users";
        return view('users.index', compact('users', 'page_title', 'page_message', 'trashed_users'));
    }

    public function create()
    {
        $roles = Role::get();
        return view('users.create', compact('roles'));
    }
    public function store(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $role_id = $request->role_id;
        $password = $request->password;

        $request->validate([
            'name' => 'required',
            'email'     => 'required|email|unique:users',
            'role_id' => 'required|numeric',
            'password' => 'required|min:6',
        ]);
        $user  = new User;
        $user->name = $name;
        $user->email = $email;
        $user->role_id = $role_id;
        $user->password = Hash::make($password);
        $user->save();
        return back()->with('success', 'User create success');
    }

    public function roleCreate()
    {
        return view('users.role_create');
    }

    public function roleStore(Request $request)
    {
       $role_id = $request->role_id;
       $role_name = $request->role_name;

       $role = new Role();
       $role->role_id = $role_id;
       $role->role_name = $role_name;
       $role->save();
       return back()->with('success', 'Role create successfully');
    }

    public function rolelist(){
        $roles = Role::all();
        return view('users.rolelist', compact('roles'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::get();
        $page_title = "Update User";
        return view('users.edit', compact('user', 'roles', 'page_title'));
    }

    public function update(Request $request, $id)
    {
        $name = $request->name;
        $email = $request->email;
        $role_id = $request->role_id;
        $password = $request->password;

        $request->validate([
            'name' => 'required',
            'email'     => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required|numeric',
        ]);
        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;
        $user->role_id = $role_id;
        if ($password) {
            $user->password = Hash::make($password);
        }
        $user->update();
        return redirect()->route('users')->with('success', 'User update success');
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users')->with('success', 'User delete success');
    }

    public function restore($id)
    {
        User::where('id', $id)->withTrashed()->restore();
        return redirect()->route('users')->with('success', 'User restore success');
    }
    public function trashedUser()
    {
        $page_title = "Trashed User List";
        $page_message = "View all trashed users";
        $trashed_users = User::onlyTrashed()->get();
        return view('users.trashed', compact('trashed_users', 'page_title', 'page_message'));
    }
    public function parmanentlyDelete(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);
        $user->forceDelete();
        return redirect()->route('trashed_users')->with('success', 'User restore success');
    }

    public function changePasswordForm()
    {
        $page_title = 'Change password';
        $page_message = 'Change your password to fill up the form';
        return view('auth.passwords.change',compact('page_title','page_message'));
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|alpha_num|min:8',
            'password_confirmation' => 'required',
        ]);
        $request->validate([
            'password' => 'confirmed',
        ]);
        if ($request->current_password == $request->password) {
            return back()->withErrors(['current_password' => "Current password and New Password can't be same!"]);
        }
        // check password Matched or not
        $value = $request->current_password;
        $hashedValue = auth()->user()->password;
        if (!Hash::check($value, $hashedValue)) {
            return back()->withErrors(['current_password' => "Your Current password is wrong!"]);
        }
        User::find(auth()->id())->update(
            ['password' => bcrypt($request->password)]
        );
        return  back()->with('success', 'password changed successfully');
    }
}
