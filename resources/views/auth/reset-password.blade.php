@extends('layouts.auth')

@section('title', 'Восстановление пароля')

@section('content')
    <main class="md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-20">
        <div class="container">

            @dump($token)

            <x-forms.auth-form title="Восстановление пароля" action="{{ route('password.update') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <x-forms.text-input
                    name="email"
                    type="email"
                    :isError=" $errors->has('email')"
                    placeholder="E-mail"
                    value="{{ request('email') }}"
                    required="true">
                </x-forms.text-input>

                @error('email')
                <x-forms.error>{{ $message }}</x-forms.error>
                @enderror

                <x-forms.text-input
                    name="password"
                    type="password"
                    :isError=" $errors->has('password')"
                    placeholder="Пароль"
                    required="true">
                </x-forms.text-input>

                @error('password')
                <x-forms.error>{{ $message }}</x-forms.error>
                @enderror

                <x-forms.text-input
                    name="password_confirmation"
                    type="password"
                    :isError=" $errors->has('password_confirmation')"
                    placeholder="Повторите пароль"
                    required="true">
                </x-forms.text-input>

                @error('password_confirmation')
                <x-forms.error>{{ $message }}</x-forms.error>
                @enderror

                <x-forms.primary-button>
                    Обновить пароль
                </x-forms.primary-button>


                <x:slot:socialAuth></x:slot:socialAuth>

                <x:slot:buttons></x:slot:buttons>

            </x-forms.auth-form>

        </div>
    </main>
@endsection
