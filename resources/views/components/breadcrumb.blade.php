@props(['items' => []])

@if(! empty($items))
    <nav class="breadcrumb" aria-label="Breadcrumb">
        <ol>
            @foreach($items as $item)
                <li>
                    @if($loop->last)
                        <span aria-current="page">{{ $item['name'] }}</span>
                    @else
                        <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
