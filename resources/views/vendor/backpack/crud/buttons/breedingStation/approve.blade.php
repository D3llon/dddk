@if($entry->status === 'pending')
    <a href="{{ route('admin.breeding-station.approve', ['id' => $entry->id]) }}" class="btn btn-success"><i class="la la-check-circle"></i> Schváliť</a>
@endif