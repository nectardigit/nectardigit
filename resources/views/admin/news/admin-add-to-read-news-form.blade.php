<div class="row">

    <div class="col-lg-12">
        <div class="col-lg-12">
            {!! Form::button('Add To Read This', ['class' => 'btn btn-sm btn-info', 'value' => 'Add To Read This', 'id' => 'addtoreadthis']) !!}
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="add_to_read_this_news_filter">
                <h3>Add To Read this news </h3>
                <div class="form-group row {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                    {{-- {{ Form::label('meta_title', 'Search News Title :', ['class' => 'col-sm-12']) }} --}}

                    <div class="col-lg-12">
                        <div class="news_items">
                            @include('admin.news.news-title-list')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@if(!isset($news_items) || !$news_items->count())
    <script>
        $(".add_to_read_this_news_filter").toggle();
    </script>
@endif
<script>
    
    $(document).ready(function() {
        $(document).on('click', ".page-link", function() {

            //  alert('clickc')
            var url = $(this).attr('href');
            var page = getdataofurl(url, 'page');
            var keyword = getdataofurl(url, 'keyword');
            getNewsData(keyword, page);
            return false; // prevent default browser refresh on "#" link

            // unbind("click")
        });

        function getdataofurl(url, name) {
            var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
            if (results == null) {
                return null;
            }
            return decodeURI(results[1]) || 0;
        }
        
        function getNewsData(keyword,page){
            $.ajax({
                    url: "{{ route('getNewsByAdminSearch') }}",
                    method: "GET",
                    data: {
                        keyword: keyword,
                        page: page
                    },
                    success: function(response) {
                        if (response.status) {
                            $('.news_items').html(response.html);
                        } else {
                            $('.news_items').html('');
                        }
                    }
                })
        }
        $('#addtoreadthis').on('click', function() {

            if ($('.add_to_read_this_news_filter').is(':hidden')) {
                if ($("#np_title").length) {
                    var keyword = $('#np_title').val();
                } else if ($("#en_title").length) {
                    var keyword = $('#en_title').val();
                }
                getNewsData(keyword, 1);
            }
            $(".add_to_read_this_news_filter").toggle(400);
        })
    })

</script>
