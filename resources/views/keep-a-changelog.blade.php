# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).
@foreach ($releases as $release)

@if ($release->releaseDate)
@if ($release->tagReference)
## [{{ $release->version }}] - {{ $release->releaseDate->toDateString() }}
@else
## {{ $release->version }} - {{ $release->releaseDate->toDateString() }}
@endif
@else
@if ($release->tagReference)
## [{{ $release->version }}]
@else
## {{ $release->version }}
@endif
@endif
@foreach ($release->sections as $sectionTitle => $section)

### {{ $sectionTitle }}

@foreach ($section->entries as $sectionEntry)
- {{ $sectionEntry }}
@endforeach
@endforeach
@endforeach

@foreach ($releases as $release)
@if ($release->tagReference)
[{{ $release->version }}]: {{ $release->tagReference }}
@endif
@endforeach
