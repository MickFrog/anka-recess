<?php

namespace App\Http\Controllers;

use App\Charts\AnkaChart;
use App\Models\Booking;
use App\Models\Participant;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $productQuantityChart = new AnkaChart;
        $participantPointsChart = new AnkaChart;

        $productsChart = Product::pluck('quantity', 'name');
        $participantsChart = Participant::pluck('points', 'name');

        Log::info($participantsChart);
        $productQuantityChart->labels($productsChart->keys());
        $productQuantityChart->dataset('Product against Quantity', 'bar', $productsChart->values())->options([
            'backgroundColor' => 'green'
        ]);

        $participantPointsChart->labels($participantsChart->keys());
        $participantPointsChart->dataset('Participant againts Points', 'bar', $participantsChart->values())->options([
            'backgroundColor' => 'purple'
        ]);

        $participants = Participant::all();
        $totalProducts = Product::all()->count();
        $totalBookings = Booking::all()->count();
        $topParticipant = Participant::orderBy('points', 'desc')->first();
        return view('dashboard', [
            'participants' => $participants, 'totalParticipants' => $participants->count(),
            'totalProducts' => $totalProducts, 'totalBookings' => $totalBookings,
            'topParticipant' => $topParticipant, 'productQuantityChart' => $productQuantityChart,
            'participantPointsChart' => $participantPointsChart
        ]);
    }

    public function table()
    {
        $participants = Participant::all();
        $products = Product::all();
        return view('pages.table_list', ['participants' => $participants, 'products' => $products]);
    }

    public function products()
    {
        return view('pages.products');
    }
}
