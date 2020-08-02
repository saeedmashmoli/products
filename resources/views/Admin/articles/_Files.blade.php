@section('script')
    <script>
        @if(Route::currentRouteName() == 'articles.edit')
        $("#posterEdit").fileinput({
            showUpload:false,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            overwriteInitial: true,
            initialPreviewAsData: true,
            initialPreview: [
                "{{asset($article->url)}}",
            ],
            initialPreviewConfig: [
                { url: "{{asset($article->url)}}", key: 1},
            ],
            previewFileType:'image',
            language: 'fa',
            showRemove: false,
        });
        @else
        $("#posterCreate").fileinput({
            language: 'fa',
            showUpload:false,
            previewFileType:'image',
            browseClass: "btn btn-dark",
            browseStyle: "cursor:pointer"
        });
        @endif
        CKEDITOR.replace('body',{
            
            filebrowserUploadUrl : '{{route('uploadImageForText')}}',
            filebrowserUploadMethod: 'xhr',
            fileTools_requestHeaders: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{csrf_token()}}',
            }
        });
    </script>
@endsection
