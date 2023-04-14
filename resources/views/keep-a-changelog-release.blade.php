@if ($release->releaseDate)
## {{ $release->version }} - {{ $release->releaseDate->toDateString() }}
@else
## {{ $release->version }}
@endif
@foreach ($release->sections as $sectionTitle => $section)

### {{ $sectionTitle }}

@foreach ($section->entries as $sectionEntry)
- {{ $sectionEntry }}
@endforeach
@endforeach
