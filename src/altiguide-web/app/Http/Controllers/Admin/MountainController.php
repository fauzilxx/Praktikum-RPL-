<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use App\Http\Requests\Admin\MountainRequest;
use App\Services\Admin\MountainService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MountainController extends Controller
{
    private MountainService $mountainService;

    public function __construct(MountainService $mountainService)
    {
        $this->mountainService = $mountainService;
    }

    /**
     * Tampilkan daftar Gunung (Read - List)
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $mountains = Mountain::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('location', 'like', "%{$search}%");
            })
            ->with('createdBy:id,name') // Cukup ambil nama admin
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Mountains/Index', [
            'mountains' => $mountains,
            'filters'   => ['search' => $search]
        ]);
    }

    /**
     * Halaman form tambah Gunung (Create)
     */
    public function create()
    {
        return Inertia::render('Admin/Mountains/Create');
    }

    /**
     * Logika Simpan Gunung ke DB (Store)
     */
    public function store(MountainRequest $request)
    {
        $this->mountainService->createMountain(
            $request->validated(),
            $request->file('image'), // otomatis null jika tidak upload
            auth('admin')->id() // Ambil Auth ID Admin dari guard 'admin'
        );

        return redirect()->route('admin.mountains.index')->with('status', 'Data gunung berhasil ditambahkan.');
    }

    /**
     * Halaman Detail Gunung (Read - Detail)
     */
    public function show(Mountain $mountain)
    {
        $mountain->load('routes'); // Load relasi rute
        
        return Inertia::render('Admin/Mountains/Show', [
            'mountain' => $mountain
        ]);
    }

    /**
     * Halaman form edit Gunung (Update)
     */
    public function edit(Mountain $mountain)
    {
        return Inertia::render('Admin/Mountains/Edit', [
            'mountain' => $mountain
        ]);
    }

    /**
     * Logika update Gunung (Update)
     */
    public function update(MountainRequest $request, Mountain $mountain)
    {
        $this->mountainService->updateMountain(
            $mountain,
            $request->validated(),
            $request->file('image')
        );

        return redirect()->route('admin.mountains.index')->with('status', 'Data gunung berhasil diperbarui.');
    }

    /**
     * Logika hapus Gunung (Delete)
     */
    public function destroy(Mountain $mountain)
    {
        $this->mountainService->deleteMountain($mountain);

        return redirect()->route('admin.mountains.index')->with('status', 'Data gunung berhasil dihapus.');
    }
}
