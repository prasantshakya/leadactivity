<?php
namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    // Display a listing of the budgets
    public function budgetlist()
    {
        $budgets = Budget::all();
        return view('budget.index', compact('budgets'));
    }

    // Show the form for creating a new budget
    public function create()
    {
        return view('budget.create');
    }

    // Store a newly created budget in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
        ]);

        $budget = new Budget();
        $budget->name = $request->name;
        $budget->created_by = auth()->id();
        $budget->save();

        return redirect()->route('budget.list')->with('success', 'Budget created successfully.');
    }

    // Show the form for editing the specified budget
    public function edit($id)
    {
        $budget = Budget::findOrFail($id);
        return view('budget.edit', compact('budget'));
    }

    // Update the specified budget in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
        ]);

        $budget = Budget::findOrFail($id);
        $budget->name = $request->name;
        $budget->save();

        return redirect()->route('budget.list')->with('success', 'Budget updated successfully.');
    }

    // Remove the specified budget from the database
    public function destroy($id)
    {
        $budget = Budget::findOrFail($id);
        $budget->delete();

        return redirect()->route('budget.list')->with('success', 'Budget deleted successfully.');
    }
}
