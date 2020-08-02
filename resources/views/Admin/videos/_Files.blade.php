@section('script')
    <script>
        function removeProductImage(id){
            $.ajax({
                method: "GET",
                url: '{{route('videos.files.delete')}}',
                data:{id},
                success:function (response) {
                    if(response === 'success'){
                        $('#videoId').slideUp(200);
                        setTimeout(function () {
                            $('#videoId').remove();
                        },500);
                    }
                }
            })
        }
        const player = new Plyr('#player');
        @if(Route::currentRouteName() == 'videos.edit')
        $("#posterEdit").fileinput({
            showUpload:false,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            overwriteInitial: true,
            initialPreviewAsData: true,
            initialPreview: [
                "{{asset($video->picUrl)}}",
            ],
            initialPreviewConfig: [
                { url: "{{asset($video->picUrl)}}", key: 1},
            ],
            previewFileType:'image',
            language: 'fa',
            showRemove: false,
        });
        $("#videoEdit").fileinput({
            showUpload:false,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            overwriteInitial: true,
            initialPreviewAsData: true,
            initialPreview: [
                "{{asset($video->videoUrl)}}",
            ],
            initialPreviewConfig: [
                { url: "{{asset($video->videoUrl)}}", key: 1},
            ],
            allowedFileTypes:["video","wmv","mp4"],
            language: 'fa',
            showRemove: false,
        });

        @else
        $("#posterCreate").fileinput({
            language: 'fa',
            showUpload:false,
            previewFileType:['image'],
            browseClass: "btn btn-dark",
            browseStyle: "cursor:pointer"
        });
        $("#videoCreate").fileinput({
            language: 'fa',
            showUpload:false,
            previewFileType:'video',
            allowedFileTypes:["video","wmv","mp4"],
            maxFileSize: 1024 * 10 * 1024,
            browseClass: "btn btn-dark",
            browseStyle: "cursor:pointer"
        });
        @endif
    </script>
@endsection
