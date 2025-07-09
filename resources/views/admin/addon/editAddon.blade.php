@extends('admin.layouts.index', ['title' => 'Add-ons', 'page_heading' => 'Edit Add-on'])

@section('content')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            <form method="post" action="{{ route('admin.updateAddon', $addon) }}">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="nama_addon" class="form-label">Nama Add-on <span class="text-danger">*</span></label>
                            <input type="text" autofocus value="{{ old('nama_addon', $addon->nama_addon) }}" 
                                   name="nama_addon" id="nama_addon" 
                                   placeholder="Masukkan nama add-on (cth: Extra Keju, Coklat Nutella)" 
                                   class="form-control @error('nama_addon') is-invalid @enderror">
                            @error('nama_addon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga_addon" class="form-label">Harga Add-on <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" value="{{ old('harga_addon', $addon->harga_addon) }}" 
                                       name="harga_addon" id="harga_addon" 
                                       placeholder="0" min="0" step="500"
                                       class="form-control @error('harga_addon') is-invalid @enderror">
                            </div>
                            @error('harga_addon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" 
                                      placeholder="Deskripsi singkat tentang add-on ini (opsional)" 
                                      class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $addon->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" 
                                       id="is_active" name="is_active" 
                                       {{ old('is_active', $addon->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <strong>Aktifkan Add-on</strong>
                                    <br><small class="text-muted">Add-on yang aktif akan ditampilkan di menu "Bikin Sendiri"</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bi bi-info-circle me-1"></i>Info Add-on</h6>
                            </div>
                            <div class="card-body">
                                <p class="small mb-2">
                                    <i class="bi bi-tag text-primary me-1"></i>
                                    <strong>ID:</strong> {{ $addon->id }}
                                </p>
                                <p class="small mb-2">
                                    <i class="bi bi-calendar text-primary me-1"></i>
                                    <strong>Dibuat:</strong> {{ $addon->created_at->format('d M Y') }}
                                </p>
                                <p class="small mb-0">
                                    <i class="bi bi-clock text-primary me-1"></i>
                                    <strong>Update:</strong> {{ $addon->updated_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>

                        @if($addon->is_active)
                            <div class="alert alert-success mt-3" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                <small>Add-on ini sedang <strong>aktif</strong></small>
                            </div>
                        @else
                            <div class="alert alert-warning mt-3" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <small>Add-on ini sedang <strong>nonaktif</strong></small>
                            </div>
                        @endif
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Update Add-on
                            </button>
                            <a href="{{ route('admin.showAddon', $addon) }}" class="btn btn-info">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </a>
                            <a href="{{ route('admin.addon') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.getElementById('harga_addon').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^\d]/g, '');
    e.target.value = value;
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('nama_addon').focus();
});
</script>
@endsection