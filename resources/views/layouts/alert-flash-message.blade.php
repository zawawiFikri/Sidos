@if(session('success'))
<div id="success-alert" class="alert alert-success alert-dismissable fade show">
    <i class="far fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('warning'))
<div id="warning-alert" class="alert alert-warning alert-dismissable fade show">
    <i class="bi bi-exclamation-triangle"></i> {{ session('warning') }}
    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle"></i>
    <strong>Gagal !</strong>
    <ul>
        <div class="row" style="margin-top:5px;">
            @foreach($errors->all() as $message)
            <div class="col-md-12">
                <li style="margin-bottom:5px;">{{ $message }}</li>
            </div>
            @endforeach
        </div>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<script>
    // Menggunakan JavaScript untuk menyembunyikan alert setelah beberapa detik
    setTimeout(function() {
        document.getElementById('success-alert').style.display = 'none';
    }, 5000);

    setTimeout(function() {
        document.getElementById('warning-alert').style.display = 'none';
    }, 5000);

    setTimeout(function() {
        document.getElementById('error-alert').style.display = 'none';
    }, 5000);
</script>
