@extends('admin.layouts.index', ['title' => 'Add-ons', 'page_heading' => 'Tambah Add-on'])

@section('content')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            <form method="post" action="{{ route('admin.storeAddon') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="nama_addon" class="form-label">Nama Add-on <span class="text-danger">*</span></label>
                            <input type="text" autofocus value="{{ old('nama_addon') }}" 
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
                                <input type="number" value="{{ old('harga_addon') }}" 
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
                                      class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" 
                                       id="is_active" name="is_active" {{ old('is_active') ? 'checked' : 'checked' }}>
                                <label class="form-check-label" for="is_active">
                                    <strong>Aktifkan Add-on</strong>
                                    <br><small class="text-muted">Add-on yang aktif akan ditampilkan di menu "Bikin Sendiri"</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i>Simpan Add-on
                            </button>
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
</script>
@endsection