@extends('layouts.app')

@section('title', 'Login - POS')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-5 col-lg-4">

        <div class="card shadow-sm border-0 rounded-3">
            
            {{-- Header Form --}}
            <div class="card-header bg-primary text-white text-center py-3">
                <h5 class="mb-0 fw-bold">Login POS</h5>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('auth') }}" method="POST">
                    @csrf

                    {{-- Field Email --}}
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label text-secondary fw-semibold">Email address</label>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="exampleInputEmail1" 
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Field Password --}}
                    <div class="mb-4">
                        <label for="exampleInputPassword1" class="form-label text-secondary fw-semibold">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="exampleInputPassword1"
                            placeholder="••••••••"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Tombol Submit --}}
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                        Submit
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection