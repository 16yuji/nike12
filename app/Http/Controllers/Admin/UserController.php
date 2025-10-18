<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $users = User::when($q, fn($qr)=>
            $qr->where('name','like',"%$q%")
               ->orWhere('email','like',"%$q%")
        )->latest('id')->paginate(12)->withQueryString();

        return view('admin.users.index', compact('users','q'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:255'],
            'email' => ['required','email', Rule::unique('users','email')],
            'password' => ['required','string','min:6'],
            'role'  => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_CUSTOMER])],
        ]);
        $data['password'] = Hash::make($data['password']);

        User::create($data);
        return redirect()->route('admin.users.index')->with('ok','Đã tạo người dùng.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => ['required','string','max:255'],
            'email' => ['required','email', Rule::unique('users','email')->ignore($user->id)],
            'password' => ['nullable','string','min:6'],
            'role'  => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_CUSTOMER])],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Không cho admin tự hạ vai trò chính mình (tuỳ chọn)
        if (auth()->id() === $user->id && $user->role === User::ROLE_ADMIN && $data['role'] !== User::ROLE_ADMIN) {
            return back()->withErrors(['role' => 'Không thể hạ quyền admin của chính bạn.']);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('ok','Đã cập nhật người dùng.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->withErrors(['user' => 'Không thể tự xóa chính mình.']);
        }
        $user->delete();
        return back()->with('ok','Đã xóa người dùng.');
    }
}
