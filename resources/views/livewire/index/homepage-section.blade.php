{{-- <div class="livewire_section">

    @if($homepage_loaded)
    @include('website.index.bishes')
    @endif
    @include('website.index.arthatantra')
    @include('website.index.banking')
    @include('website.index.video')
    @include('website.index.factory')
    @include('website.index.purbadhar')
    @include('website.index.paryatan')
    @include('website.index.auto')
    @include('website.index.suchana')
    @include('website.index.corporate')
    @include('website.index.bichar')
  @include('website.index.pradesh')
    @include("website.index.antarbarta")
    @include('website.index.photo')

</div> --}}
 <div class="livewire_section">

    {{-- @if ($bishesh_section_load)
        @include('website.index.bishes')
    @endif --}}
    {{-- bishesh_section_load --}}
    @if ($arthatantra_section_load)
        @include('website.index.arthatantra')
    @endif
    @if ($banking_section_load)
        @include('website.index.banking')
    @endif
    @if ($video_section_load)
        @include('website.index.video')
    @endif
    @if ($factory_section_load)
        @include('website.index.factory')
    @endif
    @if ($purbadhar_section_load)
        @include('website.index.purbadhar')
    @endif
    @if ($purbadhar_section_load)
        @include('website.index.paryatan')
    @endif
    @if ($auto_mobiles_section_load)
        @include('website.index.auto')
    @endif
    @if ($suchana_section_load)
        @include('website.index.suchana')
    @endif
    @if ($corporate_section_load)
        @include('website.index.corporate')
    @endif
    @if ($bichar_section_load)
        @include('website.index.bichar')
    @endif
    @if($load_pradesh_section )
    @include('website.index.pradesh')
    @endif
    @if ($antarbarta_section_load)
        @include("website.index.antarbarta")
    @endif
    @if ($load_photo_section)
        @include('website.index.photo')
    @endif
</div>

