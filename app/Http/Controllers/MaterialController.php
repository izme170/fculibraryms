<?php

namespace App\Http\Controllers;

use App\Exports\MaterialsExport;
use App\Models\Activity;
use App\Models\Author;
use App\Models\Material;
use App\Models\BorrowedMaterial;
use App\Models\Category;
use App\Models\MaterialType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the status, category, and search query parameters from the request
        $status = $request->query('status', 'all');
        $category = $request->query('category', 'all');
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'title');
        $direction = $request->query('direction', 'asc');

        // Create the query to get materials
        $query = Material::with(['category', 'authors', 'editors', 'illustrators', 'subjects', 'translators', 'materialCopies'])
            ->where('is_archived', '=', false);

        //Filter the material if it has one copy available, borrowed, or overdue
        if ($status !== 'all') {
            $query->where(function ($query) use ($status) {
                if ($status === 'available') {
                    $query->whereHas('materialCopies', function ($subQuery) {
                        $subQuery->where('is_available', true);
                    });
                } elseif ($status === 'borrowed') {
                    $query->whereHas('materialCopies', function ($subQuery) {
                        $subQuery->where('is_available', false)->whereHas('borrowedCopies', function ($subQuery) {
                            $subQuery->where('due_date', '>=', now())
                                ->whereNull('returned');
                        });
                    });
                } elseif ($status === 'overdue') {
                    $query->whereHas('materialCopies', function ($subQuery) {
                        $subQuery->where('is_available', false)->whereHas('borrowedCopies', function ($subQuery) {
                            $subQuery->where('due_date', '<', now())
                                ->whereNull('returned');
                        });
                    });
                }
            });
        }


        // Apply the status filter if set
        // if ($status !== 'all') {
        //     $query->where(function ($query) use ($status) {
        //         if ($status === 'available') {
        //             $query->where('is_available', true);
        //         } elseif ($status === 'borrowed') {
        //             $query->where('is_available', false)->whereHas('borrowedMaterials', function ($subQuery) use ($status) {
        //                 $subQuery->where('due_date', '>=', now())
        //                     ->whereNull('returned');
        //             });
        //         } elseif ($status === 'overdue') {
        //             $query->where('is_available', false)->whereHas('borrowedMaterials', function ($subQuery) use ($status) {
        //                 $subQuery->where('due_date', '<', now())
        //                     ->whereNull('returned');;
        //             });
        //         }
        //     });
        // }

        // Apply the category filter if set
        if ($category !== 'all') {
            $query->where('category_id', $category);
        }

        // Apply the search filter if set
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('materials.title', 'like', "%{$search}%")
                    ->orWhereHas('authors', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Get the materials with pagination
        $materials = $query->orderBy($sort, $direction)->paginate(15)->appends([
            'status' => $status,
            'category' => $category,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction
        ]);

        // Get all categories for the filter dropdown
        $categories = Category::orderBy('category')->get();

        // Get all borrowed materials
        $borrowed_materials = BorrowedMaterial::all()->keyBy('material_id');

        // Compute status for each material
        $materials->each(function ($material) use ($borrowed_materials) {
            // Check if the material is available
            if ($material->is_available) {
                $material->status = 'available';
            } else {
                // Find if the material is borrowed and check the status
                $borrowed_material = $borrowed_materials->get($material->material_id);

                // Check if the material is borrowed and returned
                if ($borrowed_material && $borrowed_material->returned) {
                    $material->status = 'borrowed';
                } else {
                    // Check if it's overdue or just borrowed
                    $dueDate = $borrowed_material ? Carbon::parse($borrowed_material->due_date) : null;
                    $material->status = $dueDate && Carbon::now()->gt($dueDate) ? 'overdue' : 'borrowed';
                }
            }
        });

        return view('materials.index', compact('materials', 'categories', 'status', 'category', 'search', 'sort', 'direction'));
    }




    public function create()
    {
        $material_types = MaterialType::all();
        $categories = Category::where('show_in_forms', true)->get();

        return view('materials.create', compact('categories', 'material_types'));
    }

    public function store(Request $request)
    {
        $request['authors'] = json_decode($request['authors'], true);
        $validated = $request->validate([
            'isbn' => ['nullable'],
            'issn' => ['nullable'],
            'title' => ['required'],
            'authors' => ['required', 'array'],
            'authors.*' => ['required', 'string'],
            'type_id' => ['required'],
            'publisher_id' => ['nullable'],
            'publication_year' => ['nullable'],
            'edition' => ['nullable'],
            'volume' => ['nullable'],
            'pages' => ['nullable', 'integer'],
            'size' => ['nullable'],
            'includes' => ['nullable'],
            'references' => ['nullable'],
            'bibliography' => ['nullable'],
            'description' => ['nullable'],
            'category_id' => ['nullable'],
            'material_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);


        if ($request->hasFile('material_image')) {
            $file = $request->file('material_image');

            // Generate a unique filename
            $filenameToStore = uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the file
            $path = $file->storeAs('img/materials', $filenameToStore, 'public');

            if ($path) {
                $validated['material_image'] = str_replace('public/', '', $path); // Save relative path
            } else {
                return back()->withErrors(['material_image' => 'Failed to upload the image.']);
            }
        }

        $material = Material::create($validated);

        // Save authors
        foreach ($validated['authors'] as $authorName) {
            $author = Author::firstOrCreate(['name' => $authorName]);
            $material->authors()->attach($author->author_id);
        }

        // Record Activity
        $data = [
            'action' => 'added a new material.',
            'material_id' => $material->material_id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/materials');
    }

    private $finePerHour = 5;

    public function show($id)
    {
        $material = Material::with('category')
            ->where('materials.material_id', $id)
            ->first();
        $categories = Category::all();
        // $borrowed_material = BorrowedMaterial::all()->keyBy('material_id')->get($material->material_id);

        // // This code will Assign the material's status
        // if ($material->is_available) {
        //     $material->status = 'available';
        // } else {

        //     // Check if the material is borrowed and returned
        //     if ($borrowed_material && $borrowed_material->returned) {
        //         $material->status = 'borrowed';
        //     } else {
        //         // Check if it's overdue or just borrowed
        //         $dueDate = $borrowed_material ? Carbon::parse($borrowed_material->due_date) : null;
        //         $material->status = $dueDate && Carbon::now()->gt($dueDate) ? 'overdue' : 'borrowed';
        //     }
        // }

        // $previous_borrowers = BorrowedMaterial::with(['patron'])
        //     ->where('material_id', $id)
        //     ->get();

        // $previous_borrowers->each(function ($borrowed_material) {

        //     //Checks if the material is returned
        //     if (!$borrowed_material->returned) {
        //         $dueDate = Carbon::parse($borrowed_material->due_date);
        //         $now = Carbon::now();

        //         //Check if the material is overdue
        //         if ($now->gt($dueDate)) {
        //             $hoursOverdue = $dueDate->diffInHours($now, false);
        //             $borrowed_material->fine = $this->finePerHour * (int)$hoursOverdue;
        //         } else {
        //             $borrowed_material->fine = 0;
        //         }
        //     }
        // });

        // return view('materials.show', compact('material', 'categories', 'previous_borrowers'));
        return view('materials.show', compact('material', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'author' => ['required', 'array'],
            'author.*' => ['required', 'string'],
            'category_id' => ['required'],
            // 'material_rfid' => ['required'],
            'material_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);

        $material = Material::findOrFail($id);

        if ($request->hasFile('material_image')) {
            $file = $request->file('material_image');

            // Generate a unique filename
            $filenameToStore = uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the file
            $path = $file->storeAs('img/materials', $filenameToStore, 'public');

            if ($path) {
                $validated['material_image'] = str_replace('public/', '', $path); // Save relative path
            } else {
                return back()->withErrors(['material_image' => 'Failed to upload the image.']);
            }
        }

        $material->update($validated);

        // Sync authors
        $authorIds = [];
        foreach ($validated['author'] as $authorName) {
            $author = Author::firstOrCreate(['name' => $authorName]);
            $authorIds[] = $author->author_id;
        }
        $material->authors()->sync($authorIds);

        // Record Activity
        $data = [
            'action' => 'updated a material.',
            'material_id' => $material->material_id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect()->back()->with('message_success', 'Material has been updated.');
    }

    public function updateImage(Request $request, $id)
    {
        $validated = $request->validate([
            'material_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);

        $material = Material::find($id);

        if ($request->hasFile('material_image')) {
            $file = $request->file('material_image');

            // Generate a unique filename
            $filenameToStore = uniqid() . '.' . $file->getClientOriginalExtension();

            // Store the file
            $path = $file->storeAs('img/materials', $filenameToStore, 'public');

            // Delete the old image if it exists
            if ($material->material_image) {
                $oldImagePath = public_path('storage/' . $material->material_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            if ($path) {
                $material->material_image = str_replace('public/', '', $path); // Save relative path
                $material->save();
            } else {
                return back()->withErrors(['material_image' => 'Failed to upload the image.']);
            }
        }

        // Record Activity
        $data = [
            'action' => 'updated the image of a material.',
            'material_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect()->back()->with('message_success', 'Material image has been updated.');
    }

    public function archive($id)
    {
        Material::find($id)->update(['is_archived' => true]);

        // Record Activity
        $data = [
            'action' => 'archived a material.',
            'material_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect('/materials');
    }

    public function newRFID(Request $request, $id)
    {
        $validated = $request->validate([
            'material_rfid' => 'required|unique:materials,material_rfid'
        ]);

        // Record Activity
        $data = [
            'action' => 'assigned new RFID to a material.',
            'material_id' => $id,
            'initiator_id' => Auth::id()
        ];
        Activity::create($data);

        return redirect()->back()->with('message_success', 'New RFID successfully assigned to the material.');
    }

    public function export()
    {
        return Excel::download(new MaterialsExport, 'materials-library-management-system' . now() . '.xlsx');
    }
}
