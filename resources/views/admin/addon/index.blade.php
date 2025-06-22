@extends('admin.layouts.index', ['title' => 'Add-ons', 'page_heading' => 'Kelola Add-ons'])

@section('content')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            
            @include('sweetalert::alert')
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Daftar Add-ons</h5>
                <a href="{{ route('admin.createAddon') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Add-on
                </a>
            </div>

            @if($addons->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Nama Add-on</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ditambahkan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addons as $addon)
                                <tr>
                                    <td>
                                        <strong>{{ $addon->nama_addon }}</strong>
                                        @if($addon->deskripsi)
                                            <br><small class="text-muted">{{ Str::limit($addon->deskripsi, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold">Rp {{ number_format($addon->harga_addon, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        @if($addon->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $addon->created_at->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.showAddon', $addon) }}" 
                                               class="btn btn-sm btn-outline-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.editAddon', $addon) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.destroyAddon', $addon) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus add-on ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $addons->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-plus-square text-muted" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-muted">Belum ada add-on</h5>
                    <p class="text-muted">Mulai tambahkan add-on untuk menu pancong</p>
                    <a href="{{ route('admin.createAddon') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Add-on Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection