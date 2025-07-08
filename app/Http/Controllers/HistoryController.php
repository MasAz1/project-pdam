<?php
namespace App\Http\Controllers;

use App\Models\DeviceUpdateHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
	public function index()
	{
		$histories = DeviceUpdateHistory::with(['device', 'firmware'])
			->latest()
			->paginate(10);

		return view('history.index', compact('histories'));
	}

	public function show(DeviceUpdateHistory $history)
	{
		return view('history.show', compact('history'));
	}
}