<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Obat::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $medicines = $query->orderBy('nama_obat', 'asc')->paginate(10);
        
        $total_obat = Obat::count();
        $total_kategori = Obat::distinct('category')->count('category');
        $search_count = $request->has('search') ? $medicines->total() : $total_obat;

        return view('medicines.index', compact('medicines', 'total_obat', 'total_kategori', 'search_count'));
    }

    public function create()
    {
        return view('medicines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100',
            'dosis' => 'required|string|max:50',
            'satuan' => 'required|string|max:20',
            'category' => 'required|string|max:50',
        ]);

        Obat::create($request->all());

        return redirect()->route('medicines.index')->with('success', 'Data obat berhasil ditambahkan');
    }

    public function edit($id)
    {
        $medicine = Obat::findOrFail($id);
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:100',
            'dosis' => 'required|string|max:50',
            'satuan' => 'required|string|max:20',
            'category' => 'required|string|max:50',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update($request->all());

        return redirect()->route('medicines.index')->with('success', 'Data obat berhasil diperbarui');
    }

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        
        // Check if used in batches
        if ($obat->batches()->exists()) {
            return back()->with('error', 'Obat tidak dapat dihapus karena masih memiliki stok batch.');
        }

        $obat->delete();

        return redirect()->route('medicines.index')->with('success', 'Data obat berhasil dihapus');
    }
}
