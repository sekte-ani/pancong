@extends('admin.layouts.index', ['title' => 'Edit User', 'page_heading' => 'Edit User - ' . $user->nama])

@section('content')
<section class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   name="nama" value="{{ old('nama', $user->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                   name="username" value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" 
                                   name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}">
                            @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Customer</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        Kosongkan password jika tidak ingin mengubahnya.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password Baru (Opsional)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection