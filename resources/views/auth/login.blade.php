@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="login-form">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('login-form').addEventListener('submit', function (event) {
        event.preventDefault();
        const target = event.target;

        fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': target._token.value
            },
            body: JSON.stringify({ 
                email: target.email.value, 
                password: target.password.value
            }),
            credentials: 'same-origin'
        })
        .then(response => {
            console.log('response', response.status);
            // check response status and do certain task for each response
            if (response.status === 200) { 
                this.reset();
                return window.location.href = '{{ route("home") }}';
            } else {
                // errors are found, return response as json
                return response.json();
            }
        })
        .then(errorArr => {
            console.log(errorArr);
            if (!errorArr) return;
            const errors = errorArr.errors;
            const firstItem = Object.keys(errors)[0];
            const firstItemDom = document.getElementById(firstItem);
            const firstItemErr = errors[firstItem];

            // clear existing error highlights so that when the input is valid, it will no longer highlight
            const textBoxHighlight = document.querySelectorAll('.form-control');
            textBoxHighlight.forEach(element => element.classList.remove('border', 'border-danger'));

            // clear existing error messages so that when the input is valid, it will no longer display
            const textDanger = document.querySelectorAll('.text-danger');
            textDanger.forEach(element => element.textContent = null);

            firstItemDom.classList.add('border', 'border-danger');

            const message = `<div class='text-danger'>${firstItemErr}</div>`;
            firstItemDom.insertAdjacentHTML('afterend', message);
        })
        .catch(err => err ? err : null);
    });
</script>
@endsection
