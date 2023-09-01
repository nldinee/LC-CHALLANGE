<!-- resources/views/tasks.blade.php -->
 
<x-login>
    
    <div class='container py-4'>

        <div class='text-center mb-4'>
            <h1 class='h1'>ABC BANK</h2>
        </div>

        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 mb-4">Login to your account</h2>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif

                <form method="POST" action="{{ route('register') }}" >
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter name" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Enter email" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter password" />
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-check">
                            <input class="form-check-input" name='agreed_to_terms' type="checkbox" value='1'>
                            <span class="form-check-label"> Agree the <a href='{{ route('legal') }}'>terms and policy</a> </span>
                        </label>
                    </div>

                    <button class='btn btn-primary w-100'>
                        Sign Up
                    </button>

                </form>

            </div>
        </div>

        <div class='text-center text-muted mt-4'>
            Don't have account yet? <a href='{{ route('login') }}'>Sign In</a>
        </div>

    </div>

</x-login>