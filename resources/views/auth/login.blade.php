<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <img src="{{ asset('public/images/default/ProPic.jpg') }}" width="100" height="100" class="brand-image img-circle elevation-3"
           style="opacity: .8"> --}}
           <img src="{{ asset('public/images/default/ProPic.jpg') }}" width="200" height="200" class="brand-image img-circle elevation-3"
           style="opacity: .8">
            {{-- <x-jet-authentication-card-logo /> --}}
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label value="Email" />
                <x-jet-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label value="Password" />
                <x-jet-input class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('Login') }}
                </x-jet-button>
            </div>
        </form>
        <br>

        <div class="flex items-center justify-center mt-4">
            <strong>Email: admin@demo.com</strong>
        </div>
        <div class="flex items-center justify-center mt-4">
            <strong>Password: admindemo</strong>
        </div>



        <br>

        <footer class="main-footer">
            <strong>Copyright &copy; 2020 <a href="#" target="_blank">OronnokIT</a>.</strong>
            All rights reserved.       
        </footer>


    </x-jet-authentication-card>
</x-guest-layout>


