@extends('admin.layouts.index', ['title' => 'Menu', 'page_heading' => 'Edit Menu Item'])

@section('content')
<section class="row">
    <div class="col card px-3 py-3">
        <div class="my-3 p-3 rounded">
            <form method="post" action="{{ route('admin.updateMenu', $menu->id_item) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="nama_item" class="form-label">Nama Item</label>
                    <input type="text" autofocus value="{{ old('nama_item', $menu->nama_item) }}" 
                           name="nama_item" id="nama_item" 
                           placeholder="Masukkan nama item" 
                           class="form-control @error('nama_item') is-invalid @enderror">
                    @error('nama_item')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" 
                                {{ old('kategori_id', $menu->kategori_id) == $c->id ? 'selected' : '' }}>
                                {{ $c->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" value="{{ old('harga', $menu->harga) }}" 
                           name="harga" id="harga" 
                           placeholder="Masukkan harga item" 
                           class="form-control @error('harga') is-invalid @enderror">
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Item</label>
                    @if (!empty($menu->gambar))
                        <input type="hidden" name="oldImage" value="{{ $menu->gambar }}">
                        <img src="{{ asset('gambar-menu/'.$menu->gambar) }}" 
                             class="img-preview img-fluid mb-3 col-sm-5 d-block">
                    @else
                        <img class="img-preview img-fluid mb-3 col-sm-5">
                    @endif
                    <input class="form-control @error('gambar') is-invalid @enderror" 
                           onchange="previewImage()" type="file" id="gambar" name="gambar" 
                           accept="image/png, image/jpg, image/jpeg">
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-danger" href="{{ route('admin.menu') }}">Kembali</a>
            </form>
        </div>
    </div>
</section>

<script>
function previewImage() {
    const image = document.querySelector('#gambar');
    const imgPreview = document.querySelector('.img-preview');

    imgPreview.style.display = 'block';

    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);

    oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
    }
}
</script>
@endsection