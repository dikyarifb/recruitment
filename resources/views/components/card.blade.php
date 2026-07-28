@php
    $id = $id ?? 'collapse';
    $open = $open ?? true;
@endphp
<div class="card {{$class ?? ''}}">
    <div class="p-{{$padding ?? 4}} card-body collapse @if($open == true) show @endif" id="{{$id}}">
        {{$slot}}
    </div>
</div>