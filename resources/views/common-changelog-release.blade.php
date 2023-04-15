@if ($release->getDate())
@if ($release->getTagReference() && $configuration->includeTagReferences)
## [{{ $release->getVersion() }}] - {{ $release->getDate()->toDateString() }}
@else
## {{ $release->getVersion() }} - {{ $release->getDate()->toDateString() }}
@endif
@else
@if ($release->getTagReference() && $configuration->includeTagReferences)
## [{{ $release->getVersion() }}]
@else
## {{ $release->getVersion() }}
@endif
@endif
@foreach ($release->getSections() as $sectionTitle => $section)

### {{ $sectionTitle }}

{!! $section->getContent() !!}
@endforeach

@if($configuration->includeTagReferences && empty($actingAsView))
@if ($release->getTagReference())
[{{ $release->getVersion() }}]: {{ $release->getTagReference() }}
@endif
@endif
