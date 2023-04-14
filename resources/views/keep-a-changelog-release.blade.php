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

@foreach ($section->entries as $sectionEntry)
- {!! $sectionEntry !!}
@endforeach
@endforeach

@if($configuration->includeTagReferences && empty($actingAsView))
@if ($release->tagReference)
[{{ $release->version }}]: {{ $release->tagReference }}
@endif
@endif
