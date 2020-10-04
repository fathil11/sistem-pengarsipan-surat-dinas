<form action="/surat/masuk/{{ $id }}/download"
    method="POST" class="d-inline">
    @csrf
    @method('post')
    <button type="submit" class="btn btn-secondary p-2"><i
            class="mdi mdi-download menu-icon"></i></button>
</form>
