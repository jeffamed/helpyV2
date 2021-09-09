<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\HowWork;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::all();
        $services = Service::all();
        $departments = Department::inRandomOrder()->limit(6)->get();
        $works = HowWork::latest()->limit(3)->get();

        return view('welcome', compact('testimonials','services','departments','works'));
    }

    public function aboutusPage()
    {
        return view('aboutus');
    }
}
