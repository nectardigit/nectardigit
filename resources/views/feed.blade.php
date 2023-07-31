@php
    $pattern = "/[\?\.\|]/";
@endphp

<rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/" version="2.0"
    nighteye="disabled">
    <channel>
        <language>en</language>
        <title> {{ $appSetting->name }}</title>
        <atom:link href="{{ route('feed') }}" rel="self" type="application/rss+xml" />
        <link>{{ route('index') }}</link>
        <description>Nectr Digit</description>
        <image>
            <url>{{ route('index') }}</url>
            <title>Nectr Digit</title>
            <link> {{ route('index') }} </link>
        </image>
        @foreach ($blog as $item)
        <item>
            {{-- {{dd($item)}} --}}
            <title>{{ $item->title }}</title>
            <link> {{ route('detailpage',$item->slug) }} </link>
            <description>
                <![CDATA[" {!! limit_words(html_entity_decode($item->description), 200) !!} "]]>
            </description>
            <guid isPermaLink="false">{{ route('detailpage',$item->slug) }}</guid>
            <pubDate>{{ $item->created_at->tz('Asia/Kathmandu')->isoFormat('lLLL z') }}</pubDate>
        </item>
        @endforeach

        @foreach ($service as $item)
        <item>
            {{-- {{dd($item)}} --}}
            <title>{{ $item->title }}</title>
            <link> {{ route('detailpage',$item->slug) }} </link>
            <description>
                <![CDATA[" {!! limit_words(html_entity_decode($item->description), 200) !!} "]]>
            </description>
            <guid isPermaLink="false">{{ route('detailpage',$item->slug) }}</guid>
            <pubDate>{{ $item->created_at->tz('Asia/Kathmandu')->isoFormat('lLLL z') }}</pubDate>
        </item>
        @endforeach

    </channel>
</rss>
