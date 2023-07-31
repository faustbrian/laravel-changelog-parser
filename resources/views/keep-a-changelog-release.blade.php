@if ($release->getDate())
@if ($release->getTagReference() && $configuration->includeTagReferences)
## [{{ $release->getVersion() }}] - {{ $release->getDate()->toDateString() }}@if ($release->isYanked()) [YANKED]@endif
@else
## {{ $release->getVersion() }} - {{ $release->getDate()->toDateString() }}@if ($release->isYanked()) [YANKED]@endif
@endif
@else
@if ($release->getTagReference() && $configuration->includeTagReferences)
## [{{ $release->getVersion() }}]@if ($release->isYanked()) [YANKED]@endif
@else
## {{ $release->getVersion() }}@if ($release->isYanked()) [YANKED]@endif
@endif
@endif
@foreach ($release->getSections() as $sectionTitle => $section)

### {{ $sectionTitle }}

@foreach ($section->getItems() as $sectionItem)
- {!! $sectionItem->toString() !!}
@endforeach
@endforeach

@if($configuration->includeTagReferences && empty($actingAsView))
@if ($release->getTagReference())
[{{ $release->getVersion() }}]: {{ $release->getTagReference() }}
@endif
@endif
