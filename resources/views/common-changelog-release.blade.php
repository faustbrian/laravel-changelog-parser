@if ($release->date)
@if ($release->tagReference && $configuration->includeTagReferences)
## [{{ $release->version }}] - {{ $release->date->toDateString() }}
@else
## {{ $release->version }} - {{ $release->date->toDateString() }}
@endif
@else
@if ($release->tagReference && $configuration->includeTagReferences)
## [{{ $release->version }}]
@else
## {{ $release->version }}
@endif
@endif
@foreach ($release->sections as $sectionTitle => $section)

### {{ $sectionTitle }}

{!! $section->content !!}
@endforeach

@if($configuration->includeTagReferences && empty($actingAsView))
@if ($release->tagReference)
[{{ $release->version }}]: {{ $release->tagReference }}
@endif
@endif
