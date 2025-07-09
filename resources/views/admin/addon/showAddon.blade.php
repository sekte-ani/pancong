@extends('admin.layouts.index', ['title' => 'Add-ons', 'page_heading' => 'Detail Add-on'])

@section('content')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            <div class="row">
                <div class="col-md-8">
                    <h3>{{ $addon->nama_addon }}</h3>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td width="200"><strong>Nama Add-on:</strong></td>
                            <td>{{ $addon->nama_addon }}</td>
                        </tr>
                        <tr>
                            <td><strong>Harga:</strong></td>
                            <td>
                                <span class="fw-bold text-success">Rp {{ number_format($addon->harga_addon, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($addon->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Deskripsi:</strong></td>
                            <td>
                                @if($addon->deskripsi)
                                    {{ $addon->deskripsi }}
                                @else
                                    <span class="text-muted">Tidak ada deskripsi</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Ditambahkan:</strong></td>
                            <td>{{ $addon->created_at->format('d F Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Terakhir Update:</strong></td>
                            <td>{{ $addon->updated_at->format('d F Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-info-circle me-1"></i>Informasi Add-on</h6>
                        </div>
                        <div class="card-body">
                            <p class="small mb-2">
                                <i class="bi bi-tag text-primary me-1"></i>
                                <strong>ID:</strong> {{ $addon->id }}
                            </p>
                            <p class="small mb-2">
                                <i class="bi bi-calendar text-primary me-1"></i>
                                <strong>Dibuat:</strong> {{ $addon->created_at->diffForHumans() }}
                            </p>
                            <p class="small mb-0">
                                <i class="bi bi-clock text-primary me-1"></i>
                                <strong>Update:</strong> {{ $addon->updated_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    @if($addon->is_active)
                        <div class="alert alert-success mt-3" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            Add-on ini <strong>aktif</strong> dan ditampilkan di menu "Bikin Sendiri"
                        </div>
                    @else
                        <div class="alert alert-warning mt-3" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Add-on ini <strong>nonaktif</strong> dan tidak ditampilkan di menu
                        </div>
                    @endif
                </div>
            </div>

            <hr class="my-4">

            <div class="row">
                <div class="col-12">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.editAddon', $addon) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square me-1"></i>Edit Add-on
                        </a>
                        
                        @if($addon->is_active)
                            <form action="{{ route('admin.updateAddon', $addon) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="nama_addon" value="{{ $addon->nama_addon }}">
                                <input type="hidden" name="harga_addon" value="{{ $addon->harga_addon }}">
                                <input type="hidden" name="deskripsi" value="{{ $addon->deskripsi }}">
                                <button type="submit" class="btn btn-secondary"
                                        onclick="return confirm('Nonaktifkan add-on ini?')">
                                    <i class="bi bi-eye-slash me-1"></i>Nonaktifkan
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.updateAddon', $addon) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="nama_addon" value="{{ $addon->nama_addon }}">
                                <input type="hidden" name="harga_addon" value="{{ $addon->harga_addon }}">
                                <input type="hidden" name="deskripsi" value="{{ $addon->deskripsi }}">
                                <input type="hidden" name="is_active" value="1">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-eye me-1"></i>Aktifkan
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.destroyAddon', $addon) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus add-on ini? Tindakan ini tidak dapat dibatalkan!')">
                                <i class="bi bi-trash me-1"></i>Hapus
                            </button>
                        </form>

                        <a href="{{ route('admin.addon') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection