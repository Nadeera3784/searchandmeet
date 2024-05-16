<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Article;
use App\Models\PurchaseRequirement;
use App\Repositories\Meeting\MeetingRepositoryInterface;
use Faker\Factory;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function dashboard(MeetingRepositoryInterface $meetingRepository)
    {
        $orders = auth('person')->user()->orders;
        $meetings = $meetingRepository->getAll(auth('person')->user(), true);

        $purchase_requirements = auth('person')->user()->purchase_requirements;
        return view('dashboard.index', get_defined_vars());
    }

    public function home()
    {
        $categories = Category::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        $purchaserequirements = PurchaseRequirement::with('category', 'metric')->take(6)->get();
        $faker = Factory::create();
        $articles = Article::orderBy('date')->limit(10)->get();

        return view('welcome', get_defined_vars());
    }
}
