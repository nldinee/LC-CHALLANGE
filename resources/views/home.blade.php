<x-main>

    <div class="card">
        <div class="card-header px-2 py-3">
            <h3 class="card-title h3">Welcome, {{ Auth::user()->name }}</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter">
                
                <tbody>
                    <tr>

                        <td class="text-muted">
                            Your ID
                        </td>
                        <td>
                            {{ Auth::user()->email }}
                        </td>
                        
                    </tr>
                    <tr>

                        <td class="text-muted">
                            Your Balance
                        </td>
                        <td>
                            {{ Auth::user()->balance  }} {{ Auth::user()->currency }}
                        </td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


</x-main>