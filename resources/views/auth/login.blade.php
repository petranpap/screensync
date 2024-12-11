<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="col-md-7">
        <h3>Login to <strong>Colorlib</strong></h3>
        <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group first">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="your-email@gmail.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="form-group last mb-3">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Your Password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0">
                    <span class="caption">Remember me</span>
                    <input id="remember_me" type="checkbox" name="remember" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" checked="checked" />
                    <div class="control__indicator"></div>
                </label>
                @if (Route::has('password.request'))
                    <span class="ml-auto">
                        <a class="forgot-pass" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    </span>
                @endif
            </div>

            <input type="submit" value="Log In" class="btn btn-block btn-primary">
        </form>
    </div>
</x-guest-layout>
