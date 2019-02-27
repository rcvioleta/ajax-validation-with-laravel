<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post Request with AJAX</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{ route('post-login') }}" method="POST" id="login-form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Login</button>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
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
                    username: target.username.value, 
                    password: target.password.value
                }),
                credentials: 'same-origin'
            })
            .then(response => {
                console.log(response.status);
                // check response status and do certain task for each response
                if (response.status === 200) { 
                    // console.log('success!');
                    return response.json();
                    // this.reset();
                    // return window.location.href = '{{ route("welcome") }}';
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
</body>
</html>