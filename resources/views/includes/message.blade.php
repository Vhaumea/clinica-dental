@if(session('message'))
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: "{{ session('message') }}",
            confirmButtonText: 'Cerrar'
        });
    });
</script>
@endif
