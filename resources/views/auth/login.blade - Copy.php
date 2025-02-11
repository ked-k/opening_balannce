
<x-guest-layout>
    <x-slot:title>
        {{ __('Login | MERP') }}
        </x-slot>
        <div class="card mt-5 mt-lg-0">
            <div class="card-body">
                <div class="border p-4 rounded">
                    <div class="text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
                            <img src="{{ asset('assets/images/merp-logo.png') }}" alt="" style="width: 50%">
                        </div>
                        {{-- <h3 class="">{{ __('public.signin') }}</h3>
                        <hr> --}}
                        <br>
                    </div>
                    <div class="form-body">
                        <form method="POST" action="{{ route('login') }}" class="row g-3">
                            @csrf
                            @include('layouts.messages')
                            <div class="col-12">
                                <x-label for="inputEmailAddress">{{ __('public.email') }}</x-label>
                                <input type="email" class="form-control" id="inputEmailAddress"
                                    placeholder="Email Address" required name="email" value="{{ old('email') }}" autocomplete="off">
                            </div>
                            <div class="col-12">
                                <x-label for="inputChoosePassword">
                                    {{ __('public.password') }}</x-label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" class="form-control border-end-0" id="inputChoosePassword"
                                        placeholder="Enter Password" name="password" required> <a href="javascript:;"
                                        class="input-group-text bg-transparent" autocomplete="off"><i class='bx bx-hide'></i></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                        name="remember">
                                    <x-label class="form-check-label" for="flexSwitchCheckChecked">
                                        {{ __('public.rememberme') }}</x-label>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">{{ __('public.forgotpass') }}</a>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <x-button class="btn-success">{{ __('public.login') }}</x-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-guest-layout>
