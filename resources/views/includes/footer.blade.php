<!-- resources/views/includes/footer.blade.php -->
@if (!Request::is('login') && !Request::is('password/email') && !Request::is('password/reset'))
<footer class="main-footer bg-white text-gray-800 py-2">
    <div class="container mx-auto text-center">
        <p>&copy; {{ date('Y') }} Dental Jen. All rights reserved.</p>
        <p>Powered by <a href="https://laravel.com" class="text-blue-500">Laravel</a></p>
    </div>
</footer>
@endif