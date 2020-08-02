@section('script')
    <script>
        function removeProductImage(id){
            $.ajax({
                method: "GET",
                url: '{{route('products.files.delete')}}',
                data:{id},
                success:function (response) {
                    if(response === 'success'){
                        $('#gallery'+id).slideUp(200);
                        setTimeout(function () {
                            $('#gallery'+id).remove();
                        },500);
                    }
                }
            })
        }
        @if(Route::currentRouteName() == 'products.edit')
        $("#posterEdit").fileinput({
            showUpload:false,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            overwriteInitial: true,
            initialPreviewAsData: true,
            initialPreview: [
                "{{asset($product->url)}}",
            ],
            initialPreviewConfig: [
                { url: "{{asset($product->url)}}", key: 1},
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
            browseStyle: "cursor:pointer",
            showZoom: false,
        });
        @endif
        $('#files').fileinput({
            language: 'fa',
            maxFileCount: 5,
            showUpload:false,
            showRemove: false,
            allowedFileTypes: ["image"],
            showZoom: false,
        });

        $('.selectpicker').selectpicker();
    </script>
@endsection
