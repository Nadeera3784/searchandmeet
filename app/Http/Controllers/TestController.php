<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\Communications\ConversationsRepositoryInterface;
use App\Services\Schedule\ScheduleService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    protected $category_array;
    protected $current_id;
    private $scheduleService;
    private $conversationsRepository;

    public function __construct(ScheduleService $scheduleService, ConversationsRepositoryInterface $conversationsRepository)
    {
        $this->category_array  = collect([]);
        $this->current_id      = Category::max('id');
        $this->scheduleService = $scheduleService;
        $this->conversationsRepository = $conversationsRepository;
    }

    public function index(Request $request)
    {
        return view('text.show', get_defined_vars());
    }

    public function test(){

    }
}
