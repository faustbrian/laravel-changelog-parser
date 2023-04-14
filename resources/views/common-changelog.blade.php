# Changelog

@foreach ($releases as $release)
@include('changelog-parser::common-changelog-release', [
    'actingAsView' => true,
    'configuration' => $configuration,
    'release' => $release,
])
@endforeach

@if($configuration->includeTagReferences)
@foreach ($releases as $release)
@if ($release->tagReference)
[{{ $release->version }}]: {{ $release->tagReference }}
@endif
@endforeach
@endif
