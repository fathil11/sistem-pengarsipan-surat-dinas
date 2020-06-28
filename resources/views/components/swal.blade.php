<script src="/js/swal2.js"></script>
@if (session()->has('success'))
<script>
    swal(
        'Berhasil',
        '{{ session('success') }}',
'success'
)
</script>
@endif
@if ($errors->any())
@php
$err = '';
foreach($errors->all() as $error){
$err .= '<li>' . $error . '</li>';
}
@endphp
<script>
    swal(
        'Ups,',
        '{!! $err !!}',
        'error'
        )
</script>
@endif
