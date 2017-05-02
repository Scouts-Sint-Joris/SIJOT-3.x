<div class="panel panel-default">
    <div class="panel-heading">Menu:</div>
    <div class="list-group">
        <a href="{{ route('lease') }}" class="list-group-item @if (Request::route()->getName() === 'lease') active @endif">
            <span class="fa fa-btn fa-info-circle" aria-hidden="true"></span> Info
        </a>
        <a href="{{ route('lease.access') }}" class="list-group-item @if (Request::route()->getName() === 'lease.access') active @endif">
            <span class="fa fa-btn fa-map-signs" aria-hidden="true"></span> Bereikbaarheid
        </a>
        <a href="" class="list-group-item">
            <span class="fa fa-btn fa-calendar" aria-hidden="true"></span> Verhuur kalender
        </a>
        <a href="{{ route('lease.request') }}" class="list-group-item @if (Request::route()->getName() === 'lease.request') active @endif">
            <span class="fa fa-btn fa-plus" aria-hidden="true"></span> Verhuur aanvragen
        </a>
        <a href="mailto:verhuur@st-joris-turnhout.be" class="list-group-item">
            <span class="fa fa-btn fa-envelope" aria-hidden=""></span> Contacteer verantwoordelijke
        </a>
    </div>
</div>