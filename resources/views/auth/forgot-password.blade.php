@extends('layouts.auth')

@section('title', 'Забыли пароль')

@section('content')
    <main class="md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-20">
        <div class="container">

            <x-forms.auth-form title="Забыли пароль?" action="{{ route('password.email') }}" method="POST">
                @csrf

                <x-forms.text-input
                    name="email"
                    type="email"
                    :isError=" $errors->has('email')"
                    value="{{ request('email') }}"
                    placeholder="E-mail"
                    required="true">
                </x-forms.text-input>

                @error('email')
                <x-forms.error>{{ $message }}</x-forms.error>
                @enderror

                <x-forms.primary-button>
                    Отправить
                </x-forms.primary-button>

                <x:slot:socialAuth></x:slot:socialAuth>

                <x:slot:buttons>
                    <div class="space-y-3 mt-5">
                        <div class="text-xxs md:text-xs"><a href="{{ route('login') }}"
                                                            class="text-white hover:text-white/70 font-bold">Войти в аккаунт</a>
                        </div>
                    </div>
                </x:slot:buttons>

            </x-forms.auth-form>

        </div>
    </main>
@endsection
