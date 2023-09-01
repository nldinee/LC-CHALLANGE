<x-main>

    <div class="card">
        <div class="card-header px-2 py-3">
            <h3 class="card-title h3"> Statement of account {{ auth()->user()->id }}</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter">
                 <thead>
                    <tr>
                        <th>#</th>
                        <th>DATETIME</th>
                        <th>AMOUNT</th>
                        <th>TYPE</th>
                        <th>Details</th>
                        <th>BALANCE</th>
                    </tr>
                    </thead>
                <tbody class='text-muted'>
                    @foreach ($transactions as $transaction)
                        
                    
                    <tr>
                        <td class="text-muted">
                            {{ $loop->index + ($transactions->currentPage() == 1 ? 1 : (($transactions->currentPage() - 1) * 5) + 1) }}
                        </td>
                        <td>
                            {{ $transaction->created_at}}
                        </td>
                        <td>
                            {{ $transaction->amount}}
                        </td>
                        <td>
                            {{ ucfirst($transaction->type)}}
                        </td>
                        <td>
                            {{ $transaction->details }}
                        </td>
                        <td>
                            {{ $transaction->balance}}
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
            <ul class="pagination mt-3">
            @if ($transactions->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M15 6l-6 6l6 6"></path></svg>
                        prev
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $transactions->previousPageUrl() }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M15 6l-6 6l6 6"></path></svg>
                        prev
                    </a>
                </li>
            @endif

            @for ( $i = 1; $i <= $transactions->lastPage(); $i++)
                {{-- {{ $i }} --}}
                <li class="page-item{{ $transactions->currentPage() === $i ? ' active' : '' }}">
                    <a class="page-link" href="{{ $transactions->url($i) }}">{{ $i  }}</a>
                </li>
            @endfor

            @if ($transactions->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $transactions->nextPageUrl() }}">
                        next
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l6 6l-6 6"></path></svg>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                        next
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l6 6l-6 6"></path></svg>
                    </a>
                </li>
            @endif
        </ul>

        </div>
    </div>


</x-main>