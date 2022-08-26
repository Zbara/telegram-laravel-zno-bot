@extends('layouts.app')
@section('header')
    Авторизация
@endsection
@section('content')

    <div class="container-tight py-4">
        <form class="card card-md" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Авторизация</h2>
                <div class="mb-3">
                    <input class="form-control placeholder-no-fix @error('email') is-invalid @enderror"  type="text" value="{{ old('email') }}"
                           autocomplete="off" placeholder="E-mail" name="email"/>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="mb-2">
                    <div class="input-group input-group-flat">
                        <input class="form-control placeholder-no-fix @error('password') is-invalid @enderror" type="password" autocomplete="off"
                               placeholder="Пароль"
                               name="password"/>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Войти</button>
                </div>
            </div>
        </form>
    </div>
@endsection
