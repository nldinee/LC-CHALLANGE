<x-main>

@if(session('success'))
    <div class="alert alert-success mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h2 class="card-title"> Transfer Money </h2>
    </div>
    
    <div class="card-body">
        
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endforeach
        @endif

        <form method='POST' action="{{ route('transfer') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" name="email" placeholder="Enter email" />
            </div>

            <div class="mb-3">
                <label class="form-label">Amount</label>
                <input type="number" step="0.01" class="form-control" name="amount" placeholder="Enter amount to transfer" />
            </div>

            <button class='btn btn-primary w-100'>
                 Transfer
            </button>

        </form>
    </div>
</div>

</x-main>