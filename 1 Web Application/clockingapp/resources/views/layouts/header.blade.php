<section class="cl-header">
    <div class="cl-header-content">
        <div class="cl-header-left">
            <h3><a href="{{route('home')}}">{{config('app.name')}}</a></h3>
            <p>{{ Auth::user()->email }} ({{Auth::user()->type}})</p>
        </div>
        <div class="cl-header-menu">
            <ul>
                <li><a href="{{route('reports')}}">Reports</a></li>
                @if(Auth::user()->type == "admin")
                <li><a href="{{route('users')}}">Users</a></li>
                @endif
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                Log Out
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </div>
    </div>
</section>