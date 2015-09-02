@if($alerts = session('alerts'))
    @foreach($alerts as $type => $message)
        <div class="alert alert-{{ $type }} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>
                @if($type == 'success')
                    Well done!
                @elseif($type == 'info')
                    Heads up!
                @elseif($type == 'warning')
                    Warning!
                @elseif($type == 'danger')
                    Oh snap!
                @endif
            </strong> {{ $message }}
        </div>
    @endforeach
@endif