@if(session('status'))
    <div class="alert alert-info">
        {{ session('status') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('notice'))
    <div class="alert alert-notice">
        {{ session('notice') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger my-3">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
