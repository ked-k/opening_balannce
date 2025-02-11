<x-guest-layout>
    <x-slot:title>
        {{ __('Forgot Password | UMEME') }}
        </x-slot>
        <!-- Password recovery form -->
        <div class="card mt-5 mt-lg-0">
            <div class="card-body">
                <div class="border p-4 rounded">
                    <div class="text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                            <img src="{{ asset('assets/images/merp-logo.png') }}" alt="" style="width: 50%">
                        </div>
                        <h3 class="">{{ __('public.forgotpass') }}</h3>
                        <span
                            class="d-block text-muted">{{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</span>
                    </div>
                    <div class="form-body">
                        <form class="row g-3" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            @include('layouts.messages')
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <div class="col-12">
                                <x-label for="inputEmailAddress" class="fw-bold">{{ __('public.email') }}</x-label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    required autofocus autocomplete="off">
                            </div>

                            <div class="col-12">
                                <div class="d-grid">
                                    <x-button class="btn-success">{{ __('public.sendlink') }}</x-button>
                                    <a href="{{ route('login') }}"
                                        class="btn btn-lg btn-light mt-2">{{ __('public.backtologin') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- /password recovery form -->
</x-guest-layout>
