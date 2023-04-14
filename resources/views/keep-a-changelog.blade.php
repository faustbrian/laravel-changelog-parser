# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

@foreach ($releases as $release)
@include('changelog-parser::keep-a-changelog-release', [
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
