@if (Auth::user()->image)
    <div class="row justify-content-center">
        <div class="container-avatar">
            <img src="{{ route('user.avatar', ['filename' => Auth::user()->image]) }}" class="avatar" style="width: 200px; border-radius: 50%;"/>
        </div>
    </div>
@endif
