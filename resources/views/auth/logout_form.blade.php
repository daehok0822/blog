<form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
    @if(config('adminlte.logout_method'))
        {{ method_field(config('adminlte.logout_method')) }}
    @endif
    {{ csrf_field() }}
</form>
