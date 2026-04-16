<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class FrontendController extends Controller
{
    public function home(): View
    {
        return view('pages.home');
    }

    public function login(): View
    {
        return view('pages.login');
    }

    public function register(): View
    {
        return view('pages.register');
    }

    public function dashboard(): View
    {
        return view('pages.dashboard');
    }

    public function createBlog(): View
    {
        return view('pages.create-blog');
    }

    public function editBlog(int $blog): View
    {
        return view('pages.edit-blog', ['blogId' => $blog]);
    }

    public function blogDetail(string $slug): View
    {
        return view('pages.blog-detail', ['slug' => $slug]);
    }

    public function profile(int $user): View
    {
        return view('pages.profile', ['userId' => $user]);
    }
}
