@extends('template.main')

@section('content')
<div id="main-content">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Developers</h3>
                    <p class="text-subtitle text-muted">View and manage all developer options.</p>
                </div>
            </div>
        </div>
        
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Cache the Application Routes</h4>
            </div>
            <div class="card-body">
                <p>After adding a new feature that includes routes, remember to run <code>php artisan route:cache</code>, as the app may not automatically detect new routes.</p>
                
                <div class="row">
                    <div class="text-end">
                        <form action="{{ route('cache.routes') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">
                                Cache now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Reset and Seed Database with Dummy Data</h4>
            </div>
            <div class="card-body">
                <p>This will execute the command <code>php artisan migrate:fresh --seed</code>, which will delete the entire database and create dummy data.</p>
                
                <div class="row">
                    <div class="text-end">
                        <form action="{{ route('database.migrate.fresh.seed') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">
                                Execute now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>            
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if($errors->any())
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Oops, something went wrong.',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
</script>
@endpush