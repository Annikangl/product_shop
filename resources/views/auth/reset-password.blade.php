@extends('layouts.auth')

@section('title', 'Восстановление пароля')

@section('content')
    <main class="md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-20">
        <div class="container">

            <x-forms.auth-form title="Восстановление пароля" action="">
                @csrf

                <x-forms.text-input
                    namme="email"
                    type="email"
                    :isError=" $errors->has('email')"
                    placeholder="E-mail"
                    required="true">
                </x-forms.text-input>

                @error('email')
                <x-forms.error>{{ $message }}</x-forms.error>
                @enderror

                <x-forms.text-input
                    namme="password"
                    type="password"
                    :isError=" $errors->has('password')"
                    placeholder="Пароль"
                    required="true">
                </x-forms.text-input>

                @error('password')
                <x-forms.error>{{ $message }}</x-forms.error>
                @enderror

                <x-forms.text-input
                    namme="password_confirmation"
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

                <x:slot:buttons></x:slot:buttons>

            </x-forms.auth-form>

        </div>
    </main>
@endsection
